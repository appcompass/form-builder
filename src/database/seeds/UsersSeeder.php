<?php

namespace P3in\Seeders;

use Illuminate\Database\Seeder;
use App\User;
use P3in\Models\Permission;
use P3in\Models\Role;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        // @TODO there is no mention of 'locked' in the entire codebase. removing.
        Permission::create(['type' => 'logged-user', 'label' => 'User', 'description' => 'The user can log into the application frontend (websites)']);
        Permission::create(['type' => 'guest', 'label' => 'Guest', 'description' => 'Guest Permission']);
        Permission::create(['type' => 'media', 'label' => 'Media Editor', 'description' => 'Media Editor Permission' ]); // 'locked' => true // @TODO what's locked? ]);
        Permission::create(['type' => 'content', 'label' => 'Content Creator/Editor', 'description' => 'Content Creator/Editor' ]); // 'locked' => true // @TODO what's locked? ]); }

        // Role::create(['name' => 'null', 'label' => 'None Required', 'description' => 'No role required', 'active' => true]);
        Role::create(['name' => 'user', 'label' => 'User', 'description' => 'User exists', 'active' => true]);
        Role::create(['name' => 'admin', 'label' => 'Admin', 'description' => 'Administrators', 'active' => true]);
        Role::create(['name' => 'system', 'label' => 'System', 'description' => 'System users', 'active' => true]);

        User::create(['first_name' => 'System', 'last_name' => 'User', 'email' => 'system@p3in.com', 'phone' => '', 'password' => bcrypt('d3velopment')])->assignRole('system');
    }
}
