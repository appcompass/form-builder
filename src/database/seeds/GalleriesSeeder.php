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
            $builder->string('Gallery Name', 'name')->list()->validation(['required'])->sortable()->searchable();
            $builder->select('Disk Instance', 'galleryable.storage.name')->dynamic(\P3in\Models\StorageConfig::class, function (FieldSource $source) {
                $source->select(['name AS index', 'name AS label']);
            });
            $builder->string('Owner', 'user.email')->list()->edit(false);
        })->linkToResources(['galleries.index', 'galleries.show', 'galleries.store']);

        FormBuilder::new('photos_upload', function (FormBuilder $builder) {
            $builder->select('Disk Instance', 'storage.name')->dynamic(\P3in\Models\StorageConfig::class, function (FieldSource $source) {
                // @TODO: add selected target.  i.e in this case the default selected value is the parent or another relationship, like gallery's storage.
                // Really it could be anything though, granted we would need to specify the value type if we left it open ended.
                // $source->defaultValue('gallery.galleryable.storage.name')
                $source->select(['name AS index', 'name AS label']);
            });
            $builder->photo('Photos', 'photo')->list(false)->validation(['image', 'required'])->setConfig('disk_field_name', 'storage.name');
        })->linkToResources(['galleries.photos.create']);

        $form = FormBuilder::new('photos', function (FormBuilder $builder) {
            $builder->string('Path', 'path')->list();
            $builder->photo('Photo', 'photo')->list(false)->validation(['image', 'required']);
            $builder->string('Photo Name', 'title')->list()->validation(['required'])->sortable()->searchable();
        })->linkToResources(['galleries.photos.index', 'galleries.photos.show']);
            // ->getForm();

        // WebsiteBuilder::edit($cp->id)->linkForm($form);
    }
}
