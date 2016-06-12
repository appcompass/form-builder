<?php

namespace P3in\Seeders;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Modular;
use P3in\Models\Group;
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

        $perm->label = 'Alerts: Info Level';
        $perm->description = 'Permission to see info level alerts';
        $perm->locked = true;

        $perm->save();

        if (Modular::isLoaded('users')) {
            if ($cp_manager = Group::where('name', 'cp-admin')->first()) {
                $cp_manager->grantPermissions($perm);
            }

            if ($group = Group::where('name', 'users')->first()) {
                $group->grantPermissions($perm);
            }
        }

        Model::reguard();
    }
}
