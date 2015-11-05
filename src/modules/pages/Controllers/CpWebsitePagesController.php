<?php

namespace P3in\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use Illuminate\Http\Request;
use P3in\Controllers\UiBaseController;
use P3in\Models\Navmenu;
use P3in\Models\Page;
use P3in\Models\Template;
use P3in\Models\Website;

class CpWebsitePagesController extends UiBaseController
{

	public function __construct()
	{

		$this->middleware('auth');

        parent::setControllerDefaults(__DIR__);

	}

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index($website_id)
    {

        $this->records = Website::findOrFail($website_id)->pages;

        $this->meta->base_url = '/cp/websites/'.$website_id.'/pages';

        return $this->build('index');

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create($website_id)
    {
        return $this->build('create');
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
     * @param  int  $website_id
     * @param  int  $page_id
     * @return Response
     */
    public function show($website_id, $page_id) {

        $this->record = Website::findOrFail($website_id)->pages()
            ->findOrFail($page_id);

        return parent::build('show');
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
     *
     *
     */
    public function getLeftPanels($id = null)
    {

        $navmenu = parent::getLeftPanels();

        $navmenu = new Navmenu(['label' => 'Page Sections']);

        foreach($this->record->sections as $section) {

            $navmenu->items->push($section->navItem);

        }

        return is_array($navmenu) ?: [$navmenu];

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
