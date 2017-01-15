<?php

namespace P3in\Seeders;

use Illuminate\Database\Seeder;
use P3in\Builders\ResourceBuilder;
use P3in\Models\Permission;
use DB;

class PermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // \DB::statement('TRUNCATE permissions CASCADE');

        // Permission::create(['name' => 'media']);
        // Permission::create(['name' => 'deletions']);
        // Permission::create(['name' => 'something']);

        DB::statement("DELETE FROM forms WHERE name = 'permissions'");

        ResourceBuilder::new('permissions', 'permissions/{id}', function (ResourceBuilder $builder) {
            // @TODO list layout depends on the relation
            // $builder->setListLayout('MultiSelect');
            $builder->string('Name', 'label')->list()->required()->sortable()->searchable();
            $builder->text('Description', 'description')->list(false)->required()->sortable()->searchable();
            $builder->string('Created', 'created_at')->list()->edit(false)->required()->sortable()->searchable();
        })->setAlias([
            'permissions.index',
            'permissions.show',
            'permissions.create',
        ]);

        Permission::create([
            'type' => 'logged-user',
            'label' => 'User',
            'description' => 'The user can log into the application frontend (websites)',
            'locked' => true,
        ]);

        Permission::create([
            'type' => 'guest',
            'label' => 'Guest',
            'description' => 'Guest Permission',
            'locked' => true,
        ]);
    }
}
