<?php

namespace P3in\Seeders;

use Carbon\Carbon;
use DB;
use Illuminate\Database\Seeder;
use P3in\Models\Group;
use P3in\Models\Navmenu;
use P3in\Models\Page;
use P3in\Models\Permission;
use P3in\Models\User;
use P3in\Models\Website;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (\Modular::isLoaded('websites') && \Modular::isLoaded('navigation') && \Modular::isLoaded('pages')) {
            $control_panel = Website::admin();

            $user_subnav = Navmenu::byName('cp_users_subnav');

            //
            // USER INFO
            //
            $user_info = Page::firstOrNew([
                'name' => 'cp_user_info',
                'title' => 'User Info',
                'description' => 'User informations',
                'slug' => 'edit',
                'order' => 1,
                'active' => true,
            ]);

            $user_info->published_at = Carbon::now();

            $user_info->website()->associate($control_panel);

            $user_info->save();

            $user_subnav->addItem($user_info);
        }
    }
}
