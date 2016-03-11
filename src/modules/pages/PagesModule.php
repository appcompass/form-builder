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

    }


    /**
     * Provides means for creating a NavigationItem item
     *
     */
    public function makeLink()
    {
        return [
            [
                "label" => 'Pages',
                'belongs_to' => ['cp_websites_subnav'],
                'sub_nav' => '',
                "req_perms" => 'cp-pages-manager',
                'order' => 3,
                "props" => [
                    "icon" => "user",
                    "link" => [
                        'href' => "/pages",
                    ],
                ],
            ], [
                "label" => 'Page Info',
                'belongs_to' => ['cp_pages_subnav'],
                'sub_nav' => '',
                "req_perms" => 'cp-pages-manager',
                'order' => 3,
                "props" => [
                    "icon" => "user",
                    "link" => [
                        'href' => "edit",
                    ],
                ],
            ],
        ];
    }

}