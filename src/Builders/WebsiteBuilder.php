<?php

namespace P3in\Builders;

use Closure;
use Exception;
use Illuminate\Support\Facades\App;
use P3in\Builders\MenuBuilder;
use P3in\Builders\PageBuilder;
use P3in\Models\Gallery;
use P3in\Models\Layout;
use P3in\Models\Page;
use P3in\Models\Menu;
use P3in\Models\PageContent;
use P3in\Models\Section;
use P3in\Models\StorageConfig;
use P3in\Models\User;
use P3in\Models\Website;
use P3in\PublishFiles;
use Symfony\Component\Process\Process;

class WebsiteBuilder
{

    /**
     * Page instance
     */
    private $website;

    /**
     * Storage manager
     */
    private $manager;

    public function __construct(Website $website = null)
    {
        if (!is_null($website)) {
            $this->website = $website;
        }
    }

    /**
     * new
     *
     * @param      Website  $website   The Website
     *
     * @return     <type>   ( description_of_the_return_value )
     */
    public static function new($name, $scheme, $host, Closure $closure = null) : WebsiteBuilder
    {
        $instance = new static(Website::create([
            'name' => $name,
            'scheme' => $scheme,
            'host' => $host,
        ]));

        $instance->setGallery();

        if ($closure) {
            $closure($instance);
        }

        return $instance;
    }

    /**
     * edit
     *
     * @param      <type>       $page  The page being edited
     *
     * @throws     \Exception   Website must be set
     *
     * @return     WebsiteBuilder  WebsiteBuilder instance
     */
    public static function edit($website) : WebsiteBuilder
    {
        if (!$website instanceof Website && !is_int($website)) {
            throw new Exception('Must pass id or Website instance');
        }

        if (is_int($website)) {
            $website = Website::findOrFail($website);
        }

        return new static($website);
    }

    /**
     * Adds a page.
     *
     * @param      <type>       $title  The title
     * @param      <type>       $slug   The slug
     *
     * @return     PageBuilder  ( description_of_the_return_value )
     */
    public function addPage($title, $slug)
    {
        $page = new Page([
            'title' => $title,
            'slug' => $slug,
        ]);

        $page = $this->website->addPage($page);

        return new PageBuilder($page);
    }

    public function setGallery()
    {
        $gallery = new Gallery(['name' => $this->website->host]);
        $sysUser = User::SystemUsers()->firstOrFail();

        $gallery->user()->associate($sysUser);

        $this->website->gallery()->save($gallery);
    }

    /**
     * Adds a menu.
     *
     * @param      <type>       $name   The name
     *
     * @return     MenuBuilder  ( description_of_the_return_value )
     */
    public function addMenu($name, Closure $closure = null)
    {
        return MenuBuilder::new($name, $this->website, $closure);
    }

    /**
     * Edit Menu
     *
     * @param      <type>  $menu   The menu
     */
    public function menu($menu)
    {
        if (is_string($menu)) {

            $menu = $this->website
                ->menus()
                ->whereName($menu)
                ->firstOrFail();

        } elseif (is_int($menu)) {

            $menu = $this->website
                ->menus()
                ->findOrFail($menu);

        } elseif ($menu instanceof Menu) {

            if ($menu->website->id !== $this->website->id) {

                throw new \Exception('Menu does not belong to this website.');

            }

        }

        return MenuBuilder::edit($menu);
    }

    /**
     * Links a form.
     *
     * @param      Form  $form   The form
     */
    public function linkForm(\P3in\Models\Form $form)
    {
        $this->website->forms()->attach($form);
    }

    /**
     * Sets the storage.
     *
     * @param      <type>  $name   The name
     */
    public function setStorage($name)
    {
        $storage = StorageConfig::setByName($name);

        $this->website->storage()->associate($storage);

        $this->website->save();
    }

    /**
     * Sets the header.
     *
     * @param      <type>  $template  The template
     *
     * @return     <type>  ( description_of_the_return_value )
     */
    public function setHeader($template)
    {
        $this->website->setConfig('header', $template);
        return $this;
    }

    /**
     * Sets the footer.
     *
     * @param      <type>  $template  The template
     *
     * @return     <type>  ( description_of_the_return_value )
     */
    public function setFooter($template)
    {
        $this->website->setConfig('footer', $template);
        return $this;
    }

