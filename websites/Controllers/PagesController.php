<?php

namespace P3in\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use P3in\Renderers\PageRenderer;

class PagesController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function renderPage(Request $request, $uri = '/')
    {
        \DB::enableQueryLog();
        $renderer =  new PageRenderer($request->website);

        $data = $renderer->setPage($uri)->render(); // edit() for CP, render() for public.

        $data['debug'] = \DB::getQueryLog();
        return $data;
    }
}
