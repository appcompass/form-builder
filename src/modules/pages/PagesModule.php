<?php

namespace P3in\Modules;

use Modular;
use P3in\Models\Navmenu;
use P3in\Models\NavigationItem;
use P3in\Models\Website;
use P3in\Modules\BaseModule;
use P3in\Traits\NavigatableTrait as Navigatable;

Class PagesModule extends BaseModule
{

    use Navigatable;

    public $module_name = "pages";

    public function __construct() {}

    public function bootstrap() {}

    public function register()
    {

        $this->checkOrSetUiConfig();

        $main_nav_sub_nav =  Navmenu::byName('cp_main_nav_pages', 'Pages Manager');

        Navmenu::byName('cp_main_nav')
            ->addChildren($main_nav_sub_nav);

        foreach(Website::all() as $website) {
            $item = $this->navItem([
                'label' => $website->site_name.' Pages',
                'url' => '',
                'props' => [
                    'icon' => 'pencil',
                    'link' => [
                        'data-click' => '/cp/websites/'.$website->id.'/pages',
                        'data-target' => '#main-content'
                    ]
                ]
            ])->first();

            $main_nav_sub_nav->addItem($item);

        }

    }


    /**
     * Provides means for creating a NavigationItem item
     *
     */
    public function makeLink()
    {
        //
        //  This should only provide menu links for editing ALL the pages
        //  for single page/all pages in a website refer to Page model.
        //  Website pages is mediated through websites.
        //
    }

    /**
     *  Set CMS module's config
     *
     */
    public function checkOrSetUiConfig() {

        $module = Modular::get($this->module_name);

            $module->config = [
                'base_url' => "/cp/{$this->module_name}",
                'index' => [
                    'heading' => 'Manage Websites',
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
                                'target' => '#main-content',
                            ],
                            'name' => [
                                'type' => 'link_by_id',
                                'target' => '#main-content',
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
                'heading' => 'Page Informations',
                'sub_section_name' => 'Page Administration',
            ],
            'edit' => [
                'heading' => 'Page Informations',
                'route' => 'cp.pages.update'
            ],
            'create' => [
                'heading' => 'Create New Page',
                'route' => 'cp.pages.store'
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
                        'label' => 'Name',
                        'name' => 'name',
                        'placeholder' => 'Page Name',
                        'type' => 'text',
                        'help_block' => 'Name to be used to reference the page internally.',
                    ],[
                        'label' => 'Description',
                        'name' => 'description',
                        'placeholder' => 'Page Description Block',
                        'type' => 'textarea',
                        'help_block' => 'The title of the page.',
                    ],[
                        'label' => 'active',
                        'name' => 'Published',
                        'placeholder' => '',
                        'type' => 'checkbox',
                        'help_block' => 'is the page published?',
                    ]
                ]
            ]
        ];
        return $module->save();
    }


}