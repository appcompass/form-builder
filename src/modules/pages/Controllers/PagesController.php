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

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
      return Page::all();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        $page = Page::findOrFail($id);

        $template = 'layouts.master.'.$page->layout;

        $data = $page::find($id)->render();

        $header = Section::findOrFail($page->website->settings('header'));
        $footer = Section::findOrFail($page->website->settings('footer'));

        $data['header'] = [
            'view' => '/sections'.$header->display_view,
            // 'data' => $header->pivot->content // TODO MUST LINK SECTION ON WEBSITE SETTINGS STORAGE
        ];

        $data['footer'] = [
            'view' => '/sections'.$footer->display_view,
            // 'data' => $footer->pivot->content // TODO MUST LINK SECTION ON WEBSITE SETTINGS STORAGE
        ];

        return view($template, $data);


        return Page::find($id)
            ->render();

        $template = array_keys($includes)[0];
        $includes = $includes[$template];

        return view($template)
            ->with('includes', $includes)
            ->with('data', $data);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }
}
