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

    private $website;
    private $pages;
    private $page;
    private $build;

    public function __construct(Website $website)
    {
        $this->build = [];
        $this->website = $website;
        $this->pages = $website->pages();


        return $this;
    }

    public function setPage($page_or_url)
    {
        if ($page_or_url instanceof Page) {
            // we check if the page is part of the website, validate
            // permissions for the current user to view this page, etc.

            if (!$this->pages->find($page_or_url->id)) {
                throw new \Exception('The page does not belong to this website.');
            }

            $page = $page_or_url;

        }elseif (is_string($page)) {

            $page = $this->getPageFromUrl($page_or_url);

        }else{
            throw new \Exception('Must pass a page instance or the url.');
        }

        $this->page = $page;

        return $this;
    }

    public function render()
    {

        if (!$this->page) {
            throw new \Exception('A page must be set.');
        }

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

    private function getPageFromUrl($url)
    {
        try {
            return $this->pages->byUrl($url)->firstorFail();
        } catch (Exception $e) {
            throw new \Exception('There is no page by that URL.');
        }
    }

}