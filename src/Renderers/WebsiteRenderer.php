<?php

namespace P3in\Renderers;

use Exception;
use P3in\Models\Website;

class WebsiteRenderer
{
    private $website;
    private $build;

    public function __construct(Website $website)
    {
        $this->website = $website;

        return $this;
    }

    // Methods for Vue Route format output of all pages
    // @TODO: we prob want to move this to something else, like WebsiteBuilder maybe
    public function buildRoutesTree($pages = null)
    {
        $pages = $this->website->pages()
            ->byAllowedRole()
            ->with('sections')
            ->get();

        $rtn = [];
        foreach ($pages->unique('layout')->pluck('layout') as $layout) {
            if ($layout) {
                $rtn[] = [
                    'path' => '',
                    'component' => $layout,
                    'children' => $this->formatRoutesBranch($pages->where('layout', $layout))
                ];
            }
        }

        return $rtn;
    }

    private function formatRoutesBranch($pages)
    {
        $rtn = [];
        foreach ($pages as $page) {
            // cp pages are like any other, so we use the sections to define the view type
            // (handy if we ever decided to change a view type for a page).
            $section = $page->sections->first();
            $meta = (object) $page->meta;
            $meta->title = $page->title;
            $rtn[] = [
                'path' => $page->url,
                'name' => $page->getMeta('resource') ?? $page->slug,
                'meta' => $meta,
                // might need to be worked out for CP, at least discussed to see if we want to go this route.
                'component' => $section ? $section->template : null,
            ];
        }
        return $rtn;
    }


    private function setPageChildren(&$parent, $parent_id, $pages)
    {
        foreach ($pages->where('parent_id', $parent_id) as $page) {
            unset($parent['name']);
            $row = $this->structureRouteRow($page);
            $this->setPageChildren($row, $page->id, $pages);
            $parent['children'][] = $row;
        }
    }

}
