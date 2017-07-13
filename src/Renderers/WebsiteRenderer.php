<?php

namespace P3in\Renderers;

use Exception;
use P3in\Models\Website;
use P3in\Storage;
use P3in\Models\StorageConfig;
use P3in\Models\Role;
use P3in\Notifications\DeploymentStatus;

class WebsiteRenderer
{
    private $website;
    private $build;
    private $disk;
    // @TODO: we use this in both builder and renderer, we should establish who's in charge of running commands on the disk instance.
    public $commandOutputs = [];

    public function __construct(Website $website, Storage $disk = null)
    {
        $this->website = $website;
        $this->disk = $disk ?? $website->getDisk();
    }

    public function setDisk(Storage $disk)
    {
        $this->disk = $disk;
    }

    public function getStorePath()
    {
        return $this->disk->getAdapter()->getPathPrefix();
    }

    // Methods for Vue Route format output of all pages
    // @TODO: we prob want to move this to something else, like WebsiteBuilder maybe
    public function buildRoutesTree($pages = null)
    {
        $pages = $this->website->pages()
            ->byAllowedRole()
            ->with('sections')
            ->get();

        $rtn = [];
        foreach ($pages->unique('layout.name')->pluck('layout.name') as $layout) {
            if ($layout) {
                $rtn[] = [
                    'path' => '',
                    'component' => $layout,
                    'children' => $this->formatRoutesBranch($pages->where('layout.name', $layout))
                ];
            }
        }

        return $rtn;
    }

    // Used to publish local install files to their disk dest.
    public function publish(string $from, $subDir = '')
    {
        // in memory, we don't need a physical record for the source files.
        $fromDisk = (new StorageConfig([
            'name' => $from,
            'config' => ['driver' => 'local', 'root' => $from],
        ]))->set()->getDisk();
        foreach ($fromDisk->allFiles() as $file) {
            $this->put($subDir.$file, $fromDisk->get($file));
        }
    }

    public function getDeploymentSource()
    {
        if (!$depConfig = $this->website->config->deployment) {
            throw new Exception('The website does not have deployment settings configured');
        }
        if (empty($depConfig->publish_from)) {
            throw new Exception('A source directory where the page components can be found has not been specified.');
        }

        if (is_null($path = realpath($depConfig->publish_from))) {
            throw new Exception("The publish directory '{$depConfig->publish_from}' doesn't exist.");
        }

        return $path;
    }

    /**
     * { function_description }
     *
     * @param      <type>  $diskInstance  The disk instance
     */
    public function compile()
    {
        $from_path = $this->getDeploymentSource();

        // publish CMS common files
        $this->publish(realpath(__DIR__.'/../Templates/common'));

        // publish website specific (static) files.
        $this->publish($from_path, 'src/');

        // build page sections and form builder component libs.
        $this->buildComponentLibs();

        // Build the router.js file
        $this->buildRouter();

        // Build nginx server configurations.
        $this->buildServerConfig();

        return $this;
    }

    /**
     * Private Methods
     **/

    private function formatRoutesBranch($pages)
    {
        $rtn = [];
        foreach ($pages as $page) {
            // cp pages are like any other, so we use the sections to define the view type
            // (handy if we ever decided to change a view type for a page).
            $section = $page->sections->first();
            $meta = (object) $page->meta;
            $meta->title = $page->title;
            $rtn[] = [
                'path' => $page->url,
                'name' => $page->getMeta('resource') ?? $page->slug,
                'meta' => $meta,
                // might need to be worked out for CP, at least discussed to see if we want to go this route.
                'component' => $section ? $section->template : null,
            ];
        }
        return $rtn;
    }

    private function buildComponentLibs()
    {
        // @TODO: consider moving form builder components to Templates/common and
        // only rebuild when new fields are introduced from future modules.
        $components_dir = 'src/components';

        $pagesections = [];
        $formfields = [];

        foreach ($this->disk->allFiles($components_dir) as $component) {
            $file = pathinfo($component);
            if ($file['extension'] == 'vue' && $file['filename']) {
                switch ($file['dirname']) {
                    case $components_dir.'/FormBuilder':
                    $formfields[ucwords($file['filename'])] = './FormBuilder/'.$file['filename'];
                    break;
                    case $components_dir:
                    $pagesections[ucwords($file['filename'])] = './'.$file['filename'];
                    break;
                }
            }
        }
        $this->buildImports($components_dir.'/index.js', $pagesections);
        $this->buildImports($components_dir.'/formfields.js', $formfields);
    }

    private function buildImports(string $fileName, array $components)
    {
        $this->renderView('components', [
            'components' => $components,
        ], $fileName);

        return $this;
    }

    private function buildRouter()
    {
        $pages = $this->website->pages;

        $this->renderView('router', [
            'imports' => $this->formatImports($pages),
            'routes' => $this->formatRoutes($pages),
            'base_url' => $this->website->scheme.'://'.$this->website->host.'/api/',
            //@NOTE: not needed since all sites we implement use reverse proxy header value instead.  but here for ref.
            // 'headers' => $this->formatJson(['Site-Host' => $this->website->host]),
        ], 'src/router.js');

        return $this;
    }

    private function formatImports($pages)
    {
        $rtn = '';
        foreach ($pages as $page) {
            $file = str_replace('/', '-', trim($page->url, '/'));
            $name = $file ? $file : 'home';
            $rtn .= "const {$page->template_name} = r => require.ensure([], () => r(require('./pages/{$file}')), 'pages')\n";
        }
        return $rtn;
    }

    private function formatRoutes($pages)
    {
        $pieces = [];
        foreach ($pages as $page) {
            $pieces[] = "{path: '{$page->url}', component: {$page->template_name}}";
        }
        return implode(', ', $pieces);
        return $rtn;
    }

    private function buildServerConfig()
    {
        if (!$this->disk->exists('ssl/dhparam.pem')) {
            // @TODO: add command to generate SSL Cert from letsencrypt if the user selected to use letsencrypt.
            $server = $this->website->storage->getContainer();

            // // @TODO: needs error handling.  Also, we assume this is a Linux server.
            // We'll need to abstract this to the "container" to simply generate the dhparam.pem file.
            $this->commandOutputs[] = $server->runCommand('openssl dhparam -out dhparam.pem 4096', 'ssl');
        }

        // @TODO: permissions must be set to writable by the server (i.e. nginx/apache user)
        $this->disk->makeDirectory('logs');

        $this->renderView('nginx-redirects', [
            'redirects' => $this->website->redirects,
            'website' => $this->website,
        ], 'nginx-redirects.conf');

        $this->renderView('nginx-vhost', [
            'website' => $this->website,
            'storage' => $this->website->storage,
        ], 'nginx-vhost.conf');

        return $this;
    }
    // @TODO: below two methods can be used for both Website and Page Renderers, abstract to a trait or base class.
    private function renderView(string $view, array $data, string $filename)
    {
        $contents = view("pilot-io::{$view}", $data)->render();

        $this->put($filename, $contents);
    }

    private function put(string $filePath, string $contents)
    {
        $this->disk->put($filePath, $contents);
    }
}
