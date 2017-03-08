<?php

namespace P3in\Seeders;

use Illuminate\Database\Seeder;
use P3in\Builders\FormBuilder;
use P3in\Models\User;
use DB;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // DB::statement('TRUNCATE users CASCADE');
        // DB::statement("DELETE FROM forms WHERE name = 'users'");

        FormBuilder::new('users', function (FormBuilder $builder) {
            $builder->string('First Name', 'first_name')->list()->validation(['required'])->sortable()->searchable();
            $builder->string('Last Name', 'last_name')->list()->validation(['required'])->sortable()->searchable();
            $builder->string('Email', 'email')->list()->validation(['required', 'email'])->sortable()->searchable();
            $builder->string('Phone Number', 'phone')->list()->validation(['required'])->sortable()->searchable();
            $builder->boolean('Active', 'active')->list(false);
            $builder->string('Date Added', 'created_at')->list()->edit(false)->sortable();
            $builder->secret('Password', 'password')->validation(['required']);
        })->linkToResources(['users.index', 'users.show', 'users.create', 'users.update', 'users.store']);

        User::create([
            'first_name' => 'System',
            'last_name' => 'User',
            'email' => '',
            'phone' => '',
            'password' => '',
            'system' => true,
        ])->addToGroup('system');
    }
}
