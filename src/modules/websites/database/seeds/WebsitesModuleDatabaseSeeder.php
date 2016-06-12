<?php

namespace P3in\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Modular;
use P3in\Models\Field;
use P3in\Models\Navmenu;
use P3in\Models\Page;
use P3in\Models\Website;

class WebsitesModuleDatabaseSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $website = Website::firstOrNew([
            'site_name' => env('ADMIN_WEBSITE_NAME', 'CMS Admin CP'),
            'site_url' => env('ADMIN_WEBSITE_URL', 'cp.p3in.com'),
        ]);

        $website->config = [];

        $website->save();


        if (Modular::isLoaded('ui')) {
            $website_header_list_field = Field::firstOrNew([
                'type' => 'selectlist',
                'name' => 'website_header_list',
                'source' => Website::class,
            ]);
            $website_header_list_field->save();

            $website_footer_list_field = Field::firstOrNew([
                'type' => 'selectlist',
                'name' => 'website_footer_list',
                'source' => Website::class,
            ]);
            $website_footer_list_field->save();


            // Run the websites meta data seeder
            $this->call(WebsitesMetaDataDatabaseSeeder::class);
        }

        Model::reguard();
    }
}
