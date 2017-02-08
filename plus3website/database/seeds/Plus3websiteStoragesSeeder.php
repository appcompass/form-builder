<?php

namespace P3in\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;
use P3in\Models\Storage;


class Plus3websiteStoragesSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (!Storage::where('name', 'plus3website')->count()) {
            Storage::create([
                'name' => 'plus3website',
                'config' => [
                    'driver' => 'local',
                    'root' => base_path('../websites/plus3website'),
                ],
            ]);
        }
    }
}
