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
        $userRole = Role::create([
            'name'        => 'user',
            'label'       => 'User',
            'description' => 'Regular User',
            'active'      => true,
        ]);
        $adminRole = Role::create([
            'name'        => 'admin',
            'label'       => 'Admin',
            'description' => 'Administrators',
            'active'      => true,
        ]);
        $systemRole = Role::create([
            'name'        => 'system',
            'label'       => 'System',
            'description' => 'System users',
            'active'      => true,
        ]);

        $loggedInPerm = Permission::create([
            'name'        => 'logged-user',
            'label'       => 'User',
            'description' => 'The user can log into the application frontend (websites)',
            'system'      => true,
        ]);
        $guestPerm = Permission::create([
            'name'        => 'guest',
            'label'       => 'Guest',
            'description' => 'Guest Permission',
            'system'      => true,
        ]);
        $mediaPerm = Permission::create([
            'name'        => 'media',
            'label'       => 'Media Editor',
            'description' => 'Media Editor Permission',
            'system'      => true,
        ]);
        $contentPerm = Permission::create([
            'name'        => 'content',
            'label'       => 'Content Creator/Editor',
            'description' => 'Content Creator/Editor',
            'system'      => true,
        ]);

        $userRole->grantPermission($loggedInPerm);
//        $adminRole->grantPermission($adminPerm);
        // $systemRole->grantPermission($adminPerm);

        $system = User::create([
            'first_name' => 'System',
            'last_name'  => 'User',
            'email'      => config('app.pilot_io_system_user'),
            'password'   => '',
            'phone'      => '',
        ])->assignRole($systemRole);
    }
}
