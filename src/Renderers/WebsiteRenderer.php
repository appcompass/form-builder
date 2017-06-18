<?php

namespace P3in\Renderers;

use Exception;
use P3in\Models\Website;
use P3in\Storage;
use P3in\Models\StorageConfig;

class WebsiteRenderer
{
    private $website;
    private $build;
    private $disk;
    private $rootDir = '';

    public function __construct(Website $website, Storage $disk = null)
    {
        $this->website = $website;
        $this->disk = $disk ?? Storage::disk('websites_root');
    }

    public function setRootDir(string $path)
    {
        $this->rootDir = $path;

        return $this;
    }

    public function getStorePath()
    {
        $basePath = $this->disk->getAdapter()->getPathPrefix();

        return $this->rootDir ? $basePath.'/'.$this->rootDir : $basePath;
    }

    public function getDistBuildFiles()
    {
        $files = [];
        $basePath = $this->rootDir;
        foreach ($this->disk->allFiles($basePath) as $file) {
            $key = substr($file, strlen($basePath));
            $files[$key] = $this->disk->get($file);
        }

        return $files;
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
        foreach ($pages->unique('layout')->pluck('layout') as $layout) {
            if ($layout) {
                $rtn[] = [
                    'path' => '',
                    'component' => $layout,
                    'children' => $this->formatRoutesBranch($pages->where('layout', $layout))
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
    public function store()
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
        $this->renderView('nginx-redirects', [
            'redirects' => $this->website->redirects,
            'website' => $this->website,
        ], 'nginx-redirects.conf');

        // @TODO: Values to add/move to the Deployment section of the website management form (Note: we might want to split it into it's own form/page UI wise as it does have some unique functionality, i.e deploying)
        // listen_ip
        // listen_port (uses scheme 80/443 only for now)
        // server_names (repeatable text field for all host names associated with website)
        // disk selection and value management (part of why we may want to move deloyment to it's own screen and call it Configuration)
        // client_max_body_size value i.e. 100M, 300M, 500000M etc for max upload file size.
        // SSL Cert generation (including dhparam.pem and letsencrypt cert)
        // api_url (used for the reverse proxy)
        // ssr_url (used for ssr server, normally 127.0.0.1:3000 but we will prob need to allow this to be dynamic in order to allow multiple websites in a single server each with their own SSR service)

        // @TODO: add following form settings.
        //
        // @TODO: add command to generate this.
        // ssl_dhparam {{$storage->root}}/ssl/dhparam.pem;
        // create the /logs/ folder but file can be ignored.  NOTE: permissions must be set to writable by the server (i.e. nginx/apache user)
        // access_log {{$storage->root}}/logs/www-access.log;
        // error_log {{$storage->root}}/logs/www-error.log;

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
        $rootDir = $this->rootDir ? $this->rootDir.'/' : '';
        $this->disk->put("{$rootDir}{$filePath}", $contents);
    }
}
