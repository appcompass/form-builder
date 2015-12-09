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

    	Permission::create([
    		'type' => 'create-galleries',
    		'label' => 'Create Galleries',
    		'description' => 'User is able to create galleries'
    	]);
    }
}
