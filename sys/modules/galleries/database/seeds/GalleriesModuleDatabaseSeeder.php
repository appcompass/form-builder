<?php

namespace P3in\Seeders;

use Illuminate\Database\Seeder;
use P3in\Builders\ResourceBuilder;
use P3in\Models\User;

class GalleriesModuleDatabaseSeeder extends Seeder
{
    public function run()
    {
        \DB::statement('TRUNCATE galleries CASCADE');

        \DB::statement("DELETE FROM forms WHERE name = 'galleries'");
        ResourceBuilder::new('galleries', 'galleries/{id}', function (ResourceBuilder $builder) {
            $builder->string('Gallery Name', 'name')->list()->required()->sortable()->searchable();

            $builder->string('Owner', 'user.email')->list()->edit(false);
        })->setAlias(['galleries.index', 'galleries.show', 'galleries.create']);
    }
}
