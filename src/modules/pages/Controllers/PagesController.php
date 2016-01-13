<?php

namespace P3in\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\Factory;
use P3in\Models\Page;
use P3in\Models\Section;
use P3in\Models\Website;

class PagesController extends Controller
{

    public function renderPage(Request $request, $url = '')
    {
        $page = Page::byUrl($url)->ofWebsite()->firstOrFail();

        $data = $page->render();

        $data['page'] = $page;
        $data['website'] = Website::current();

        $data['navmenus'] = [];

        $navmenus = Website::current()->navmenus()
            ->whereNull('parent_id')
            ->get();
        foreach ($navmenus as $navmenu) {

            $data['navmenus'][$navmenu->name] = $navmenu;

        }
        // dd($data);
        return view('layouts.master.'.$page->assembler_template, $data);

    }
}
