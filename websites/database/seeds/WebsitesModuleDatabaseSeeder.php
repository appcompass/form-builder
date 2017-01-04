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

        Website::create(['name' => 'Test', 'url' => 'www.example.org']);

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

        $home = Page::create([
            'name' => 'homepage',
            'title' => 'Home of the Underdogs',
            'description' => 'Come here for some good oldies',
            'slug' => '']
        );

        $services = Page::create([
            'name' => 'services',
            'title' => 'Services',
            'parent_id' => $home->id,
            'slug' => 'services']
        );

        $about = Page::create([
            'name' => 'about',
            'title' => 'About',
            'parent_id' => $services->id,
            'slug' => 'about'
        ]);

        $websites = Page::create([
            'name' => 'websites',
            'title' => 'Websites Creation',
            'parent_id' => $about->id,
            'slug' => 'websites'
        ]);

        $hosting = Page::create([
            'name' => 'hosting',
            'title' => 'Hosting',
            'parent_id' => $about->id,
            'slug' => 'hosting'
        ]);

        Page::create([
            'name' => 'traffic',
            'title' => 'Traffic monitoring',
            'parent_id' => $about->id,
            'slug' => 'traffic'
        ]);

        MenuBuilder::new('main_nav', function(MenuBuilder $builder) use($home, $about, $services, $websites, $hosting) {

            $builder->add($home);
            $services_nav_item = $builder->add($services);
            $builder->add($about)->setParent($services_nav_item);
            $websites_nav_item = $builder->add($websites)->setParent($services_nav_item);
            $builder->add(['url' => 'http://www.google.com', 'label' => 'Google', 'alt' => 'Google', 'new_tab' => true]);
            $builder->add($hosting)->setParent($websites_nav_item);

        });


    }
}
