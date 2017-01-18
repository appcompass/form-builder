<?php

namespace P3in\Seeders;

use DB;
use Illuminate\Database\Seeder;

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

        DB::statement("TRUNCATE TABLE fields CASCADE");
        DB::statement("TRUNCATE TABLE forms CASCADE");
    }
}
