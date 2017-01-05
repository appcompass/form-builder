<?php

namespace P3in\Seeders;

use Illuminate\Database\Seeder;
use P3in\Models\ResourceBuilder;
use P3in\Models\Website;
use P3in\Models\Page;
use P3in\Models\MenuBuilder;

class WebsitesModuleDatabaseSeeder extends Seeder
{
    public function run()
    {
        \DB::statement('TRUNCATE websites CASCADE');
        \DB::statement('TRUNCATE pages CASCADE');

        \DB::statement("DELETE FROM forms WHERE name = 'websites'");

        ResourceBuilder::new('websites', 'websites/{id}', function(ResourceBuilder $builder) {
            $builder->string('Website Name', 'name')->list()->required()->sortable()->searchable();
            $builder->string('Url', 'url')->list()->required()->sortable()->searchable();
            // $builder->json('Auth Key', 'config.key')->list()->required()->sortable()->searchable();
        })->setAlias(['websites.index', 'websites.show', 'websites.create']);

        $CMS = Website::create(['name' => env('ADMIN_WEBSITE_NAME'), 'url' => env('ADMIN_WEBSITE_URL')]);

        \DB::statement("DELETE FROM forms WHERE name = 'pages'");

        ResourceBuilder::new('pages', 'pages/{id}', function(ResourceBuilder $builder) {
            $builder->string('Name', 'name')->list()->required()->sortable()->searchable();
            $builder->string('Page Title', 'title')->list(false)->required()->sortable()->searchable();
            $builder->text('Description', 'description')->list(false)->required()->sortable()->searchable();
            $builder->string('Slug', 'slug')->list(false)->required()->sortable()->searchable();
            $builder->string('Layout', 'layout')->list(false)->required()->sortable()->searchable();
        })->setAlias(['pages.show', 'websites.pages.index', 'websites.pages.create', 'websites.pages.show']);

        \DB::statement('TRUNCATE pages CASCADE');
        \DB::statement('TRUNCATE nav_items CASCADE');
        \DB::statement('TRUNCATE menus CASCADE');

        // @NOTE parent_id MUST be defined before slug, otherwise it won't be available when we build the url
        $users = Page::create(['name' => 'users', 'title' => 'Users', 'slug' => 'users', 'website_id' => $CMS->id]);
        $groups = Page::create(['name' => 'groups', 'title' => 'Groups', 'slug' => 'groups', 'website_id' => $CMS->id]);
        $permissions = Page::create(['name' => 'permissions', 'title' => 'Permissions', 'slug' => 'permissions', 'website_id' => $CMS->id]);
        $websites = Page::create(['name' => 'websites', 'title' => 'Websites', 'slug' => 'websites', 'website_id' => $CMS->id]);
        $galleries = Page::create(['name' => 'galleries', 'title' => 'Galleries', 'slug' => 'galleries', 'website_id' => $CMS->id]);

        MenuBuilder::new('main_nav', $CMS, function(MenuBuilder $builder) use($users, $groups, $permissions, $websites, $galleries) {

            $users_management_category = $builder->add(['url' => '', 'label' => 'Users Management', 'alt' => 'Users Management', 'new_tab' => false, 'clickable' => false]);
            $builder->add($users)->setParent($users_management_category)->icon('user');
            $builder->add($groups)->setParent($users_management_category)->icon('users');
            $builder->add($permissions)->setParent($users_management_category)->icon('lock');

            $properties_category = $builder->add(['url' => '', 'label' => 'Web Properties', 'alt' => 'Web Properties', 'new_tab' => false, 'clickable' => false]);
            $builder->add($websites)->setParent($properties_category)->icon('globe');

            $publications_category = $builder->add(['url' => '', 'label' => 'Publications', 'alt' => 'Publications', 'new_tab' => false, 'clickable' => false]);
            $builder->add($galleries)->setParent($publications_category)->icon('camera');
        });


    }
}
