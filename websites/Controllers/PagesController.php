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

class PagesController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function renderPage(Request $request, $uri = '')
    {
        // \DB::enableQueryLog();
        $renderer =  new PageRenderer($request->website);

        $data = $renderer->setPage('/'.trim($uri, '/'))->render(); // edit() for CP, render() for public.

        // $data['debug'] = \DB::getQueryLog();
        return $data;
    }

    public function renderSitemap(Request $request, $type = 'xml')
    {
        $sitemap = App::make('sitemap');
        $pages = $request->website->pages()->orderBy('meta->priority', 'desc')->get();

         foreach ($pages as $page) {
            if ($page->dynamic_url) {
                // here's where we fetch all the dynamic entries/pages/posts/etc that are children of this page.
            }else{
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

    // This should be used for both contact forms and login forms,
    // and any other forms for that matter that are available on the front end,
    // like registration, etc.
    public function submitForm(Request $request, $uri = '')
    {
        // look up form for it's rules, which class processes the request, etc.
        // validate the form including recaptcha
        // process the form as it was intended to be processed.

        return $uri;
    }
}
