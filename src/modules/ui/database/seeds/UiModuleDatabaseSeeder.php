<?php

namespace P3in\Seeders;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use P3in\Seeders\UiFieldsTableSeeder;

class UiModuleDatabaseSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $this->call(UiFieldsTableSeeder::class);

        Model::reguard();
    }
}
