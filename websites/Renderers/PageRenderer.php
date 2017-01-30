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
    private $build = [];

    public function __construct(Website $website)
    {
        $this->website = $website;

        // if (!isset($this->website->config->template_base_path)) {
        //     throw new Exception('Must specify a base path for website templates.');
        // }

        // $this->template_base_path = $this->website->config->template_base_path;
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

    public function edit()
    {
        return $this->getData(false);
    }

    public function getData($filtered = true)
    {
        if (!$this->page) {
            throw new Exception('A page must be set.');
        }

        // $this->page->load('contents');

        if ($filtered) {
            $this->filterData();
        }

        $this->getContent($this->page->buildContentTree());

        $this->build['page'] = $this->page;

        // $this->getSettings();
        // $this->getContent($filtered);

        // structure the page data to be sent to the front-end to work out.
        return $this->build;
    }

    private function getContent($sections)
    {
        foreach ($sections as $row) {
            if ($row->children->count()) {
                $this->getContent($row->children);
            } else {
                $this->build['content'][$row->id] = $row->content;
            }
        }
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
            ->makeHidden('contents')
        ;
    }
}
