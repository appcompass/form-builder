<?php

namespace P3in\Renderers;

use Closure;
use Exception;
use Illuminate\Support\Facades\App;
use P3in\Models\Page;
use P3in\Models\PageComponentContent;
use P3in\Models\Website;

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
        $this->website = $website;
        $this->pages = $website->pages();

        return $this;
    }

    public function setPage($url)
    {
        if (is_string($url)) {
            $this->page = $this->getPageFromUrl($url);
        } else {
            throw new Exception('Must pass a url.');
        }

        return $this;
    }

    public function render($filtered = true)
    {
        if (!$this->page) {
            throw new Exception('A page must be set.');
        }

        $this->page->load('containers');

        if ($filtered) {
            $this->filterData();
        }

        $this->build['page'] = $this->page->toArray();

        // $this->getSettings();
        // $this->getContent($filtered);

        // structure the page data to be sent to the front-end to work out.
        return $this->build;
    }

    public function edit()
    {
        return $this->render(false);
    }

    private function getPageFromUrl($url)
    {
        try {
            return $this->pages->byUrl($url)->firstorFail();
        } catch (Exception $e) {
            throw new Exception('There is no page by that URL.');
        }
    }

    private function filterData()
    {
        $this->page
            ->makeHidden('id')
            ->makeHidden('website_id')
            ->makeHidden('dynamic_url')
            ->makeHidden('created_at')
            ->makeHidden('deleted_at')
            ->makeHidden('dynamic_segment')
        ;

        $this->cleanPageComponents($this->page->containers);
    }

    private function cleanPageComponents(&$components)
    {
        $components->each(function ($component) {
            $component
                ->makeHidden('id')
                ->makeHidden('page_id')
                ->makeHidden('parent_id')
                ->makeHidden('component_id')
                ->makeHidden('created_at')
            ;

            // how much do we need and how much can we hide from front-end requests?
            $component->component
                ->makeHidden('id')
                ->makeHidden('created_at')
            ;

            $this->cleanPageComponents($component->children);
        });
    }
}
