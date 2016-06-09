<?php

namespace P3in\Seeders;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use P3in\Models\Permission;
use P3in\Seeders\UiFieldsTableSeeder;

class AlertsModuleDatabaseSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $perm = Permission::firstOrNew([
            'type' => 'alert.info',
        ]);

        $perm->label = 'Info Level Alerts';
        $perm->description = 'Permission to see info level alerts';
        $perm->locked = true;

        $perm->save();

        Model::reguard();
    }
}
