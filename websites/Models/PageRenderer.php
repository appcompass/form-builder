<?php

namespace P3in\Models;

use P3in\Models\Website;
use P3in\Models\Page;
use P3in\Models\Section;
use P3in\Models\PageSection;
use Closure;


/**
 * Examples:
 * new PageRenderer(Website::current())->render($url);
 */
class PageRenderer
{

    private $pages;
    private $page;
    private $build;

    public function __construct(Website $website)
    {
        $this->build = [];
        $this->pages = $website->pages();

        return $this;
    }

    public function render($url)
    {
        $this->getUrl($url);
        $this->getFrame();
        $this->getContent();

        // structure the page data to be sent to the front-end to work out.
        return $this->build;
    }

    private function getHeader()
    {
        // get header type (defined as a section assigned to the whole website?)
        // get header meta data, custom html/script includes, etc
    }
    private function getFooter()
    {
        // get footer type (defined as a section assigned to the whole website?)
        // get footer meta data, custom html/script includes, etc
    }
    private function getFrame()
    {
        // fetch website settings that contain information on the website's header/footer/scripts/etc
        $this->build['header'] = $this->getHeader();
        $this->build['footer'] = $this->getHeader();
    }

    private function getContent()
    {
        // fetch and build the content of the page
        $this->build['content'] = []; //stuff
    }

    private function getUrl($url)
    {
        $this->page = $this->pages->byUrl($url)->firstorFail();

        return $this;
    }

}