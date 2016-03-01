<?php

namespace P3in\Seeders;

use P3in\Models\Photo;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use P3in\Models\Navmenu;
use P3in\Models\Option;
use P3in\Models\Page;
use P3in\Models\Website;

class VideosModuleDatabaseSeeder extends Seeder
{

    /**
    * Run the database seeds.
    *
    * @return void
    */
    public function run()
    {
        Model::unguard();

        if (\Modular::isLoaded('websites')) {

            $control_panel = Website::admin();
            $cp_galleries_subnav = Navmenu::byName('cp_galleries_subnav');

            $control_panel->navmenus()->save($cp_galleries_subnav);

            $page = Page::firstOrNew([
                'description' => 'Videos in this gallery',
                'active' => true,
                'title' => 'Videos',
                'order' => 2,
                'slug' => 'videos',
                "url" => '/videos',
                'name' => 'cp_galleries_videos',
            ]);

            $page->published_at = Carbon::now();

            $control_panel->pages()->save($page);

            $cp_galleries_subnav->addItem($page, 2, [
                'props' => [
                    'icon' => 'camera',
                    'link' => [
                        'href' => '/videos',
                        'data-target' => '#record-detail'
                    ]
                ]
            ]);

        }

        Model::reguard();
    }
}
