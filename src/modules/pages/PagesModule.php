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
            ->addChildren($main_nav_sub_nav, 3);

        foreach(Website::all() as $i => $website) {

            $item = $website->navItem([
                'label' => $website->site_name,
                'url' => 'cp/websites'.$website->id.'/pages',
                'props' => [
                    // 'icon' => 'file-text-o',
                    'icon' => 'globe',
                    'link' => [
                        'data-click' => '/cp/websites/'.$website->id.'/pages',
                        'data-target' => '#main-content'
                    ]
                ]
            ])->get()->first();

            $main_nav_sub_nav->addItem($item, $i);

        }

    }


    /**
     * Provides means for creating a NavigationItem item
     *
     */
    public function makeLink($overrides = [])
    {
        return array_replace([

        ], $overrides);
    }

    /**
     *  Set CMS module's config
     *
     */
    public function checkOrSetUiConfig() {

        $module = Modular::get($this->module_name);

            $module->config = [
                'base_url' => "/cp/pages",
                'index' => [
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
                'heading' => 'Add a page to this website',
                'route' => 'cp/pages/store'
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
        return $module->save();
    }


}