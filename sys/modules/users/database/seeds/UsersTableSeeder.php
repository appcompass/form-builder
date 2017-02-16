<?php

namespace P3in\Seeders;

use Illuminate\Database\Seeder;
use P3in\Models\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        User::create([
            'first_name' => 'System',
            'last_name' => 'User',
            'email' => '',
            'phone' => '',
            'password' => '',
            'system' => true,
        ]);
    }
}
