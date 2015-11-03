<?php

namespace P3in\Modules;

use Modular;
use P3in\Models\Navmenu;
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

        if (Modular::isLoaded('navigation')) {
            $main_nav = Navmenu::byName('cp_main_nav');
            $main_nav_sub_nav =  Navmenu::byName('cp_main_nav_pages', 'Pages Manager');
            $pages_subnav = Navmenu::byNave('cp_pages_subnav');

            $main_nav_sub_nav->addItem($this->navItem);
            $main_nav->addChildren($main_nav_sub_nav);
        }

    }


    /**
     * Provides means for creating a NavigationItem item
     *
     */
    public function makeLink()
    {
        $cp_website = Website::first();

        return [
            "label" => "{$cp_website->site_name} Pages",
            "url" => "",
            "new_tab" => "false",
            "req_perms" => null,
            "props" => [
                "icon" => "pencil",
                "link" => [
                    "data-click" => "/cp/websites/{$cp_website->id}/pages",
                    "data-target" => "#main-content",
                    "href" => "javascript:;",
                ]
            ]
      ];
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
                'sub_section_name' => 'Sub Sections',
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