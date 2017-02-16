<?php

namespace P3in\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use P3in\Models\Storage;
use P3in\Models\StorageType;


class Plus3websiteStoragesSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $local = StorageType::getType('local');

        $siteStorage = Storage::firstOrNew([
            'name' => 'plus3website',
        ]);

        $siteStorage->config = [
            'driver' => 'local',
            'root' => base_path('../websites/plus3website'),
        ];

        $siteStorage->type()->associate($local);
        $siteStorage->save();


        $siteImageStorage = Storage::firstOrNew([
            'name' => 'plus3website_images',
        ]);

        $siteImageStorage->config = [
            'driver' => 'local',
            'root' => base_path('../websites/plus3website/static/assets/images/content'),
        ];

        $siteImageStorage->type()->associate($local);
        $siteImageStorage->save();

    }
}
