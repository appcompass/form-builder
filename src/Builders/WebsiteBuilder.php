<?php

namespace P3in\Builders;

use P3in\Models\User;
use Closure;
use Exception;
use Illuminate\Filesystem\FilesystemAdapter;
use Illuminate\Support\Facades\App;
use P3in\Builders\MenuBuilder;
use P3in\Builders\PageBuilder;
use P3in\Models\Gallery;
use P3in\Models\Layout;
use P3in\Models\Menu;
use P3in\Models\Page;
use P3in\Models\PageContent;
use P3in\Models\Section;
use P3in\Models\StorageConfig;
use P3in\Models\Website;
use P3in\PublishFiles;
use Symfony\Component\Process\Process;

class WebsiteBuilder
{

    /**
     * Page instance
     */
    private $website;
    private $renderer;

    public function __construct(Website $website = null)
    {
        if (!is_null($website)) {
            $this->website = $website;
            $this->renderer = $website->renderer();
        }
    }

    public function renderer()
    {
        return $this->renderer;
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

    public function addLayout($name)
    {
        $layout = new Layout([
            'name' => $name,
        ]);

        $layout = $this->website->addLayout($layout);

        return new LayoutBuilder($layout);
    }

    /**
     * Adds a page.
     *
     * @param      <type>       $title  The title
     * @param      <type>       $slug   The slug
     *
     * @return     PageBuilder  ( description_of_the_return_value )
     */
    public function addPage($title, $slug, $dynamic = false)
    {
        $page = new Page([
            'title' => $title,
            'slug' => $slug,
            'dynamic_url' => $dynamic,
        ]);

        $page = $this->website->addPage($page);

        return new PageBuilder($page);
    }

    public function setGallery()
    {
        $gallery = new Gallery(['name' => $this->website->host]);

        // @TODO Jubair vvv role based makes more syntax and unifies the syntax throughtout the whole app
        // thoughts? take a look at new user __call -> if you call $user->isRole() it checks if the user
        // has that specific role, making the api smooth -f
        // $sysUser = User::SystemUsers()->firstOrFail();

        $sysUser = User::havingRole('system')->firstOrFail();

        $gallery->user()->associate($sysUser);

        $this->website->gallery()->save($gallery);
    }

    public function addSection($data)
    {
        if (is_array($data)) {
            $section = new Section($data);
        // } elseif (is_int($data)) {
        //     // Dangerious, may not be a good idea to re-assign.
        //     $section = Section::find($data);
        } elseif ($data instanceof Section) {
            $section = $data;
        }
        $this->website->sections()->save($section);
        // return $this;
        return $section;
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

        $this->renderer()->setDisk($this->website->storage->getContainer());
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

    public function setMetaData($data)
    {
        $this->website->setConfig('meta', $data);
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

    public function getStorePath()
    {
        return $this->renderer()->getStorePath();
    }

    public function compilePages()
    {
        foreach ($this->website->pages as $page) {
            $page->renderer()->compile();
        }

        return $this;
    }

    public function compileWebsite()
    {
        $this->renderer()->compile();

        return $this;
    }

    public function deploy()
    {
        $storage = $this->website->storage;
        $server = $storage->getContainer();

        // @TODO: needs error handling, and this also assumes PM2 is being used which is a req on the server.
        return $server->runCommand('npm install && npm run build && pm2 restart all');
    }
}
