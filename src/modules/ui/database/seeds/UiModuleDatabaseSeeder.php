<?php

namespace P3in\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class UiModuleDatabaseSeeder extends Seeder
{

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Model::unguard();

		// $this->call('P3in\Seeders\UiWebsitesTableSeeder');

		Model::reguard();
	}
}
