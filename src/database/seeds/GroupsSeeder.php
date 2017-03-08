<?php

namespace P3in\Seeders;

use Illuminate\Database\Seeder;
use P3in\Builders\FormBuilder;
use P3in\Models\Group;
use DB;

class GroupsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // DB::statement('TRUNCATE groups CASCADE');
        // DB::statement("DELETE FROM forms WHERE name = 'user-permissions'");
        // DB::statement("DELETE FROM forms WHERE name = 'permissions'");

        FormBuilder::new('user-permissions', function (FormBuilder $builder) {
            $builder->string('Name', 'label')->list()->validation(['required'])->sortable()->searchable();
        })->linkToResources(['users.permissions.index']);

        FormBuilder::new('permissions', function (FormBuilder $builder) {
            $builder->string('Name', 'label')->list()->validation(['required'])->sortable()->searchable();
            $builder->text('Description', 'description')->list(false)->validation(['required'])->sortable()->searchable();
            $builder->string('Created', 'created_at')->list()->edit(false)->validation(['required'])->sortable()->searchable();
        })->linkToResources(['permissions.index', 'permissions.show', 'permissions.create', 'permissions.store', 'permissions.update']);

        Group::create(['name' => 'user', 'label' => 'User', 'description' => 'User exists', 'active' => true]);
        Group::create(['name' => 'admin', 'label' => 'Admin', 'description' => 'Administrators', 'active' => true]);
        Group::create(['name' => 'system', 'label' => 'System', 'description' => 'System users', 'active' => true]);

        //
        //  CP ADMINISTRATOR
        //
        // $cp_manager = Group::firstOrCreate([
        //     'name' => 'cp-admin',
        //     'label' => 'Control Panel Administrator',
        //     'description' => "User is allowed to do everything (super-user)",
        //     'active' => true
        // ]);


        //
        //  USER
        //
        // $group = Group::firstOrCreate([
        //     'name' => 'users',
        //     'label' => 'Users',
        //     'description' => 'Generic user group',
        //     'active' => true
        // ]);

        // $cp_manager->grantPermissions([]);
        // $group->grantPermissions(['logged-user']);
    }
}
