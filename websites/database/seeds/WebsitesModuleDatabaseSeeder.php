<?php

namespace P3in\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use P3in\Builders\FormBuilder;
use P3in\Builders\WebsiteBuilder;

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
                'clickable' => false,
            ];

            $web_properties = [
                'url' => '',
                'title' => 'Web Properties',
                'alt' => 'Web Properties',
                'new_tab' => false,
                'clickable' => false,
            ];

            $blog = [
                'url' => '',
                'title' => 'Blog',
                'alt' => 'Blog',
                'new_tab' => false,
                'clickable' => false,
            ];

            $media_management = [
                'url' => '',
                'title' => 'Media Management',
                'alt' => 'Media Management',
                'new_tab' => false,
                'clickable' => false,
            ];

            $users = $websiteBuilder->addPage('Users', 'users');
            $users_permissions = $users->addPage('User Permissions', 'permissions');
            $groups = $websiteBuilder->addPage('Groups', 'groups');
            $permissions = $websiteBuilder->addPage('Permissions', 'permissions');
            $websites = $websiteBuilder->addPage('Websites', 'websites');
            $navigation = $websites->addPage('Navigation', 'menus');
            $pages = $websites->addPage('Pages', 'pages');
            $components = $pages->addPage('Components', 'components');
            $contents = $pages->addPage('Contents', 'contents');
            $blogEntries = $websites->addPage('Entries', 'blog-entries');
            $blogCategories = $websites->addPage('Categories', 'blog-categories');
            $blogTags = $websites->addPage('Tags', 'blog-tags');
            $galleries = $websiteBuilder->addPage('Galleries', 'galleries');

            $main_nav = $websiteBuilder->addMenu('main_nav');

            $user_management_item = $main_nav->addItem($users_management, 1);
            $user_item = $user_management_item->addItem($users, 1)->setIcon('user');
            $user_item->addItem($users_permissions, 1)->setIcon('user');
            $user_management_item->addItem($groups, 2)->setIcon('users');
            $user_management_item->addItem($permissions, 3)->setIcon('lock');

            $web_properties_item = $main_nav->addItem($web_properties, 2)->setIcon('globe');
            $websites_item = $web_properties_item->addItem($websites, 1);
            $websites_item->addItem($navigation, 1)->setIcon('bars');
            $pages_menuitem = $websites_item->addItem($pages, 2)->setIcon('page');
            $pages_menuitem->addItem($components, 1)->setIcon('bars');
            $pages_menuitem->addItem($contents, 2)->setIcon('bars');
            $blog_menuitem = $websites_item->addItem($blog, 3)->setIcon('page');
            $blog_menuitem->addItem($blogEntries, 1)->setIcon('page');
            $blog_menuitem->addItem($blogCategories, 2)->setIcon('page');
            $blog_menuitem->addItem($blogTags, 3)->setIcon('page');

            $media_management_item = $main_nav->addItem($media_management, 3);
            $media_management_item->addItem($galleries, 1)->setIcon('camera');
        });

        DB::statement("DELETE FROM forms WHERE name = 'websites'");

        FormBuilder::new('websites', function (FormBuilder $builder) {
            $builder->string('Website Name', 'name')->list()->required()->sortable()->searchable();
            $builder->string('Url', 'url')->list()->required()->sortable()->searchable();
            // $builder->json('Auth Key', 'config.key')->list()->required()->sortable()->searchable();
        })->linkToResources(['websites.index', 'websites.show', 'websites.create']);

        DB::statement("DELETE FROM forms WHERE name = 'pages'");

        FormBuilder::new('pages', function (FormBuilder $builder) {
            $builder->string('Page Title', 'title')->list()->required()->sortable()->searchable();
            // $builder->string('Page Title', 'title')->list(false)->required()->sortable()->searchable();
            $builder->text('Description', 'description')->list(false)->required()->sortable()->searchable();
            $builder->string('Slug', 'slug')->list(false)->required()->sortable()->searchable();
            // $builder->string('Layout', 'layout')->list(false)->required()->sortable()->searchable(); // page contains a list of stacked layouts (ordered)
        })->linkToResources(['pages.show', 'websites.pages.index', 'websites.pages.create', 'websites.pages.show']);

        DB::statement("DELETE FROM forms WHERE name = 'menus'");

        FormBuilder::new('menus', function (FormBuilder $builder) {
            $builder->string('Name', 'name')->list()->required()->sortable()->searchable();
        })->linkToResources(['websites.menus.index', 'websites.menus.create']);

        DB::statement("DELETE FROM forms WHERE name = 'menus-editor'");

        FormBuilder::new('menus-editor', function (FormBuilder $builder) {
            $builder->menuEditor('Menu', 'menu')->list(false);
        })->linkToResources(['websites.menus.show']);

        DB::statement("DELETE FROM forms WHERE name = 'page-sections'");

        FormBuilder::new('page-sections', function (FormBuilder $builder) {
            $builder->string('Section Name', 'name')->list()->edit(false)->sortable()->searchable();
            $builder->string('Template', 'template')->list()->edit(false)->sortable()->searchable();
        })->linkToResources(['pages.sections.index']);
    }
}
