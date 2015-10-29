<?php

namespace P3in\Seeders;

use DB;
use Illuminate\Database\Seeder;
use P3in\Models\Website;

class UiWebsitesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        // This is here as a placeholder only.  this should never be run automatically because each app install has it's
        // own config. We actually need to look into building a command line config tool that takes params for setting
        // up the CMS website and the first Admin User.

        Website::create([
            'site_name' => 'CMS Admin CP',
            'site_url' => 'https://cp.p3in.com',
            'config' => [],
        ]);
    }
}
