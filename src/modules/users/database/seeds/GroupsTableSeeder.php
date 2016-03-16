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

		// Clone me
		// Group::create(['name' => '', 'label' => '', 'description' => '', 'active' => true]);

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
			'units_photos',
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
			'units_photos',
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

		Group::create(['name' => 'debug', 'label' => 'Debug', 'description' => 'Debug BAS Group', 'active' => true]);
		Group::create(['name' => 'ra-lm', 'label' => 'RA LM', 'description' => 'RA LM Bas Group', 'active' => true]);
		Group::create(['name' => 'ra-media', 'label' => 'RA Media', 'description' => 'RA Media Bas Group', 'active' => true]);
		Group::create(['name' => 'classes', 'label' => 'Classes', 'description' => 'Classes Bas Group', 'active' => true]);
		Group::create(['name' => 'static', 'label' => 'Static', 'description' => 'Static BAS Group', 'active' => true]);
		Group::create(['name' => 'emails', 'label' => 'Emails', 'description' => 'Emails Bas Group', 'active' => true]);
		Group::create(['name' => 'media', 'label' => 'Media', 'description' => 'Media Bas Group', 'active' => true]);
		Group::create(['name' => 'media-admin', 'label' => 'Media Admin', 'description' => 'MediaAdmin Bas Group', 'active' => true]);
		Group::create(['name' => 'cl-poster', 'label' => 'CLPoster', 'description' => 'CLPoster BAS Group', 'active' => true]);
		Group::create(['name' => 'fd-manager', 'label' => 'FD Manager', 'description' => 'FD Manager BAS Group', 'active' => true]);
		Group::create(['name' => 'nofreeze', 'label' => 'No Freeze', 'description' => 'No Freeze Bas Group', 'active' => true]);
		Group::create(['name' => 'sm', 'label' => 'SM', 'description' => 'SM Bas Group', 'active' => true]);
		Group::create(['name' => 'sa', 'label' => 'SA', 'description' => 'SA Bas Group', 'active' => true]);
		Group::create(['name' => 'keys', 'label' => 'Keys', 'description' => 'Keys Bas Group', 'active' => true]);
		Group::create(['name' => 'training-manager', 'label' => 'Training Manager', 'description' => 'Training Manager Bas Group', 'active' => true]);
		Group::create(['name' => 'lm', 'label' => 'LM', 'description' => 'LM Bas Group', 'active' => true]);
		Group::create(['name' => 'resmet', 'label' => 'Resmet', 'description' => 'Resmet BAS Group', 'active' => true]);
		Group::create(['name' => 'tech', 'label' => 'Tech', 'description' => 'Tech BAS Group', 'active' => true]);
		Group::create(['name' => 'resmet-r', 'label' => 'ResmetR', 'description' => 'ResmetR BAS Group', 'active' => true]);
	}
}
