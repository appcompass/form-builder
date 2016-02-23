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

class PhotosModuleDatabaseSeeder extends Seeder
{

    /**
    * Run the database seeds.
    *
    * @return void
    */
    public function run()
    {
        Model::unguard();

        Option::where('label', Photo::TYPE_ATTRIBUTE_NAME)->delete();

        Option::set(Photo::TYPE_ATTRIBUTE_NAME, [
            ['label' => 'Kitchen', 'order' => 1 ],
            ['label' => 'Master Bedroom', 'order' => 2 ],
            ['label' => 'Bedroom', 'order' => 3 ],
            ['label' => 'Living Room', 'order' => 4 ],
            ['label' => 'Hallway', 'order' => 5 ],
            ['label' => 'Master Bathroom', 'order' => 6 ],
            ['label' => 'Bathroom', 'order' => 7 ]
        ]);

        if (\Modular::isLoaded('websites')) {

            $control_panel = Website::admin();
            $cp_galleries_subnav = Navmenu::byName('cp_galleries_subnav');

            $control_panel->navmenus()->save($cp_galleries_subnav);

            $page = Page::firstOrNew([
                'description' => 'Photos in this gallery',
                'active' => true,
                'title' => 'Photos',
                'order' => 2,
                'slug' => 'photos',
                "url" => '/photos',
                'name' => 'cp_galleries_photos',
            ]);

            $page->published_at = Carbon::now();

            $control_panel->pages()->save($page);

            $cp_galleries_subnav->addItem($page, 2, [
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
