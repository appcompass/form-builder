<?php

namespace P3in\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\View\Factory;
use P3in\Models\Page;
use P3in\Models\Section;
use P3in\Models\Website;

class PagesController extends Controller
{

    public function __construct()
    {
    }

    public function renderPage(Request $request, $url = 'home-page')
    {
        // TODO: This belongs in middleware!
        // all requests require this so it should be set and simply accessed via
        // Config like so: Config::get('current_site_record')

        $page = Page::where('slug', $url)->ofWebsite()->firstOrFail();

        $template = 'layouts.master.'.$page->layout;

        $data = $page->render();

        return view($template, $data);
    }
}
