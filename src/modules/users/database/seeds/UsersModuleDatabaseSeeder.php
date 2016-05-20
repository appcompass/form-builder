<?php

namespace P3in\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

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

        $this->call(GroupsTableSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(UserUiFieldsSeeder::class);

        Model::reguard();
    }
}
