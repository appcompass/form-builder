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
        if (\Modular::isLoaded('websites') && \Modular::isLoaded('navigation') && \Modular::isLoaded('pages')) {

            //
            //  INIT NAVMENUS
            //

            $control_panel = Website::admin();

            $users_main_nav = Navmenu::byName('cp_main_nav_users');

            $control_panel->navmenus()->save($users_main_nav);

            //
            //  GROUPS MANAGER
            //
            $groups = Page::firstOrNew([
                'description' => 'Groups Manager',
                'active' => true,
                'title' => 'Groups Manager',
                'order' => 2,
                'slug' => 'groups',
                'name' => 'cp_users_groups',
            ]);

            $groups->published_at = Carbon::now();

            $control_panel->pages()->save($groups);

            $users_main_nav->addItem($groups, 2, [
                'props' => [
                    'icon' => 'users',
                    'link' => [
                        'href' => '/groups',
                        'data-target' => '#record-detail'
                    ]
                ]
            ]);

            //
            //  PERMISSIONS MANAGER
            //
            $groups = Page::firstOrNew([
                'description' => 'Permissions Manager',
                'active' => true,
                'title' => 'Permissions Manager',
                'order' => 2,
                'slug' => 'permissions',
                'name' => 'cp_users_permissions',
            ]);

            $groups->published_at = Carbon::now();

            $control_panel->pages()->save($groups);

            $users_main_nav->addItem($groups, 2, [
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

            $control_panel->navmenus()->save($groups_subnav);
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
            ]);

            $group_info->published_at = Carbon::now();

            $control_panel->pages()->save($group_info);

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
                'active' => true
            ]);

            $group_permissions->published_at = Carbon::now();

            $control_panel->pages()->save($group_permissions);

            $groups_subnav->addItem($group_permissions);

            //
            //  USER INTERNAL SUBNAV
            //
            $user_subnav = Navmenu::byName('cp_users_subnav');

            $control_panel->navmenus()->save($user_subnav);
            //
            //  USER PERMISSIONS
            //
            $user_permissions = Page::firstOrNew([
                'name' => 'cp_user_permissions',
                'title' => 'Permissions',
                'description' => 'User\'s permissions',
                'slug' => 'permissions',
                'order' => 2,
                'active' => true
            ]);

            $user_permissions->published_at = Carbon::now();

            $control_panel->pages()->save($user_permissions);

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
                'active' => true
            ]);

            $user_groups->published_at = Carbon::now();

            $control_panel->pages()->save($user_groups);

            $user_subnav->addItem($user_groups);

        }

    }
}
