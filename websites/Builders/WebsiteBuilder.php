<?php

namespace P3in\Builders;

use Closure;
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
    public static function new($name, $domain, Closure $closure = null)
    {
        $instance = new static();

        $instance->website = Website::create([
            'name' => $name,
            'url' => $domain,
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

    public function buildPage($title, $slug)
    {
        $page = $this->website->pages()->create([
            'title' => $title,
            'slug' => $slug,
        ]);

        return new PageBuilder($page);
    }

    public function setHeader($template)
    {
        $this->website->update(['config->header' => $template]);
    }

    public function setFooter($template)
    {
        $this->website->update(['config->footer' => $template]);
    }

    public function setMetaData($data)
    {
        $this->website->update(['config->meta' => $data]);
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
