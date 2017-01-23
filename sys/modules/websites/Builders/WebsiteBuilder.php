<?php

namespace P3in\Builders;

use Closure;
use P3in\Builders\MenuBuilder;
use P3in\Builders\PageBuilder;
use P3in\Models\Layout;
use P3in\Models\Page;
use P3in\Models\PageContent;
use P3in\Models\Section;
use P3in\Models\Website;

class WebsiteBuilder
{

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
    public static function new($name, $scheme, $host, Closure $closure = null)
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
    public static function edit($website)
    {
        if (!$website instanceof Website && !is_int($website)) {
            throw new \Exception('Must pass id or Website instance');
        }

        if (is_int($website)) {
            $website = Website::findOrFail($website);
        }

        return new static($website);
    }

    public function addPage($title, $slug)
    {
        $page = new Page([
            'title' => $title,
            'slug' => $slug,
        ]);

        $page = $this->website->pages()->save($page);

        return new PageBuilder($page);
    }

    public function addMenu($name)
    {
        $menu = $this->website->menus()->create([
            'name' => $name,
        ]);

        return new MenuBuilder($menu);
    }

    public function setHeader($template)
    {
        $this->website->update(['config->header' => $template]);
        return $this;
    }

    public function setFooter($template)
    {
        $this->website->update(['config->footer' => $template]);
        return $this;
    }

    public function setTemplateBasePath($path)
    {
        $this->website->update(['config->template_base_path' => $path]);
        return $this;
    }

    public function setMetaData($data)
    {
        $this->website->update(['config->meta' => $data]);
        return $this;
    }

    public function getWebsite()
    {
        return $this->website;
    }

    public function deploy($diskInstance)
    {
        // Magic Sauce DevOps logic using the set disk instance and run commands needed on server to get everything configured properly.
    }
}
