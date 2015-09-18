<?php

namespace P3in\Seeders;

use Illuminate\Database\Seeder;
use P3in\Models\Group;
use P3in\Models\Permission;
use DB;

class GroupsTableSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		DB::table('groups')->delete();

		$group = Group::create([
			'name' => 'users',
			'label' => 'Users',
			'description' => 'Generic user group',
			'active' => true
		])
			->permissions()
			->attach(Permission::first());
	}
}
