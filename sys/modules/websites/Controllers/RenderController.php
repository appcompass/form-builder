<?php

namespace P3in\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\URL;
use P3in\Renderers\PageRenderer;

class RenderController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function getPageData(Request $request, $uri = '')
    {
        \DB::enableQueryLog();
        $renderer =  new PageRenderer($request->website);

        $data = $renderer->setPage('/'.trim($uri, '/'))->getData();

        $data['debug'] = \DB::getQueryLog();
        return $data;
    }

    public function renderPage(Request $request, $uri = '')
    {
        $renderer =  new PageRenderer($request->website);

        $data = $renderer->setPage('/'.trim($uri, '/'))->render();

        return $data;
    }

    public function renderSitemap(Request $request, $type = 'xml')
    {
        $sitemap = App::make('sitemap');
        $pages = $request->website->pages()->orderBy('meta->priority', 'desc')->get();

        foreach ($pages as $page) {
            if ($page->dynamic_url) {
                // here's where we fetch all the dynamic entries/pages/posts/etc that are children of this page.
            } else {
                $sitemap->add(
                    $page->full_url,
                    $page->updated_at,
                    $page->priority,
                    $page->update_frequency,
                    $page->images
                );
            }
        }

        return $sitemap->render($type);
    }

    public function renderRobotsTxt(Request $request)
    {
        $site_meta = $request->website->meta;
        return isset($site_meta->robots_txt) ? $site_meta->robots_txt : '';
    }

    // @TODO Form submission moved into it's own class FormButler
}
