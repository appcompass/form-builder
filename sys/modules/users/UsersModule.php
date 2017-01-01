<?php

namespace P3in;

use Modular;
// use P3in\Models\Navmenu;
// use P3in\Models\Permission;
// use P3in\Models\Website;
use P3in\BaseModule;
// use P3in\Models\Profiles\Facebook;
// use P3in\Models\Profiles\Profile;
// use P3in\Traits\NavigatableTrait as Navigatable;

Class UsersModule extends BaseModule
{

    // use Navigatable;

    public $module_name = 'users';


    protected $profiles = [
        // 'facebook_profile' => Facebook::class,
    ];

    public function __construct()
    {
        \Log::info('Loading <Users> Module');
    }

    public function bootstrap()
    {
        \Log::info('Boostrapping <Users> Module');
    }

    public function register()
    {
        \Log::info('Registering <Users> Module');
        // Profile::registerProfiles($this->profiles);
    }

    /**
     *
     */
    // public function makeLink()
    // {
    //     return [
    //         [
    //             'label' => 'User Manager',
    //             'belongs_to' => ['cp_main_nav'],
    //             'sub_nav' => 'cp_main_nav_users',
    //             'req_perms' => null,
    //             'order' => 2,
    //             'props' => [
    //                 'icon' => 'users',
    //             ],
    //         ], [
    //             'label' => 'All Users',
    //             'belongs_to' => ['cp_main_nav_users'],
    //             'sub_nav' => '',
    //             'req_perms' => Permission::createCpRoutePerm('user.index'),
    //             'order' => 1,
    //             'props' => [
    //                 'icon' => 'user',
    //                 'link' => [
    //                     'href' => '/users',
    //                 ],
    //             ],
    //         ], [
    //             'label' => 'Group Manager',
    //             'belongs_to' => ['cp_main_nav_users'],
    //             'sub_nav' => '',
    //             'req_perms' => Permission::createCpRoutePerm('groups.index'),
    //             'order' => 2,
    //             'props' => [
    //                 'icon' => 'group',
    //                 'link' => [
    //                     'href' => '/groups',
    //                 ],
    //             ],
    //         ], [
    //             'label' => 'Permissions Manager',
    //             'belongs_to' => ['cp_main_nav_users'],
    //             'sub_nav' => '',
    //             'req_perms' => Permission::createCpRoutePerm('permissions.index'),
    //             'order' => 3,
    //             'props' => [
    //                 'icon' => 'key',
    //                 'link' => [
    //                     'href' => '/permissions',
    //                 ],
    //             ],
    //         ], [
    //             'label' => 'Group Details',
    //             'belongs_to' => ['cp_groups_subnav'],
    //             'sub_nav' => '',
    //             'req_perms' => Permission::createCpRoutePerm('groups.edit'),
    //             'order' => 1,
    //             'props' => [
    //                 'icon' => 'info-circle',
    //                 'link' => [
    //                     'href' => '/edit',
    //                 ],
    //             ],
    //         ], [
    //             'label' => 'Group Permissions',
    //             'belongs_to' => ['cp_groups_subnav'],
    //             'sub_nav' => '',
    //             'req_perms' => Permission::createCpRoutePerm('groups.permissions.index'),
    //             'order' => 2,
    //             'props' => [
    //                 'icon' => 'key',
    //                 'link' => [
    //                     'href' => '/permissions',
    //                 ],
    //             ],
    //         ], [
    //             'label' => 'User Permissions',
    //             'belongs_to' => ['cp_users_subnav'],
    //             'sub_nav' => '',
    //             'req_perms' => Permission::createCpRoutePerm('users.permissions.index'),
    //             'order' => 2,
    //             'props' => [
    //                 'icon' => 'key',
    //                 'link' => [
    //                     'href' => '/permissions',
    //                 ],
    //             ],
    //         ], [
    //             'label' => 'User Groups',
    //             'belongs_to' => ['cp_users_subnav'],
    //             'sub_nav' => '',
    //             'req_perms' => Permission::createCpRoutePerm('users.groups.index'),
    //             'order' => 3,
    //             'props' => [
    //                 'icon' => 'group',
    //                 'link' => [
    //                     'href' => '/groups',
    //                 ],
    //             ],
    //         ],
    //     ];
    // }

}
