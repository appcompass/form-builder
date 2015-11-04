<?php

namespace P3in\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use Illuminate\Http\Request;
use P3in\Controllers\UiBaseController;
use P3in\Models\Section;
use P3in\Models\Page;
use Response;

class CpPageSectionsController extends UiBaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($page_id, $section_id)
    {
        $page = Page::findOrFail($page_id)->load('sections.photos');

        $template = $page->template;

        $section = $page->sections()
            ->findOrFail($section_id);

        $photos = $section->photos;

        return view($section->edit_view, compact('section', 'page', 'photos'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $page_id, $section_id)
    {

        if ($request->file) {

        //     dd($request->file);

        }

        $content = json_encode($request->except(['_token', '_method']));

        $result = Page::findOrFail($page_id)->sections()
            ->updateExistingPivot($section_id, [
                'content' => $content
            ]);

        return Response::json(['success' => $result]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
