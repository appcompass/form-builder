<?php

namespace P3in\Seeders;

use Illuminate\Database\Seeder;
use P3in\Models\Permission;
use DB;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	DB::table('permissions')->delete();

    	// factory('P3in\Models\Permission', 3)->create();

    	Permission::create([
    		'name' => 'registered',
    		'label' => 'registered',
    		'description' => 'Lorem Ipsum'
    	]);
    }
}
