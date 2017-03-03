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
        DB::statement('TRUNCATE permissions CASCADE');
        DB::statement("DELETE FROM forms WHERE name = 'groups'");

        FormBuilder::new('groups', function (FormBuilder $builder) {
            $builder->string('Group Name', 'name')->list()->validation(['required'])->sortable()->searchable();
            $builder->string('Group Label', 'label')->list()->validation(['required'])->sortable()->searchable();
            $builder->text('Description', 'description')->list(false)->validation(['required'])->sortable()->searchable();
            $builder->string('Date Added', 'created_at')->list()->edit(false)->sortable();
        })->linkToResources(['groups.index', 'groups.show', 'groups.store', 'groups.update']);

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
