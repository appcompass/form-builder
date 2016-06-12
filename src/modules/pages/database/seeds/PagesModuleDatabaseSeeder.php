<?php

namespace P3in\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use P3in\Models\Navmenu;
use P3in\Models\Page;
use P3in\Models\Website;

class PagesModuleDatabaseSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $control_panel = Website::admin();

        Page::where('name','cp_pages_info')->delete();

        $page = Page::firstOrNew([
            'name' => 'cp_pages_info',
            'title' => 'Page Info',
            'description' => 'Page Info',
            'slug' => 'edit',
            'url' => '/edit',
            'order' => 2,
            'active' => true
        ]);

        $page->published_at = Carbon::now();

        $control_panel->pages()->save($page);

        $pages_subnav = Navmenu::byName('cp_pages_subnav');

        $control_panel->navmenus()->save($pages_subnav);

        $pages_subnav->addItem($page, 2, [
            'props' => [
                // 'icon' => 'file-text-o',
                'icon' => 'globe',
                'link' => [
                    'href' => '/websites/'.$control_panel->id.'/pages',
                    'data-target' => '#content-edit'
                ]
            ]
        ]);

        Model::reguard();
    }
}
