<?php

namespace P3in\Modules;

use P3in\Models\Permission;
use P3in\Modules\BaseModule;

Class NavigationModule extends BaseModule
{

    public $module_name = 'navigation';

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
        require_once('helpers/LinkClass.php');
    }

    public function register()
    {
        echo 'Registering Nav Module';
    }

    /**
     *
     */
    public function makeLink($overrides = [])
    {
        return [
            [
                'label' => 'Navigation',
                'belongs_to' => ['websites'],
                'sub_nav' => '',
                'req_perms' => Permission::createCpRoutePerm('websites.navigation.index', 'All Photos'),
                'order' => 5,
                'props' => [
                    'icon' => 'bars',
                    'link' => [
                        'href' => '/navigation',
                    ],
                ],
            ]
        ];
    }

}
