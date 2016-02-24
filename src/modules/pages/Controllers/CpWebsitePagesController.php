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
        'classname' => Page::class,
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
                    'Actions',
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
                    'actions' => [
                        'type' => 'action_buttons',
                        'data' => ['edit', 'clone', 'delete']
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
                    'target' => '#record-detail',
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
                    'route' => 'websites.pages.show',
                    'target' => '#record-detail',
                ],[
                    'route' => 'websites.pages.edit',
                    'target' => '#content-edit',
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
            'route' => 'websites.pages.store'
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
                    'label' => 'Page Slug',
                    'name' => 'slug',
                    'placeholder' => '',
                    'type' => 'slugify',
                    'field' => 'title',
                    'help_block' => 'This field is set automatically.  But if you need to override it, do so AFTER you set the Title above.',
                ],[
                    'label' => 'Page Parent',
                    'name' => 'parent',
                    'type' => 'filtered_selectlist',
                    'data' => 'page_list',
                    'help_block' => 'Select a parent for this page.',
                ],[
                    'label' => 'Active',
                    'name' => 'active',
                    'placeholder' => '',
                    'type' => 'checkbox',
                    'help_block' => 'is the page live?',
                ],[
                    'label' => 'Dynamic Page',
                    'name' => 'settings[config][dynamic]',
                    'placeholder' => '',
                    'type' => 'checkbox',
                    'help_block' => 'This is used only for dynamic segment pages taht get their content from other, non page module sources. For example: a single blog entry.',
                ],[
                    'label' => 'Layout Type',
                    'name' => 'layout',
                    'placeholder' => '',
                    'type' => 'layout_selector',
                    'help_block' => 'Select the page\'s layout.',
                ],[
                    'label' => 'Description',
                    'name' => 'description',
                    'placeholder' => 'Page Description Block',
                    'type' => 'textarea',
                    'help_block' => 'The title of the page.',
                ],[
                    'label' => 'Meta Title',
                    'name' => 'settings[meta_data][title]',
                    'placeholder' => 'Page Meta Title',
                    'type' => 'text',
                    'help_block' => 'Leave this blank if you wish to use the Page Title above as the title.',
                ],[
                    'label' => 'Meta Description',
                    'name' => 'settings[meta_data][description]',
                    'placeholder' => 'Description Block',
                    'type' => 'textarea',
                    'help_block' => 'The title of the page.',
                ],[
                    'label' => 'Meta Keywords',
                    'name' => 'settings[meta_data][keywords]',
                    'placeholder' => 'Meta Keywords',
                    'type' => 'text',
                    'help_block' => 'The meta keywords of the page.',
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

        $this->meta->available_layouts = config('app.available_layouts');

    }

    /**
     * Display a listing of the resource.
     *
     * @param  Website  P3in\Models\Website
     * @return Response
     */
    public function index(Website $websites)
    {
        $this->records = $websites->pages;

        return $this->build('index', ['websites', $websites->id, 'pages']);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param  Website  P3in\Models\Website
     * @return Response
     */
    public function create(Website $websites)
    {
        $this->meta->create->route = [$this->meta->create->route, $websites->id];

        $this->meta->page_list = Page::ofWebsite($websites)->isActive()->lists('title', 'id')->put('' , 'No Parent')->reverse();

        return $this->build('create', ['websites', $websites->id, 'pages']);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @param  Website  P3in\Models\Website
     * @return Response
     */
    public function store(Request $request, Website $websites)
    {

        $page = new Page($request->all());

        $page->name = strtolower(str_replace(' ', '_', trim($page->title)));

        $page->published_at = Carbon::now();

        $page->website()->associate($websites);

        $page->save();

        if ($request->has('parent')) {

            $parent = Page::ofWebsite($websites)->findOrFail($request->get('parent'));

            $page->parent()->associate($parent);

        }

        $page->url = $page->getUrl();

        $page->save();

        if ($request->has('settings')) {

            $page->settings($request->settings);

        }

        $this->record = $page;

        return $this->json($this->setBaseUrl(['websites', $websites->id, 'pages', $this->record->id, 'edit']));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $website_id
     * @param  int  $page_id
     * @return Response
     */
    public function show(Website $websites, Page $pages)
    {
        $this->record = $pages->load('sections');

        $this->setBaseUrl(['websites', $websites->id, 'pages', $pages->id]);

        $this->meta->data_target = '#content-edit';

        return view('pages::show')
            ->with('website', $websites)
            ->with('page', $this->record)
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
    public function edit(Website $websites, Page $pages)
    {
        $this->meta->page_list = Page::ofWebsite($websites)->isNot($pages->id)
            ->isActive()
            ->lists('title', 'id')
            ->put('' , 'No Parent')
            ->reverse();

        $this->record = $pages;

        if (!empty($this->record->parent->id)) {

            $this->record->parent = $this->record->parent->id;

        }
        $this->record->settings = $this->record->settings->data;

        $this->meta->data_target = '#content-edit';

        return $this->build('edit', ['websites', $websites->id, 'pages', $pages->id]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, Website $websites, Page $pages)
    {

        if ($request->has('parent')) {
            $parent = Page::ofWebsite($websites)->findOrFail($request->get('parent'));
            $pages->parent()->associate($parent);
        }

        if ($request->has('settings')) {

            $pages->settings($request->settings);

        }

        $pages->url = $pages->getUrl();

        $pages->update($request->except(['settings', 'parent']));

        return $this->json($this->setBaseUrl(['websites', $websites->id, 'pages', $pages->id, 'edit']));
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy(Website $websites, Page $pages)
    {

        $this->record = $pages;

        $this->record->delete();

        return $this->json($this->setBaseUrl(['websites', $websites->id, 'pages']));
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
            $current_nav = $sections['page'][$layout_part] = Navmenu::byName('tmp_current_template', 'Current Template');

            foreach ($page->sections()->where('section', $layout_part)->get() as $section) {

                $nav_item = $section->getNavigationItem([
                    'url' => 'section/'.$section->pivot->id.'/edit',
                    'props' => []
                ]);

                $nav_item->id = $section->pivot->id;

                $current_nav->navitems->push($nav_item);

            }

            $current_templates_nav = $sections['available'][$layout_part] = Navmenu::byName('tmp_'.strtolower($layout_part).'_template', ucfirst($layout_part).' Template');

            foreach (Section::where('fits', $layout_part)->get() as $section) {
                $nav_item = $section->getNavigationItem([
                    'url' => '',
                    'props' => ['id' => $section->id]
                ]);

                $current_templates_nav->navitems->push($nav_item);

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

        return $left_panels;

    }
}
