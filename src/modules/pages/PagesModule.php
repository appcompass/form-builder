<?php

namespace P3in\Modules;

use Modular;
use P3in\Models\NavigationItem;
use P3in\Models\Navmenu;
use P3in\Models\Permission;
use P3in\Models\Website;
use P3in\Modules\BaseModule;
use P3in\Traits\NavigatableTrait as Navigatable;

Class PagesModule extends BaseModule
{

    use Navigatable;

    public $module_name = 'pages';

    public function __construct() {}

    public function bootstrap() {}

    public function register()
    {

    }


    /**
     * Cp Nav parts for this module.
     *
     */
    public function makeLink()
    {
        return [
            [
                'label' => 'Pages',
                'belongs_to' => ['websites'],
                'sub_nav' => '',
                'req_perms' => Permission::createCpRoutePerm('websites.pages.index'),
                'order' => 3,
                'props' => [
                    'icon' => 'book',
                    'link' => [
                        'href' => '/pages',
                    ],
                ],
            ], [
                'label' => 'Page Info',
                'belongs_to' => ['cp_pages_subnav'],
                'sub_nav' => '',
                'req_perms' => Permission::createCpRoutePerm('websites.pages.edit'),
                'order' => 3,
                'props' => [
                    'icon' => 'info-circle',
                    'link' => [
                        'href' => '/edit',
                    ],
                ],
            ],
        ];
    }

}
