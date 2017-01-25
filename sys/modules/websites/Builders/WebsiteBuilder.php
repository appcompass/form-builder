<?php

namespace P3in\Builders;

use P3in\Traits\PublishesComponentsTrait;
use P3in\Builders\MenuBuilder;
use P3in\Builders\PageBuilder;
use P3in\Models\PageContent;
use P3in\Models\Website;
use P3in\Models\Section;
use P3in\Models\Layout;
use P3in\Models\Page;
use Closure;

class WebsiteBuilder
{
    use PublishesComponentsTrait;

    /**
     * Page instance
     */
    private $website;

    public function __construct(Website $website = null)
    {
        if (!is_null($website)) {
            $this->website = $website;
        }

        return $this;
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
        $instance = new static();

        $instance->website = Website::create([
            'name' => $name,
            'scheme' => $scheme,
            'host' => $host,
        ]);

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
            throw new \Exception('Must pass id or Website instance');
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

    /**
     * Adds a menu.
     *
     * @param      <type>       $name   The name
     *
     * @return     MenuBuilder  ( description_of_the_return_value )
     */
    public function addMenu($name)
    {
        $menu = $this->website->menus()->create([
            'name' => $name,
        ]);

        return new MenuBuilder($menu);
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

    // public function setTemplateBasePath($path)
    // {
    //     $this->website->setConfig('template_base_path', $path]);
    //     return $this;
    // }

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

    /**
     * Compile Components
     *
     * @return     <type>  ( description_of_the_return_value )
     */
    public function compilePageTemplates()
    {
        $manager = $this->getMountManager();

        $compiledImporter = [];
        $compiledExporter = [];

        foreach ($this->website->pages as $page) {
            $name = $page->template_name;
            $filename = $name.'.vue';

            $compiledImporter[] = "import {$name}Page from './{$name}'";
            $compiledExporter[] = "export var {$name} = {$name}Page";
        }

        $content = implode("\n", array_merge($compiledImporter, $compiledExporter));

        $manager->put('dest://' . 'App.js', $content . "\n");

        return $this;
    }

    /**
     * { function_description }
     *
     * @param      <type>  $diskInstance  The disk instance
     */
    public function deploy($diskInstance)
    {
        // Magic Sauce DevOps logic using the set disk instance and run commands needed on server to get everything configured properly.
    }
}
