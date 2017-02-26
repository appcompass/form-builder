<?php

namespace P3in\Seeders;

use Illuminate\Database\Seeder;
use P3in\Builders\FormBuilder;
use P3in\Models\Permission;
use DB;

class PermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Permission::create([
            'type' => 'logged-user',
            'label' => 'User',
            'description' => 'The user can log into the application frontend (websites)',
            'locked' => true,
        ]);

        Permission::create([
            'type' => 'guest',
            'label' => 'Guest',
            'description' => 'Guest Permission',
            'locked' => true,
        ]);
    }
}
