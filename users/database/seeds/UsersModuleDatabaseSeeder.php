<?php

namespace P3in\Seeders;

use Illuminate\Database\Seeder;
use P3in\Models\ResourceBuilder;
use Illuminate\Database\Eloquent\Model;
use P3in\Models\User;
use P3in\Models\Permission;
use P3in\Models\Form;

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

        \DB::statement('TRUNCATE users CASCADE');
        \DB::statement('TRUNCATE permissions CASCADE');

        $this->call(GroupsTableSeeder::class);
        $this->call(PermissionsSeeder::class);
        // $this->call(UsersTableSeeder::class);
        // $this->call(UserUiFieldsSeeder::class);

        //
        //  USERS
        //

        \DB::statement("DELETE FROM forms WHERE name = 'users'");
        // generate 20 dummy permissions
        factory(Permission::class, 20)->create();
        // generate 1000 dummy users and assign 3 random permissions each
        factory(User::class, 100)->create()->each(function($user) {
            $user->permissions()->saveMany(Permission::inRandomOrder()->limit(3)->get());
        });

        // @NOTE ResourceBuilder Parameters:
        //      FormName // Resource Pointer (vue-resource syntax) // callback
        // @IDEAS for the API
        // $builder->actions('edit')->permissions('users.own.edit');
        // $builder->datetime('End of absence', 'settings.absent.end'); <- working

        ResourceBuilder::new('users', 'users/{id}', function(ResourceBuilder $builder) {
            $builder->string('First Name', 'first_name')->list()->required()->sortable()->searchable();
            $builder->string('Last Name', 'last_name')->list()->required()->sortable()->searchable();
            $builder->string('Email', 'email')->list()->required()->validation('email')->sortable()->searchable();
            $builder->string('Date Added', 'created_at')->list()->edit(false)->sortable();
            $builder->secret()->required();
        })->setAlias(['users.index', 'users.show', 'users.create']);

        //
        //  GROUPS
        //
        \DB::statement("DELETE FROM forms WHERE name = 'groups'");

        ResourceBuilder::new('groups', 'groups/{id}', function(ResourceBuilder $builder) {
            $builder->string('Group Name', 'name')->list()->required()->sortable()->searchable();
            $builder->string('Group Label', 'label')->list()->required()->sortable()->searchable();
            $builder->text('Description', 'description')->list(false)->required()->sortable()->searchable();
            $builder->string('Date Added', 'created_at')->list()->edit(false)->sortable();
        })->setAlias(['groups.index', 'groups.show', 'groups.create']);

        Model::reguard();
    }
}
