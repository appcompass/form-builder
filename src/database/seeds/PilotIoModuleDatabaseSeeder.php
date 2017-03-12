<?php

namespace P3in\Seeders;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use P3in\Builders\FormBuilder;
use P3in\Models\StorageType;
use P3in\Models\Form;
use DB;

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
        $this->call(WebsitesSeeder::class);

        Model::reguard();
    }
}
