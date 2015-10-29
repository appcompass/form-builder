<?php

namespace P3in\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use Illuminate\Http\Request;
use P3in\Controllers\UiBaseController;
use P3in\Models\Page;
use P3in\Models\Template;
use P3in\Models\Website;

class CpWebsitePagesController extends UiBaseController
{

	public function __construct()
	{
		$this->middleware('auth');
	}

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index($website_id)
    {

        $website = Website::findOrFail($website_id)->load('pages');

        // return view('pages::detail');
        return view('pages::list', compact('website'));

        // return parent::build('index', Website::findOrFail($website_id)->load('pages'));

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
    public function show($website_id, $page_id)
    {

        $website = Website::findOrFail($website_id);

        $page = $website
            ->load('pages')
            ->pages()
            ->findOrFail($page_id);

        return view('pages::detail', compact('page', 'website'));

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($website_id, $page_id)
    {

        $website = Website::findOrFail($website_id);

        $page = $website
            ->load('pages')
            ->pages()
            ->findOrFail($page_id);

        $templates = Template::all()->lists('name', 'id');

        return view('pages::edit', compact('page', 'website', 'templates'));
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
