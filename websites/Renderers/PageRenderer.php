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

    public function render():string
    {
        $pageData = $this->getData();

        $forCompiler = $this->forCompiler($pageData['page']['containers']);

        // this is where we compile the Vue section using an abstracted recursive(?) version of Fieldtype::renderComponents()
        $compiled = json_encode($forCompiler); // bogus obviously just so we get some return data to view structure.

        return $compiled;
    }

    private function forCompiler($data)
    {
        $rtn = [];

        foreach ($data as $row) {
            $rtn[] = [
                'content' => $row['content'],
                'order' => $row['order'],
                'name' => $row['section']['name'],
                'template' => $row['section']['template'],
                'type' => $row['section']['type'],
                'config' => $row['section']['config'],
                'children' => $this->forCompiler($row['children'])
            ];
        }

        return $rtn;
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

    private function cleanPageComponents(&$sections)
    {
        $sections->each(function ($section) {
            $section
                ->makeHidden('id')
                ->makeHidden('page_id')
                ->makeHidden('parent_id')
                ->makeHidden('section_id')
                ->makeHidden('created_at')
            ;

            // how much do we need and how much can we hide from front-end requests?
            $section->section
                ->makeHidden('id')
                ->makeHidden('created_at')
            ;

            $this->cleanPageComponents($section->children);
        });
    }
}
