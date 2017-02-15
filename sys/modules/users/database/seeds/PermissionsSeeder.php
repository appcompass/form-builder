<?php

namespace P3in\Seeders;

use Illuminate\Database\Seeder;
use P3in\Builders\FormBuilder;
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

        FormBuilder::new('permissions', function (FormBuilder $builder) {
            $builder->string('Name', 'label')
                ->list()
                ->validation(['required'])
                ->sortable()
                ->searchable();
            $builder->text('Description', 'description')
                ->list(false)
                ->validation(['required'])
                ->sortable()
                ->searchable();
            $builder->string('Created', 'created_at')
                ->list()
                ->edit(false)
                ->validation(['required'])
                ->sortable()
                ->searchable();
        })->linkToResources(['permissions.index', 'permissions.show', 'permissions.create']);

        DB::statement("DELETE FROM forms WHERE name = 'user-permissions'");

        FormBuilder::new('user-permissions', function (FormBuilder $builder) {
            $builder->string('Name', 'label')
                ->list()
                ->validation(['required'])
                ->sortable()
                ->searchable();
        })->linkToResources(['users.permissions.index']);

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
