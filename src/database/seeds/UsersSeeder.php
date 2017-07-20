<?php

namespace P3in\Seeders;

use Illuminate\Database\Seeder;
use P3in\Models\User;
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
        //@Note: Locked means the role is fixed and not editable by the UI.
        $loggedInPerm = Permission::create(['name' => 'logged-user', 'label' => 'User', 'description' => 'The user can log into the application frontend (websites)']);
        $guestPerm = Permission::create(['name' => 'guest', 'label' => 'Guest', 'description' => 'Guest Permission']);
        $mediaPerm = Permission::create(['name' => 'media', 'label' => 'Media Editor', 'description' => 'Media Editor Permission' ]); // 'locked' => true // @TODO what's locked? ]);
        $contentPerm = Permission::create(['name' => 'content', 'label' => 'Content Creator/Editor', 'description' => 'Content Creator/Editor' ]); // 'locked' => true // @TODO what's locked? ]); }
        $adminPerm = Permission::create(['name' => 'admin', 'label' => 'Super Admin', 'description' => 'Application Super Admin' ]); // 'locked' => true // @TODO what's locked? ]); }
        // Permission::create(['name' => '', 'label' => '', 'description' => '' ]); // 'locked' => true // @TODO what's locked? ]); }

        // Role::create(['name' => 'null', 'label' => 'None Required', 'description' => 'No role required', 'active' => true]);
        $userRole = Role::create(['name' => 'user', 'label' => 'User', 'description' => 'Regular User', 'active' => true]);
        $adminRole = Role::create(['name' => 'admin', 'label' => 'Admin', 'description' => 'Administrators', 'active' => true]);
        $systemRole = Role::create(['name' => 'system', 'label' => 'System', 'description' => 'System users', 'active' => true]);

        $userRole->grantPermission($loggedInPerm);
        $adminRole->grantPermission($adminPerm);
        $systemRole->grantPermission($adminPerm);

        User::create(['first_name' => 'System', 'last_name' => 'User', 'email' => 'system@p3in.com', 'phone' => '', 'password' => bcrypt('d3velopment')])->assignRole($systemRole);
    }
}
