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

		Page::where('name','cp_pages_info')->delete();

		$page = new Page([
		    'description' => 'Page Info',
		    'published_at' => Carbon::now(),
		    'active' => true,
		    'parent' => null,
		    'req_permission' => null,
		    'title' => 'Page Info',
		    'order' => 1,
		    'slug' => 'edit',
		    'name' => 'cp_pages_info',
		    'content' => [],
		]);

		$page->linkToWebsite(Website::first());

		Navmenu::byName('cp_pages_subnav')->addItem($page, 1);

		Model::reguard();
	}
}
