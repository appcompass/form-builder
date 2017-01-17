<?php

namespace P3in\Seeders;

use Illuminate\Database\Seeder;
use P3in\Builders\FormBuilder;
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
        \DB::statement('TRUNCATE groups CASCADE');

        $this->call(GroupsTableSeeder::class);
        $this->call(PermissionsSeeder::class);
        // $this->call(UsersTableSeeder::class);
        // $this->call(UserUiFieldsSeeder::class);
        // factory(User::class, 30)->create()->each(function ($user) {
        //     $user->permissions()->saveMany(Permission::inRandomOrder()->limit(3)->get());
        // });


        //
        //  USERS
        //

        \DB::statement("DELETE FROM forms WHERE name = 'users'");

        // @NOTE ResourceBuilder Parameters:
        //      FormName // Resource Pointer (vue-resource syntax) // callback
        // @IDEAS for the API
        // $builder->actions('edit')->permissions('users.own.edit');
        // $builder->datetime('End of absence', 'settings.absent.end'); <- working

        FormBuilder::new('users', function(FormBuilder $builder) {
            $builder->string('First Name', 'first_name')->list()->required()->sortable()->searchable();
            $builder->string('Last Name', 'last_name')->list()->required()->sortable()->searchable();
            $builder->string('Email', 'email')->list()->required()->validation('email')->sortable()->searchable();
            $builder->string('Phone Number', 'phone')->list()->required()->sortable()->searchable();
            $builder->string('Date Added', 'created_at')->list()->edit(false)->sortable();
            $builder->secret()->required();
        })->linkToResources(['users.index', 'users.show', 'users.create']);

        //
        //  GROUPS
        //
        \DB::statement("DELETE FROM forms WHERE name = 'groups'");

        FormBuilder::new('groups', function (FormBuilder $builder) {
            $builder->string('Group Name', 'name')->list()->required()->sortable()->searchable();
            $builder->string('Group Label', 'label')->list()->required()->sortable()->searchable();
            $builder->text('Description', 'description')->list(false)->required()->sortable()->searchable();
            $builder->string('Date Added', 'created_at')->list()->edit(false)->sortable();
        })->linkToResources(['groups.index', 'groups.show', 'groups.create', ]);

        Model::reguard();
    }
}
