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

		//
		//	BOSTONPADS AGENT
		//
		$bp_agent = Group::create([
			'name' => 'bostonpads-agents',
			'label' => 'BostonPads Agents',
			'description' => 'User is a BostonPads Agent',
			'active' => true
		]);

		$bp_agent->grantPermissions([
			'unit-field-upload-galleries',
			'units',
			'resmet-manager'
		]);

		//
		//	BOSTONPADS MANAGER
		//
		$bp_manager = Group::create([
			'name' => 'bostonpads-managers',
			'label' => 'BostonPads managers',
			'description' => 'User is a BostonPads Manager',
			'active' => true
		]);

		$bp_manager->grantPermissions([
			'units',
			'unit-field-upload-galleries',
			'cp-resmet-manager',
			'resmet-manager'
		]);

		//
		//	CP ADMINISTRATOR
		//
		$cp_manager = Group::create([
			'name' => 'cp-admin',
			'label' => 'Control Panel Administrator',
			'description' => "User is allowed to do everything (super-user)",
			'active' => true
		]);

		$cp_manager->grantPermissions([]); // GateBefore instead of perms

		//
		//	USER
		//
		$group = Group::create([
			'name' => 'users',
			'label' => 'Users',
			'description' => 'Generic user group',
			'active' => true
		]);

		$group->grantPermissions(['logged-user']);
	}
}
