<?php

namespace P3in\Modules;

use P3in\Models\Permission;
use P3in\Modules\BaseModule;

Class MenusModule  extends BaseModule
{

    public $module_name = 'menus';

    public function __construct( )
    {

    }

    /**
    *   Add navItem
    *
    *
    */
    public function addNavItem(Link $item)
    {

    }

    public function bootstrap()
    {
    }

    public function register()
    {
    }

    /**
     *
     */
    public function makeLink()
    {
        return [
            [
                'label' => 'Menus',
                'belongs_to' => ['websites'],
                'sub_nav' => '',
                'req_perms' => Permission::createCpRoutePerm('websites.navigation.index'),
                'order' => 5,
                'props' => [
                    'icon' => 'bars',
                    'link' => [
                        'href' => '/menus',
                    ],
                ],
            ]
        ];
    }

}
