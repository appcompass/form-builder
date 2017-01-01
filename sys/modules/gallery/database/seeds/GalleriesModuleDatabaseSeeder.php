<?php

namespace P3in\Seeders;

use Illuminate\Database\Seeder;
use P3in\Models\ResourceBuilder;

class GalleriesModuleDatabaseSeeder extends Seeder
{
    public function run()
    {
        \DB::statement('TRUNCATE galleries CASCADE');

        \DB::statement("DELETE FROM forms WHERE name = 'galleries'");
        ResourceBuilder::new('galleries', 'galleries/{id}', function(ResourceBuilder $builder) {

            $builder->string('Gallery Name', 'name')->list()->required()->sortable()->searchable();

            $builder->string('Owner', 'user.email')->list()->edit(false);

        })->setAlias(['galleries.index', 'galleries.show', 'galleries.create']);

        \P3in\Models\Gallery::create(['name' => 'First Gallery', 'user_id' => \P3in\Models\User::first()->id]);
    }
}