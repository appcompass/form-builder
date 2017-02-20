<?php

namespace P3in\Seeders;

use DB;
use Illuminate\Database\Seeder;
use P3in\Seeders\CpStoragesSeeder;
use P3in\Seeders\FieldtypesTableSeeder;

class CpModuleDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(CpStoragesSeeder::class);
    }
}
