<?php

namespace P3in\Seeders;

use Illuminate\Database\Seeder;
use P3in\Builders\FormBuilder;
use P3in\Builders\WebsiteBuilder;
use P3in\Models\User;

class GalleriesModuleDatabaseSeeder extends Seeder
{
    public function run()
    {
        \DB::statement('TRUNCATE galleries CASCADE');

        \DB::statement("DELETE FROM forms WHERE name = 'galleries'");
        FormBuilder::new('galleries', function (FormBuilder $builder) {
            $builder->string('Gallery Name', 'name')
                ->list()
                ->validation(['required'])
                ->sortable()
                ->searchable();

            $builder->string('Owner', 'user.email')
                ->list()
                ->edit(false);
        })->linkToResources(['galleries.index', 'galleries.show', 'galleries.create']);


        $form = FormBuilder::new('photos', function (FormBuilder $builder) {
            // $builder->string('Photo Name', 'title')
            //     ->list()
            //     ->required()
            //     ->sortable()
            //     ->searchable();
            // $builder->file('Path', 'path')
            //     ->list()
            //     ->edit(false);
            // $builder->file('Photo', 'photo')
            //     ->list(false)
            //     ->required()
            //     ->sortable()
            //     ->searchable();
            // $builder->select('Uploader', 'user.email')
            //     ->list()
            //     ->required()
            //     ->sortable()
            //     ->searchable()
            //     ->dynamic('\P3in\Models\User');


            // $builder->select('Uploaded For', 'photoable')
            //     ->list()
            //     // first slelect the model and then select the ID.
            //     // in list layout we display just the polymorphic type or we
            //     ->polymorphic();

            // $builder->string('Website', 'website_id')->list(false)->required(); //->dynamic('\P3in\Models\Website');
        })
            ->linkToResources(['galleries.photos.index'])
            ->setListLayout('PhotoGrid')
            ->getForm();

        // WebsiteBuilder::edit($cp->id)->linkForm($form);
    }
}
