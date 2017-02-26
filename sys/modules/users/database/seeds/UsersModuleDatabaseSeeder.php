<?php

namespace P3in\Seeders;

use Illuminate\Database\Eloquent\Model;
use P3in\Seeders\GroupsTableSeeder;
use P3in\Seeders\PermissionsSeeder;
use P3in\Seeders\UsersTableSeeder;
use Illuminate\Database\Seeder;
use P3in\Builders\FormBuilder;
use P3in\Models\Permission;
use P3in\Models\Form;
use P3in\Models\User;
use DB;

class UsersModuleDatabaseSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        DB::statement('TRUNCATE users CASCADE');
        DB::statement('TRUNCATE permissions CASCADE');
        DB::statement('TRUNCATE groups CASCADE');

        $this->call(GroupsTableSeeder::class);
        $this->call(PermissionsSeeder::class);
        $this->call(UsersTableSeeder::class);

        DB::statement("DELETE FROM forms WHERE name = 'users'");
        FormBuilder::new('users', function (FormBuilder $builder) {
            $builder->string('First Name', 'first_name')->list()->validation(['required'])->sortable()->searchable();
            $builder->string('Last Name', 'last_name')->list()->validation(['required'])->sortable()->searchable();
            $builder->string('Email', 'email')->list()->validation(['required', 'email'])->sortable()->searchable();
            $builder->string('Phone Number', 'phone')->list()->validation(['required'])->sortable()->searchable();
            $builder->boolean('Active', 'active')->list(false);
            $builder->string('Date Added', 'created_at')->list()->edit(false)->sortable();
            $builder->secret('Password', 'password')->validation(['required']);
        })->linkToResources(['users.index', 'users.show', 'users.create', 'users.update', 'users.store']);

        DB::statement("DELETE FROM forms WHERE name = 'groups'");
        FormBuilder::new('groups', function (FormBuilder $builder) {
            $builder->string('Group Name', 'name')->list()->validation(['required'])->sortable()->searchable();
            $builder->string('Group Label', 'label')->list()->validation(['required'])->sortable()->searchable();
            $builder->text('Description', 'description')->list(false)->validation(['required'])->sortable()->searchable();
            $builder->string('Date Added', 'created_at')->list()->edit(false)->sortable();
        })->linkToResources(['groups.index', 'groups.show', 'groups.store', 'groups.update']);

        DB::statement("DELETE FROM forms WHERE name = 'user-permissions'");
        FormBuilder::new('user-permissions', function (FormBuilder $builder) {
            $builder->string('Name', 'label')->list()->validation(['required'])->sortable()->searchable();
        })->linkToResources(['users.permissions.index']);

        DB::statement("DELETE FROM forms WHERE name = 'permissions'");
        FormBuilder::new('permissions', function (FormBuilder $builder) {
            $builder->string('Name', 'label')->list()->validation(['required'])->sortable()->searchable();
            $builder->text('Description', 'description')->list(false)->validation(['required'])->sortable()->searchable();
            $builder->string('Created', 'created_at')->list()->edit(false)->validation(['required'])->sortable()->searchable();
        })->linkToResources(['permissions.index', 'permissions.show', 'permissions.create', 'permissions.store', 'permissions.update']);

        Model::reguard();
    }
}
