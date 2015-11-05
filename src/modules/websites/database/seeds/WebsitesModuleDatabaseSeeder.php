<?php

namespace P3in\Seeders;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
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

		Model::reguard();
	}
}
