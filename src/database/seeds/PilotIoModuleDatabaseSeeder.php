<?php

namespace P3in\Seeders;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;

class PilotIoModuleDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $this->call(DisksFormsSeeder::class);
        $this->call(UsersSeeder::class);
        $this->call(GalleriesSeeder::class);
        $this->call(ResourcesSeeder::class);
        $this->call(WebsitesSeeder::class);

        Model::reguard();
    }
}
