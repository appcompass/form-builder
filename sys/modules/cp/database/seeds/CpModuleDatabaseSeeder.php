<?php

namespace P3in\Seeders;

use Illuminate\Database\Seeder;
use P3in\Builders\ResourceBuilder;
use DB;

class CpModuleDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(FieldtypesTableSeeder::class);

        DB::statement("TRUNCATE TABLE fields CASCADE");
        DB::statement("TRUNCATE TABLE forms CASCADE");

        // ResourceBuilder::new('users', 'users/{id}', function(ResourceBuilder $builder) {

        //     // $builder->actions('edit')->permissions('users.own.edit');

        //     $builder->string('First Name', 'first_name')->list()->required()->sortable()->searchable();
        //     $builder->string('Last Name', 'last_name')->list()->required()->sortable()->searchable();

        //     $builder->string('Email', 'email')->list()->required()->validation('email')->sortable()->searchable();

        //     $builder->string('Date Added', 'created_at')->list()->edit(false)->sortable();

        //     // $builder->text('Bio', 'bio');

        //     // $builder->string('Alerts', 'settings.alerts');

        //     // $builder->datetime('End of absence', 'settings.absent.end');

        //     $builder->secret()->required();

        // })->setAlias(['users.index', 'users.show', 'users.create']);


        // ResourceBuilder::new('websites', 'websites/{id}', function(ResourceBuilder $builder) {

        //     $builder->string('Name', 'label')->list()->sortable()->searchable();

        //     $builder->string('Domain Name', 'fqdn')->list()->sortable()->searchable();

        //     $builder->boolean('Active', 'settings.active')->list()->sortable();

        // })->setAlias(['websites.index', 'websites.show', 'websites.create']);


        // ResourceBuilder::new('posts', 'posts/{id}', function(ResourceBuilder $builder) {

        //     $builder->string('Title', 'title')->list()->sortable()->searchable();

        //     $builder->text('Body', 'body')->sortable();

        //     $builder->string('Posted At', 'created_at')->list()->edit(false)->sortable();

        //     $builder->string('Comments', 'comments_count')->list()->edit(false)->sortable();

        // })->setAlias(['posts.index', 'posts.create', 'posts.show']);


        // ResourceBuilder::new('comments', 'posts/{id}/comments/{id}', function(ResourceBuilder $builder) {

        //     $builder->text('Body', 'comment')->list()->sortable()->searchable();

        //     $builder->string('Posted At', 'created_at')->edit(false)->list()->sortable();

        // })->setAlias(['comments.index', 'comments.show', 'comments.edit']);

    }
}
