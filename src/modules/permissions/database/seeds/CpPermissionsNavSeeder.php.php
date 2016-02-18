<?php

namespace P3in\Seeders;

use Carbon\Carbon;
use DB;
use Illuminate\Database\Seeder;
use P3in\Models\Navmenu;
use P3in\Models\Page;
use P3in\Models\Permission;
use P3in\Models\Website;

class CpPermissionsNavSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (\Modular::isLoaded('websites')) {

            $control_panel = Website::admin();

            // $permissions = Page::firstOrNew([
            //     'description' => 'Permissions Manager',
            //     'active' => true,
            //     'title' => 'Permissions',
            //     'order' => 2,
            //     'slug' => 'permissions',
            //     'name' => 'cp_users_permissions',
            //     "published_at" => Carbon::now(),
            // ]);

            // $permissions->website()->associate($control_panel);

            // $permissions->save();

            $groups = Page::firstOrNew([
                'description' => 'Groups Manager',
                'active' => true,
                'title' => 'Groups Manager',
                'order' => 2,
                'slug' => 'groups',
                'name' => 'cp_users_groups',
                "published_at" => Carbon::now(),
            ]);

            $groups->website()->associate($control_panel);

            $groups->save();

            // Navmenu::byName('cp_main_nav_users')->addItem($permissions, 1, [
            //     'props' => [
            //         'icon' => 'user',
            //         'link' => [
            //             'href' => '/permissions',
            //             'data-target' => '#record-detail'
            //         ]
            //     ]
            // ]);

            Navmenu::byName('cp_main_nav_users')->addItem($groups, 2, [
                'props' => [
                    'icon' => 'users',
                    'link' => [
                        'href' => '/groups',
                        'data-target' => '#record-detail'
                    ]
                ]
            ]);

            //
            // GROUP INTERNAL SUBNAV
            //

            $groups_subnav = Navmenu::byName('cp_groups_subnav');

            //
            // GROUP INFO
            //
            $group_info = Page::firstOrNew([
                'name' => 'cp_groups_info',
                'title' => 'Group Details',
                'description' => 'Group informations',
                'slug' => 'edit',
                'order' => 1,
                'active' => true,
                'published_at' => Carbon::now()
            ]);

            $group_info->website()->associate($control_panel);

            $group_info->save();

            $groups_subnav->addItem($group_info);

            //
            // GROUP PERMISSIONS
            //
            $group_permissions = Page::firstOrNew([
                'name' => 'cp_groups_permissions',
                'title' => 'Permissions',
                'description' => 'Group permissions',
                'slug' => 'permissions',
                'order' => 2,
                'active' => true,
                'published_at' => Carbon::now()
            ]);

            $group_permissions->website()->associate($control_panel);

            $group_permissions->save();

            $groups_subnav->addItem($group_permissions);

            //
            //  USER INTERNAL SUBNAV
            //
            $user_subnav = Navmenu::byName('cp_users_subnav');

            //
            //  USER PERMISSIONS
            //
            $user_permissions = Page::firstOrNew([
                'name' => 'cp_user_permissions',
                'title' => 'Permissions',
                'description' => 'User\'s permissions',
                'slug' => 'permissions',
                'order' => 2,
                'active' => true,
                'published_at' => Carbon::now()
            ]);

            $user_permissions->website()->associate($control_panel);

            $user_permissions->save();

            $user_subnav->addItem($user_permissions);

            //
            //  USER GROUPS
            //
            $user_groups = Page::firstOrNew([
                'name' => 'cp_user_groups',
                'title' => 'Groups',
                'description' => 'User\'s groups',
                'slug' => 'groups',
                'order' => 3,
                'active' => true,
                'published_at' => Carbon::now()
            ]);

            $user_groups->website()->associate($control_panel);

            $user_groups->save();

            $user_subnav->addItem($user_groups);

        }


    }
}
