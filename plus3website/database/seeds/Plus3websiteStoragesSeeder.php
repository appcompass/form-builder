<?php

namespace P3in\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use P3in\Models\StorageType;
use P3in\Models\StorageConfig;

class Plus3websiteStoragesSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        StorageConfig::whereIn('name', ['plus3website', 'plus3website_images'])->delete();

        $local = StorageType::getType('local');

        $local->createDrive('plus3website', [
            'driver' => 'local',
            'root' => base_path('../websites/plus3website'),
        ]);

        $local->createDrive('plus3website_images', [
            'driver' => 'local',
            'root' => base_path('../websites/plus3website/static/assets/images/content'),
        ]);

    }
}
