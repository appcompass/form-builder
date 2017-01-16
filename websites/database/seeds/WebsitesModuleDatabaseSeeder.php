<?php

namespace P3in\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use P3in\Builders\MenuBuilder;
use P3in\Builders\ResourceBuilder;
use P3in\Builders\WebsiteBuilder;
use P3in\Models\Page;
use P3in\Models\Website;

class WebsitesModuleDatabaseSeeder extends Seeder
{
    public function run()
    {
        DB::statement('TRUNCATE websites RESTART IDENTITY CASCADE');
        DB::statement('TRUNCATE pages RESTART IDENTITY CASCADE');

        WebsiteBuilder::new(env('ADMIN_WEBSITE_NAME'), env('ADMIN_WEBSITE_URL'), function ($websiteBuilder) {
            $users_management = [
                'url' => '',
                'title' => 'Users Management',
                'alt' => 'Users Management',
                'new_tab' => false,
                'clickable' => false
            ];

            $web_properties = [
                'url' => '',
                'title' => 'Web Properties',
                'alt' => 'Web Properties',
                'new_tab' => false,
                'clickable' => false
            ];

            $publications = [
                'url' => '',
                'title' => 'Publications',
                'alt' => 'Publications',
                'new_tab' => false,
                'clickable' => false
            ];

            $users = $websiteBuilder->buildPage('Users', 'users');
            $users_permissions = $websiteBuilder->buildPage('User Permissions', 'permissions', $users);
            $groups = $websiteBuilder->buildPage('Groups', 'groups');
            $permissions = $websiteBuilder->buildPage('Permissions', 'permissions');
            $websites = $websiteBuilder->buildPage('Websites', 'websites');
            $galleries = $websiteBuilder->buildPage('Galleries', 'galleries');
            $pages = $websiteBuilder->buildPage('Pages', 'pages', $websites);
            $navigation = $websiteBuilder->buildPage('Navigation', 'menus', $websites);

            $main_nav = $websiteBuilder->buildMenu('main_nav');

            $user_management_item = $main_nav->addItem($users_management, 1);
            $user_item = $user_management_item->addItem($users, 1)->setIcon('user');
            $user_item->addItem($users_permissions, 1)->setIcon('user');
            $user_management_item->addItem($groups, 2)->setIcon('users');
            $user_management_item->addItem($permissions, 3)->setIcon('lock');

            $web_properties_item = $main_nav->addItem($web_properties, 2)->setIcon('globe');
            $websites_item = $web_properties_item->addItem($websites, 1);
            $websites_item->addItem($pages, 1)->setIcon('page');
            $websites_item->addItem($navigation, 2)->setIcon('bars');

            $publications_item = $main_nav->addItem($publications, 3);
            $publications_item->addItem($galleries, 1)->setIcon('camera');

        });

            // MenuBuilder::new('main_nav', $CMS, function (MenuBuilder $builder) use ($users, $groups, $permissions, $websites, $galleries, $pages, $navigation, $users_permissions) {
            //     $users_management_category = $builder->add(['url' => '', 'title' => 'Users Management', 'alt' => 'Users Management', 'new_tab' => false, 'clickable' => false]);
            //     $users = $builder->add($users)->setParent($users_management_category)->icon('user');
            //     $builder->add($users_permissions)->setParent($users)->icon('user');
            //     $builder->add($groups)->setParent($users_management_category)->icon('users');
            //     $builder->add($permissions)->setParent($users_management_category)->icon('lock');

            //     $properties_category = $builder->add(['url' => '', 'title' => 'Web Properties', 'alt' => 'Web Properties', 'new_tab' => false, 'clickable' => false]);
            //     $websites = $builder->add($websites)->setParent($properties_category)->icon('globe');
            //     $builder->add($pages)->setParent($websites)->icon('page');
            //     $builder->add($navigation)->setParent($websites)->icon('bars');

            //     $publications_category = $builder->add(['url' => '', 'title' => 'Publications', 'alt' => 'Publications', 'new_tab' => false, 'clickable' => false]);
            //     $builder->add($galleries)->setParent($publications_category)->icon('camera');
            // });

        DB::statement("DELETE FROM forms WHERE name = 'websites'");

        ResourceBuilder::new('websites', 'websites/{id}', function (ResourceBuilder $builder) {
            $builder->string('Website Name', 'name')->list()->required()->sortable()->searchable();
            $builder->string('Url', 'url')->list()->required()->sortable()->searchable();
            // $builder->json('Auth Key', 'config.key')->list()->required()->sortable()->searchable();
        })->setAlias(['websites.index', 'websites.show', 'websites.create']);

        DB::statement("DELETE FROM forms WHERE name = 'pages'");

        ResourceBuilder::new('pages', 'pages/{id}', function (ResourceBuilder $builder) {
            $builder->string('Page Title', 'title')->list()->required()->sortable()->searchable();
            // $builder->string('Page Title', 'title')->list(false)->required()->sortable()->searchable();
            $builder->text('Description', 'description')->list(false)->required()->sortable()->searchable();
            $builder->string('Slug', 'slug')->list(false)->required()->sortable()->searchable();
            $builder->string('Layout', 'layout')->list(false)->required()->sortable()->searchable();
        })->setAlias(['pages.show', 'websites.pages.index', 'websites.pages.create', 'websites.pages.show']);

        DB::statement("DELETE FROM forms WHERE name = 'menus'");

        ResourceBuilder::new('menus', 'menus/{id}', function (ResourceBuilder $builder) {
            $builder->string('Name', 'name')->list()->required()->sortable()->searchable();
        })->setAlias(['websites.menus.index', 'websites.menus.create']);

        DB::statement("DELETE FROM forms WHERE name = 'menus-editor'");

        ResourceBuilder::new('menus-editor', 'menus/{id}', function (ResourceBuilder $builder) {
            $builder->menuEditor()->list(false);
        })->setAlias(['websites.menus.show']);
    }
}
