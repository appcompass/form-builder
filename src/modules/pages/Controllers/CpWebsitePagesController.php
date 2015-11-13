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
            'full' => 'Full Width',
            'aside:main' => 'Left Sidenav',
            'main:aside' => 'Right Sidenav'
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
        // REMEMBER! this->record holds the model instance
        $page = $this->record;

        // fetch default panels
        $left_panels[] = parent::getLeftPanels() ?: null;

        foreach(explode(':', $page->layout) as $layout_part) {

            $section_navmenu['target'] = new Navmenu(['label' => 'Available Sections']);

            // add current page sections
            foreach ($page->sections()->where('fits', $layout_part)->get() as $section) {

                $nav_item = $section->getNavigationItem([
                    'url' => 'section/'.$section->pivot->id.'/edit',
                    'props' => []
                ]);

                $nav_item->id = $section->pivot->id;

                $section_navmenu['target']->items->push($nav_item);

            }

            $section_navmenu['source'] = new Navmenu(['label' => 'Available Sections']);

            // all the available sections
            foreach(Section::draggable($layout_part)->get() as $section) {

                $nav_item = $section->getNavigationItem([
                    'url' => '',
                    'props' => []
                ]);

                $section_navmenu['source']->items->push($nav_item);

            }

            $left_panels[] = $section_navmenu;

        }

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
