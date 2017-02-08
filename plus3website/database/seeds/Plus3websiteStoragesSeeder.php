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
        if (!Storage::where('name', 'plus3website')->count()) {

            $local = StorageType::getType('local');

            $storage = new Storage([
                'name' => 'plus3website',
                'config' => [
                    'driver' => 'local',
                    'root' => base_path('../websites/plus3website'),
                ],
            ]);

            $storage->type()->associate($local);
            $storage->save();
        }
    }
}
