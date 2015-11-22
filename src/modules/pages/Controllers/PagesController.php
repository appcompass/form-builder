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

    public function renderPage(Request $request, $url = '')
    {

        $page = Page::where('slug', $url)->ofWebsite()->firstOrFail();

        $template = 'layouts.master.'.str_replace(':', '_', $page->layout);

        $data = $page->render();

        $data['website'] = Website::current();

        $data['navmenus'] = [];

        $navmenus = Website::current()->navmenus()
            ->whereNull('parent_id')
            ->get();

        foreach ($navmenus as $navmenu) {

            $data['navmenus'][$navmenu->name] = $navmenu;

        }

        return view($template, $data);

    }
}
