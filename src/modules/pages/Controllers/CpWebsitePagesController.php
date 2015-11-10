<?php

namespace P3in\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use Carbon\Carbon;
use Illuminate\Http\Request;
use P3in\Controllers\UiBaseController;
use P3in\Models\Navmenu;
use P3in\Models\Page;
use P3in\Models\Section;
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

        $this->meta->available_layouts = [
            '3' => 'Full Width',
            '1:2' => 'Left Sidenav',
            '2:1' => 'Right Sidenav'
        ];

        // return $this->build('create');

        $this->meta->create->route = '/cp/websites/'.$website_id.'/pages';

        return $this->build('create');

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request, $website_id)
    {
        $page = new Page($request->all());

        $page->slug = '/'.$request->get('name');
        $page->published_at = Carbon::now();

        Website::findOrFail($website_id)->pages()
            ->save($page);

        $this->record = $page;

        return $this->index($website_id);
        // return parent::build('show');
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

        return view('pages::show')
            ->with('record', $this->record)
            ->with('meta', $this->meta)
            ->with('nav', $this->getCpSubNav())
            ->with('left_panels', $this->getLeftPanels());
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

        // $templates = Template::all()->lists('name', 'id');

        return view('pages::edit', compact('page', 'website'));//, 'templates'));
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

        // fetch default panels
        $left_panels[] = parent::getLeftPanels() ?: null;

        // add current page sections
        $page_sections_navmenu = new Navmenu(['label' => 'Page Sections']);

        foreach($this->record->sections()->get() as $section) {

            $page_sections_navmenu->items->push($section->getNavigationItem(['url' => 'section/'.$section->id.'/edit']));

        }

        // list all the aviailable sections
        $left_panels['targets'][] = $page_sections_navmenu;

        $sections_navmenu = new Navmenu(['label' => 'Available Sections']);

        foreach(Section::draggable()->get() as $section) {

            $sections_navmenu->items->push($section->getNavigationItem(['url' => '', 'props' => ['icon' => 'globe']]));

        }

        $left_panels['sources'][] = $sections_navmenu;

        return $left_panels;

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
