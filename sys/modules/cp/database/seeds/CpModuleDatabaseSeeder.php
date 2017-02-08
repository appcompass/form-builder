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
        $this->call(FieldtypesTableSeeder::class);
        $this->call(CpStoragesSeeder::class);

        // DB::statement("TRUNCATE TABLE fields CASCADE");
        // DB::statement("TRUNCATE TABLE forms CASCADE");
    }
}
