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

    public $meta_install = [
        'index' => [
            'data_targets' => [
                [
                    'route' => 'websites.show',
                    'target' => '#main-content-out',
                ],[
                    'route' => 'websites.pages.index',
                    'target' => '#record-detail',
                ],
            ],
            'heading' => 'Website\'s pages',
            'table' => [
                'headers' => [
                    'Title',
                    'Name',
                    'Slug',
                    'Created',
                    'Updated',
                ],
                'rows' => [
                    'title' => [
                        'type' => 'link_by_id',
                        'target' => '#main-content-out',
                    ],
                    'name' => [
                        'type' => 'link_by_id',
                        'target' => '#main-content-out',
                    ],
                    'slug' => [
                        'type' => 'text',
                    ],
                    'created_at' => [
                        'type' => 'datetime',
                    ],
                    'updated_at' => [
                        'type' => 'datetime',
                    ],
                ],
            ],
        ],
        'show' => [
            'data_targets' => [
                [
                    'route' => 'websites.show',
                    'target' => '#main-content-out',
                ],[
                    'route' => 'websites.pages.show',
                    'target' => '#main-content-out',
                    // 'target' => '#record-detail',
                ],
            ],
            'heading' => 'Page Informations',
            'sub_section_name' => 'Page Administration',
        ],
        'edit' => [
            'data_targets' => [
                [
                    'route' => 'websites.show',
                    'target' => '#main-content-out',
                ],[
                    'route' => 'websites.pages.edit',
                    'target' => '#record-detail',
                ],
            ],
            'heading' => 'Page Informations',
            'route' => 'pages.update'
        ],
        'create' => [
            'data_targets' => [
                [
                    'route' => 'websites.show',
                    'target' => '#main-content-out',
                ],[
                    'route' => 'websites.pages.create',
                    'target' => '#record-detail',
                ],
            ],
            'heading' => 'Add a page to this website',
            'route' => '/pages/store'
        ],
        'form' => [
            'fields' => [
                [
                    'label' => 'Page Title',
                    'name' => 'title',
                    'placeholder' => 'Page Title',
                    'type' => 'text',
                    'help_block' => 'The title of the page.',
                ],[
                    'label' => 'Page URL',
                    'name' => 'slug',
                    'placeholder' => '',
                    'type' => 'slugify',
                    'field' => 'title',
                    'help_block' => 'This field is set automatically.  But if you need to ovride it, do so AFTER you set the Title above.',
                ],[
                    'label' => 'Description',
                    'name' => 'description',
                    'placeholder' => 'Page Description Block',
                    'type' => 'textarea',
                    'help_block' => 'The title of the page.',
                ],[
                    'label' => 'Active',
                    'name' => 'Published',
                    'placeholder' => '',
                    'type' => 'checkbox',
                    'help_block' => 'is the page published?',
                ],[
                    'label' => 'Layout Type',
                    'name' => 'layout',
                    'placeholder' => '',
                    'type' => 'layout_selector',
                    'help_block' => 'Select the page\'s layout.',
                ]
            ]
        ]
    ];

	public function __construct()
	{
        $this->middleware('auth');

        $this->controller_class = __CLASS__;
        $this->module_name = 'pages';

        $this->setControllerDefaults();

        $this->meta->available_layouts = [
            'full' => 'Full Width',
            'aside:main' => 'Left Sidenav',
            'main:aside' => 'Right Sidenav'
        ];

    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index($website_id)
    {
        $this->records = Website::findOrFail($website_id)->pages;

        $this->meta->data_target = '#main-content-out';

        return $this->build('index', ['websites', $website_id, 'pages']);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create($website_id)
    {

        return $this->build('create', ['websites', $website_id, 'pages']);

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

        $page->name = strtolower(str_replace(' ', '_', $page->title));

        $page->published_at = Carbon::now();

        Website::findOrFail($website_id)->pages()
            ->save($page);

        $this->record = $page;

        $this->meta->data_target = '#main-content-out';

        return $this->json($this->setBaseUrl(['websites', $website_id, 'pages', $this->record->id]));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $website_id
     * @param  int  $page_id
     * @return Response
     */
    public function show($website_id, $page_id)
    {

        $website = Website::findOrFail($website_id);

        $this->record = $page = $website->pages()
            ->findOrFail($page_id)
            ->load('sections');

        $this->setBaseUrl(['websites', $website_id, 'pages', $page_id]);

        $this->meta->no_autoload = true;

        $this->meta->data_target = '#main-content-out';

        return view('pages::show')
            ->with('website', $website)
            ->with('page', $page)
            ->with('meta', $this->meta)
            ->with('nav', $this->getCpSubNav())
            ->with('sections', $this->getSections())
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

        $this->record = Page::ofWebsite($website)->findOrFail($page_id);

        return $this->build('edit', ['websites', $website_id, 'pages', $page_id]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $website_id, $page_id)
    {
        $website = Website::findOrFail($website_id);

        $page = Page::ofWebsite($website)->findOrFail($page_id);

        $page->update($request->all());

        return $this->json($this->setBaseUrl(['websites', $website_id, 'pages', $page_id]));
    }

    /**
     *
     */
    public function getSections()
    {
        // REMEMBER! this->record holds the model instance
        $page = $this->record->load('sections');

        // returning
        $sections = [
            'page' => [],
            'available' => []
        ];

        foreach(explode(':', $page->layout) as $layout_part) {

            $current_nav = $sections['page'][$layout_part] = new Navmenu(['label' => 'Current Template']);

            foreach ($page->sections()->where('section', $layout_part)->get() as $section) {

                $nav_item = $section->getNavigationItem([
                    'url' => 'section/'.$section->pivot->id.'/edit',
                    'props' => []
                ]);

                $nav_item->id = $section->pivot->id;

                $current_nav->items->push($nav_item);

            }

            $current_templates_nav = $sections['available'][$layout_part] = new Navmenu(['label' => ucfirst($layout_part).' Templates']);

            foreach (Section::where('fits', $layout_part)->get() as $section) {

                $nav_item = $section->getNavigationItem([
                    'url' => '',
                    'props' => ['id' => $section->id]
                ]);

                $current_templates_nav->items->push($nav_item);

            }

        }

        return $sections;
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

    //     foreach(explode(':', $page->layout) as $layout_part) {

    //         $section_navmenu['target'] = new Navmenu(['label' => 'Available Sections']);

    //         // add current page sections
    //         foreach ($page->sections()->where('fits', $layout_part)->get() as $section) {

    //             $nav_item = $section->getNavigationItem([
    //                 'url' => 'section/'.$section->pivot->id.'/edit',
    //                 'props' => []
    //             ]);

    //             $nav_item->id = $section->pivot->id;

    //             $section_navmenu['target']->items->push($nav_item);

    //         }

    //         $section_navmenu['source'] = new Navmenu(['label' => 'Available Sections']);

    //         // all the available sections
    //         foreach(Section::draggable($layout_part)->get() as $section) {

    //             $nav_item = $section->getNavigationItem([
    //                 'url' => '',
    //                 'props' => []
    //             ]);

    //             $section_navmenu['source']->items->push($nav_item);

    //         }

    //         $left_panels[] = $section_navmenu;

    //     }

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
