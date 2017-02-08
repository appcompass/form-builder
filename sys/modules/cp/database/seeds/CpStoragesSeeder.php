<?php

namespace P3in\Seeders;

use DB;
use Illuminate\Database\Seeder;
use P3in\Models\Storage;

class CpStoragesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // @TODO: we should prob have the base_path specified via config first, and throw an error if it's not set?
        Storage::create([
            'name' => 'cp_root',
            'config' => [
                'driver' => 'local',
                'root' => base_path('../cp'),
            ],
        ]);
        // @TODO: Don't think we really need two records here tbh.
        Storage::create([
            'name' => 'cp_components',
            'config' => [
                'driver' => 'local',
                'root' => base_path('../cp/src/components'),
            ],
        ]);
    }
}
