<?php

namespace P3in\Seeders;

use Illuminate\Database\Seeder;
use P3in\Builders\FormBuilder;
use P3in\Builders\MenuBuilder;
use P3in\Models\Website;
use P3in\Builders\WebsiteBuilder;

use P3in\Models\User;

class GalleriesModuleDatabaseSeeder extends Seeder
{
    public function run()
    {
        \DB::statement('TRUNCATE galleries CASCADE');

        \DB::statement("DELETE FROM forms WHERE name = 'galleries'");
        FormBuilder::new('galleries', function (FormBuilder $builder) {
            $builder->setListLayout('Card'); // @TODO options are currently hard coded in the UI, this defines the default view
            $builder->string('Gallery Name', 'name')->list()->validation(['required'])->sortable()->searchable();
            $builder->file('Photo', 'photo')->list(false);
            $builder->string('Owner', 'user.email')->list()->edit(false);
        })->linkToResources(['galleries.index', 'galleries.show', 'galleries.create']);

        \DB::statement("DELETE FROM forms WHERE name = 'photos'");
        $form = FormBuilder::new('photos', function (FormBuilder $builder) {
            $builder->setListLayout('Card');
            $builder->string('Path', 'path')->list();
            $builder->file('Photo', 'photo')->list(false);
            $builder->string('Photo Name', 'title')->list()->validation(['required'])->sortable()->searchable();
        })->linkToResources(['galleries.photos.index', 'galleries.photos.create', 'galleries.photos.show'])
            ->getForm();

        // WebsiteBuilder::edit($cp->id)->linkForm($form);
    }
}