    public function setDeploymentDisk($disk)
    {
        $this->website->setConfig('deployment->disk', $disk);
        return $this;
    }

    public function setDeploymentPath($path)
    {
        $this->website->setConfig('deployment->path', $path);
        return $this;
    }

    public function SetPublishFrom($path)
    {
        $this->website->setConfig('deployment->publish_from', $path);
        return $this;
    }

    public function setDeploymentNpmPackages($data)
    {
        $this->website->setConfig('deployment->package_json', $data);
        return $this;
    }

    public function setDeploymentNuxtConfig($data)
    {
        $this->website->setConfig('deployment->nuxt_config', $data);
        return $this;
    }

    public function setMetaData($data)
    {
        $this->website->setConfig('meta', $data);
        return $this;
    }

    public function setLayout($layout, $layoutTemplate)
    {
        $this->website->setConfig('layouts->'.$layout, $layoutTemplate);

        return $this;
    }
    /**
     * Gets the website.
     *
     * @return     <type>  The website.
     */
    public function getWebsite()
    {
        return $this->website;
    }

    /**
     * { function_description }
     *
     * @param      <type>  $diskInstance  The disk instance
     */
    // breaking this up a bit would prob be a good idea.
    public function deploy()
    {
        if (!$depConfig = $this->website->config->deployment) {
            throw new Exception('The website does not have deployment settings configured');
        }

        $disk = $this->website->storage->getDisk();

        $manager = new PublishFiles('stubs', realpath(__DIR__.'/../Templates/stubs'));

        if (!empty($depConfig->publish_from)) {
            $manager
                ->setSrc('static', $depConfig->publish_from)
                ->publishFolder('static', $disk, true);

            // @TODO: do we read the dest or src folder?
            // dd($disk->allFiles('components'));
            foreach ($disk->allFiles('components') as $component) {
                $file = pathinfo($component);
                if ($file['extension'] == 'vue' && $file['filename']) {
                    $components[] = $file['filename'];
                }
            }
            $components_import_file = view('cms::components', [
                'components' => $components,
            ])->render();

            $manager->publishFile($disk, 'components/index.js', $components_import_file, true);
        }

        // lets publish the structure in case it doesn't exist.  Never overwrite!
        // hell this one is not really necisary for us since we have a plus3website
        // module that has the structure stored already, but that isn't a requirement
        // and not an assumption we can make.
        $manager->publishFolder('stubs', $disk);

        if (!empty($depConfig->package_json)) {
            $package_json = json_encode($depConfig->package_json, JSON_UNESCAPED_SLASHES);

            $manager->publishFile($disk, 'package.json', $package_json, true);
        }

        if (!empty($depConfig->nuxt_config)) {
            // this method of creating the javascript file is meh imo.  No luck finding a better way yet.
            $nuxt_conf = 'module.exports = '.preg_replace('/"([a-zA-Z_]+[a-zA-Z0-9_]*)":/', '$1:', json_encode($depConfig->nuxt_config, JSON_UNESCAPED_SLASHES));

            $manager->publishFile($disk, 'nuxt.config.js', $nuxt_conf, true);
        }

        // now lets get the website layout(s)
        if (!empty($this->website->config->layouts)) {
            foreach ($this->website->config->layouts as $layout => $data) {
                $manager->publishFile($disk, '/layouts/'.$layout.'.vue', $data, true);
            }
        }

        // we shouldn't be running this here at all.
        // $destPath = $manager->getPath($disk);
        // //sucks!... this is basically only working with local storage.
        // //this needs to be abstracted so that we can account for remote disk
        // //instances, AWS, or what ever other cloud instances that can be used
        // //(lots of them out there)
        // $process = new Process('npm install && npm run build', $destPath, null, null, null); //that last null param disables timeout.
        // $process->run(function ($type, $buffer) {
        //     echo $buffer;
        //     // if (Process::ERR === $type) {
        //     //     echo $buffer;
        //     // } else {
        //     //     echo $buffer;
        //     // }
        // });

        // Page builder has something we need.
        // PageBuilder::buildTemplate($layout, $sections, $imports);

        // say we need to do something else after deployment with the local/remote file systems.
        // Yes this mean we should prob move the instantiation of the manager out of this
        // method, but hey, I'm just getting this working for now!
        $this->manager = $manager;

        return $this;
    }
}