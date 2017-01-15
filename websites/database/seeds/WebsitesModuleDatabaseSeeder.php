<?php

namespace P3in\Seeders;

use Illuminate\Database\Seeder;
use P3in\Builders\ResourceBuilder;
use P3in\Models\Website;
use P3in\Models\Page;
use P3in\Builders\MenuBuilder;

class WebsitesModuleDatabaseSeeder extends Seeder
{
    public function run()
    {
        \DB::statement('TRUNCATE websites CASCADE');
        \DB::statement('TRUNCATE pages CASCADE');

        \DB::statement("DELETE FROM forms WHERE name = 'websites'");

        ResourceBuilder::new('websites', 'websites/{id}', function (ResourceBuilder $builder) {
            $builder->string('Website Name', 'name')->list()->required()->sortable()->searchable();
            $builder->string('Url', 'url')->list()->required()->sortable()->searchable();
            // $builder->json('Auth Key', 'config.key')->list()->required()->sortable()->searchable();
        })->setAlias(['websites.index', 'websites.show', 'websites.create']);

        $CMS = Website::create(['name' => env('ADMIN_WEBSITE_NAME'), 'url' => env('ADMIN_WEBSITE_URL')]);

        \DB::statement("DELETE FROM forms WHERE name = 'pages'");

        ResourceBuilder::new('pages', 'pages/{id}', function (ResourceBuilder $builder) {
            $builder->string('Page Title', 'title')->list()->required()->sortable()->searchable();
            // $builder->string('Page Title', 'title')->list(false)->required()->sortable()->searchable();
            $builder->text('Description', 'description')->list(false)->required()->sortable()->searchable();
            $builder->string('Slug', 'slug')->list(false)->required()->sortable()->searchable();
            $builder->string('Layout', 'layout')->list(false)->required()->sortable()->searchable();
        })->setAlias(['pages.show', 'websites.pages.index', 'websites.pages.create', 'websites.pages.show']);

        \DB::statement("DELETE FROM forms WHERE name = 'menus'");

        ResourceBuilder::new('menus', 'menus/{id}', function (ResourceBuilder $builder) {
            $builder->string('Name', 'name')->list()->required()->sortable()->searchable();
        })->setAlias(['websites.menus.index', 'websites.menus.create']);

        \DB::statement("DELETE FROM forms WHERE name = 'menus-editor'");

        ResourceBuilder::new('menus-editor', 'menus/{id}', function (ResourceBuilder $builder) {
            $builder->menuEditor()->list(false);
        })->setAlias(['websites.menus.show']);

        \DB::statement('TRUNCATE pages CASCADE');
        \DB::statement('TRUNCATE nav_items CASCADE');
        \DB::statement('TRUNCATE menus CASCADE');

        // @NOTE parent_id MUST be defined before slug, otherwise it won't be available when we build the url
        $users = $CMS->pages()->create(['title' => 'Users', 'slug' => 'users']);
        $users_permissions = $CMS->pages()->create(['title' => 'User Permissions', 'parent_id' => $users->id, 'slug' => 'permissions']);

        $groups = $CMS->pages()->create(['title' => 'Groups', 'slug' => 'groups']);
        $permissions = $CMS->pages()->create(['title' => 'Permissions', 'slug' => 'permissions']);
        $websites = $CMS->pages()->create(['title' => 'Websites', 'slug' => 'websites']);
        $galleries = $CMS->pages()->create(['title' => 'Galleries', 'slug' => 'galleries']);
        $pages = $CMS->pages()->create(['title' => 'Pages', 'parent_id' => $websites->id, 'slug' => 'pages']);
        $navigation = $CMS->pages()->create(['title' => 'Navigation', 'parent_id' => $websites->id, 'slug' => 'menus']);

        MenuBuilder::new('main_nav', $CMS, function (MenuBuilder $builder) use ($users, $groups, $permissions, $websites, $galleries, $pages, $navigation, $users_permissions) {
            $users_management_category = $builder->add(['url' => '', 'title' => 'Users Management', 'alt' => 'Users Management', 'new_tab' => false, 'clickable' => false]);
            $users = $builder->add($users)->setParent($users_management_category)->icon('user');
            $builder->add($users_permissions)->setParent($users)->icon('user');
            $builder->add($groups)->setParent($users_management_category)->icon('users');
            $builder->add($permissions)->setParent($users_management_category)->icon('lock');

            $properties_category = $builder->add(['url' => '', 'title' => 'Web Properties', 'alt' => 'Web Properties', 'new_tab' => false, 'clickable' => false]);
            $websites = $builder->add($websites)->setParent($properties_category)->icon('globe');
            $builder->add($pages)->setParent($websites)->icon('page');
            $builder->add($navigation)->setParent($websites)->icon('bars');

            $publications_category = $builder->add(['url' => '', 'title' => 'Publications', 'alt' => 'Publications', 'new_tab' => false, 'clickable' => false]);
            $builder->add($galleries)->setParent($publications_category)->icon('camera');
        });
    }
}
