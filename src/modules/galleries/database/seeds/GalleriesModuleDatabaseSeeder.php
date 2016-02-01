<?php

namespace P3in\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use P3in\Models\Navmenu;
use P3in\Models\Page;
use P3in\Models\Website;

class GalleriesModuleDatabaseSeeder extends Seeder
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

            $website = Website::admin();

            $page = Page::firstOrNew([
                'name' => 'cp_gallery_info',
                'title' => 'Gallery Info',
                'description' => 'Gallery Info Details Form',
                'slug' => 'edit',
                'order' => 4,
                'active' => true,
                'req_permission' => null,
                "published_at" => Carbon::now(),
            ]);

            $page->website()->associate($website);

            $page->save();

            Navmenu::byName('cp_galleries_subnav')->addItem($page, 4, [
                'props' => [
                    'icon' => 'camera',
                    'link' => [
                        'href' => '/photos',
                        'data-target' => '#record-detail'
                    ]
                ]
            ]);

        }


        Model::reguard();
    }
}
