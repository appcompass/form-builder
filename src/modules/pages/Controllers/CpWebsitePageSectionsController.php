<?php

namespace P3in\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use Illuminate\Http\Request;
use P3in\Controllers\UiBaseController;
use P3in\Models\Section;
use P3in\Models\Page;
use Response;
use DB;

class CpWebsitePageSectionsController extends UiBaseController
{
    public $meta_install = [
        'edit' => [
            'data_targets' => [
                [
                    'route' => 'websites.show',
                    'target' => '#main-content-out',
                ],[
                    'route' => 'websites.pages.section.edit',
                    'target' => '#record-detail',
                ],
            ],
        ],
    ];

    public function __construct()
    {

        $this->middleware('auth');

        $this->controller_class = __CLASS__;
        $this->module_name = 'pages';

        $this->setControllerDefaults();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {}

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {}

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $website_id, $page_id)
    {

        $page = Page::findOrFail($page_id);

        if ($request->has('reorder')) {

            foreach($request->reorder as $order => $item_id) {

                DB::table('page_section')->where('id', $item_id)
                    ->update(['order' => $order]);

            }

        }

        $order = intVal( DB::table('page_section')
            ->where('page_id', '=', $page_id)
            ->max('order') ) + 1;

        $page->sections()
            ->attach(Section::whereName($request->section_name)->first(), ['order' => $order]);

        return redirect()->action('\P3in\Controllers\CpWebsitePagesController@show', [$page->website->id, $page]);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {}

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($website_id, $page_id, $section_id)
    {
        $page = Page::findOrFail($page_id)->load('sections.photos');

        $section = $page->sections()
            ->where('page_section.id', $section_id)
            ->firstOrFail();

        $photos = $section->photos;

        $edit_view = 'sections/'.$section->edit_view;

        $this->setBaseUrl(['websites', $website_id, 'pages', $page_id, 'section', $section->pivot->id]);
        $meta = $this->meta;
        return view($edit_view, compact('meta', 'section', 'page', 'photos'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $website_id, $page_id, $section_id)
    {

        if ($request->file) {

        //     dd($request->file);

        }

        $page = Page::findOrFail($page_id);

        $content = json_encode($request->except(['_token', '_method']));

        $result = DB::table('page_section')->where('id', $section_id)
            ->update(['content' => $content]);

        return redirect()->action('\P3in\Controllers\CpWebsitePagesController@show', [$page]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $website_id, $page_id, $section_id) {

        $page = Page::findOrFail($page_id);

        DB::table('page_section')
            ->where('id', $section_id)
            ->delete();

        return redirect()->action('\P3in\Controllers\CpWebsitePagesController@show', [$page->website->id, $page->id]);
    }

}
