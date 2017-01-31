<?php

namespace P3in\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\URL;

class PublicWebsiteController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function getPageData(Request $request, $uri = '')
    {
        \DB::enableQueryLog();
        // // cache for 14 days?
        // $data = Cache::remember('public-page-'.$uri, 20160, function () use ($request, $uri) {

        $data = $request
            ->website
            ->getPageFromUrl('/'.trim($uri, '/'))
            ->getData();

        //     return $data;
        // });

        // @TODO: better abstract this so we can push stuff into the debug
        // object rather than just log queries. Middlware maybe?
        $data['debug'] = \DB::getQueryLog();

        return $data;
    }

    public function getSiteMenus(Request $request)
    {
        $rtn = [];

        $menus = $request
            ->website
            ->menus
            ->load('items');

        foreach ($menus as $menu) {
            $rtn[$menu->name] = $menu->render(true);
        }

        return $rtn;
    }

    public function getSiteMeta(Request $request)
    {
        $site = $request->website;
        // return response()->json(
        return array_merge([
            'name' => $site->name,
            'url' => $site->url,
        ], (array) $site->config->meta);
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
