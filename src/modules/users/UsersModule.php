<?php

namespace P3in\Modules;

use Modular;
use P3in\Models\Navmenu;
use P3in\Models\Website;
use P3in\Modules\BaseModule;
use P3in\Traits\NavigatableTrait as Navigatable;

Class UsersModule extends BaseModule
{

    use Navigatable;

    public $module_name = "users";

    public function __construct()
    {

    }

    public function bootstrap()
    {
        // echo "Bootstrapping UsersModule!";
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
                "label" => 'Users Manager',
                'belongs_to' => ['cp_main_nav'],
                'sub_nav' => 'cp_main_nav_users',
                "req_perms" => 'cp-users-manager',
                'order' => 2,
                "props" => [
                    "icon" => "user",
                ],
            ], [
                "label" => 'All Users',
                'belongs_to' => ['cp_main_nav_users'],
                'sub_nav' => '',
                "req_perms" => 'cp-users-manager',
                'order' => 1,
                "props" => [
                    "icon" => "user",
                    "link" => [
                        'href' => "/users",
                    ],
                ],
            ], [
                "label" => 'Groups Manager',
                'belongs_to' => ['cp_main_nav_users'],
                'sub_nav' => '',
                "req_perms" => 'cp-groups-manager',
                'order' => 2,
                "props" => [
                    "icon" => "user",
                    "link" => [
                        'href' => "/groups",
                    ],
                ],
            ], [
                "label" => 'Permissions Manager',
                'belongs_to' => ['cp_main_nav_users'],
                'sub_nav' => '',
                "req_perms" => 'cp-permissions-manager',
                'order' => 3,
                "props" => [
                    "icon" => "user",
                    "link" => [
                        'href' => "/permissions",
                    ],
                ],
            ], [
                "label" => 'Groups Details',
                'belongs_to' => ['cp_groups_subnav'],
                'sub_nav' => '',
                "req_perms" => 'cp-groups-manager',
                'order' => 1,
                "props" => [
                    "icon" => "user",
                    "link" => [
                        'href' => "/edit",
                    ],
                ],
            ], [
                "label" => 'Groups Permissions',
                'belongs_to' => ['cp_groups_subnav'],
                'sub_nav' => '',
                "req_perms" => 'cp-groups-permissions-manager',
                'order' => 2,
                "props" => [
                    "icon" => "user",
                    "link" => [
                        'href' => "/permissions",
                    ],
                ],
            ], [
                "label" => 'User Permissions',
                'belongs_to' => ['cp_users_subnav'],
                'sub_nav' => '',
                "req_perms" => 'cp-users-permissions-manager',
                'order' => 2,
                "props" => [
                    "icon" => "user",
                    "link" => [
                        'href' => "/permissions",
                    ],
                ],
            ], [
                "label" => 'User Groups',
                'belongs_to' => ['cp_users_subnav'],
                'sub_nav' => '',
                "req_perms" => 'cp-users-groups-manager',
                'order' => 3,
                "props" => [
                    "icon" => "user",
                    "link" => [
                        'href' => "/groups",
                    ],
                ],
            ],
        ];
    }

}