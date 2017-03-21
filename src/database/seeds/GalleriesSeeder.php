<?php

namespace P3in\Seeders;

use Illuminate\Database\Seeder;
use P3in\Builders\FormBuilder;
use P3in\Builders\MenuBuilder;
use P3in\Models\Website;
use P3in\Builders\WebsiteBuilder;
use P3in\Models\FieldSource;

use P3in\Models\User;

class GalleriesSeeder extends Seeder
{
    public function run()
    {
        // \DB::statement('TRUNCATE galleries CASCADE');
        // \DB::statement("DELETE FROM forms WHERE name = 'galleries'");
        // \DB::statement("DELETE FROM forms WHERE name = 'photos'");

        FormBuilder::new('galleries', function (FormBuilder $builder) {
            // $builder->editor('Gallery');
            // $builder->setViewTypes(['grid','list']);
            $builder->string('Gallery Name', 'name')->list()->validation(['required'])->sortable()->searchable();
            $builder->select('Disk Instance', 'galleryable.storage.name')->dynamic(\P3in\Models\StorageConfig::class, function(FieldSource $source) {
                $source->select(['name AS index', 'name AS label']);
            });
            // $builder->photo('Photo', 'photo')->list(false);
            $builder->string('Owner', 'user.email')->list()->edit(false);
        })->linkToResources(['galleries.index', 'galleries.show', 'galleries.store']);

        $form = FormBuilder::new('photos', function (FormBuilder $builder) {
            // $builder->setViewTypes(['grid','list']);
            // $builder->setCreateType('dropzone');
            // $builder->setUpdateType('modal');
            $builder->string('Path', 'path')->list();
            $builder->photo('Photo', 'photo')->list(false)->validation(['image', 'required']);
            $builder->string('Photo Name', 'title')->list()->validation(['required'])->sortable()->searchable();
        })->linkToResources(['galleries.photos.index', 'galleries.photos.create', 'galleries.photos.show']);
            // ->getForm();

        // WebsiteBuilder::edit($cp->id)->linkForm($form);
    }
}
