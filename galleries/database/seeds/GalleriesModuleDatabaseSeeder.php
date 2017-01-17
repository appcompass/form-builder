<?php

namespace P3in\Seeders;

use Illuminate\Database\Seeder;
use P3in\Builders\FormBuilder;
use P3in\Models\User;

class GalleriesModuleDatabaseSeeder extends Seeder
{
    public function run()
    {
        \DB::statement('TRUNCATE galleries CASCADE');

        \DB::statement("DELETE FROM forms WHERE name = 'galleries'");
        FormBuilder::new('galleries', function (FormBuilder $builder) {
            $builder->string('Gallery Name', 'name')->list()->required()->sortable()->searchable();

            $builder->string('Owner', 'user.email')->list()->edit(false);
        })->linkToResources(['galleries.index', 'galleries.show', 'galleries.create']);
    }
}
