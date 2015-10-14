<?php

namespace P3in\Seeders;

use Illuminate\Database\Seeder;
use P3in\Models\User;
use P3in\Models\Permission;
use P3in\Models\Group;
use DB;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        DB::table('users')->delete();

        // some error going on with factory not finding this model.  so commenting out for now.
        // $user = factory('P3in\Models\User', 10)
        //  ->create()
        //  ->each(function($user) {
        //      $user
        //          ->permissions()
        //          ->attach(Permission::first());
        //   });

    //    $user
    //      ->permissions()
    //      ->attach([Permission::firstOrFail()->id, factory('P3in\Models\Permission')->create()->id]);

    //    $user
    //      ->groups()
    //      ->attach(Group::first());
    //  });

        /**
        *   create some actual users
        *
        *
        */
        User::create([
            'first_name' => 'Federico',
            'last_name' => 'Francescato',
            'email' => 'federico@p3in.com',
            'password' => bcrypt('d3velopment'),
            'phone' => '1-857-600-2702',
            'active' => true
        ])
            ->permissions()
            ->attach(Permission::firstOrFail()->id);

        User::create([
            'first_name' => 'Jubair',
            'last_name' => 'Saidi',
            'password' => bcrypt('d3velopment'),
            'email' => 'jubair.saidi@p3in.com',
            'phone' => '1-857-600-2702',
            'active' => true
        ])
            ->permissions()
            ->attach(Permission::firstOrFail()->id);

  }
}
