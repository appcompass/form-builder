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

        // Permission::create(['type' => '', 'label' => '', 'description' => '']);

        // USER
        $perm = Permission::firstOrNew([
            'type' => 'logged-user',
        ]);

        $perm->label = 'User';
        $perm->description = 'The user can log into the application frontend (websites)';
        $perm->locked = true;

        $perm->save();

        $perm = Permission::firstOrNew([
            'type' => 'guest',
        ]);

        $perm->label = 'Guest';
        $perm->description = 'Guest Permission';
        $perm->locked = true;

        $perm->save();

        // And we also have the null permissions

        // // CP
        // Permission::create(['type' => 'cp-user', 'label' => 'Basic Admin', 'description' => 'Grants basic Control Panel access']);
        // Permission::create(['type' => 'cp-websites-manager', 'label' => 'Manage Websites', 'description' => 'Can manage existing websites']);
        // Permission::create(['type' => 'cp-users-manager', 'label' => 'Manage Users', 'description' => 'Ability to manage App Users']);
        // Permission::create(['type' => 'cp-galleries-manager', 'label' => 'Galleries Manager', 'description' => 'User is allowed to manage Unit Galleries']);

        // // FIELD UPLOAD
        // Permission::create(['type' => 'unit-field-upload-galleries', 'label' => 'Create Own Galleries', 'description' => 'Allow to create/edit only owned galleries']);

        // // UNITS/RESMET
        // Permission::create(['type' => 'cp-resmet-manager', 'label' => 'Browse Units', 'description' => 'Resmet Manager can browse and delete/sort photos']);
        // Permission::create(['type' => 'resmet-manager', 'label' => 'Browse Units', 'description' => 'Resmet Manager can browse and delete/sort photos']);
        // Permission::create(['type' => 'units', 'label' => 'Can Browse Units from CP', 'description' => 'Can browse Units']);
        // Permission::create(['type' => 'units_photos', 'label' => 'Can see unit photos', 'description' => 'Allowed to see Unit Photos']);

    }
}
