<?php

namespace P3in\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use P3in\Builders\FormBuilder;
use P3in\Builders\WebsiteBuilder;
use P3in\Models\FieldSource;
use P3in\Models\Section;

class WebsitesModuleDatabaseSeeder extends Seeder
{
    public function run()
    {
        DB::statement('TRUNCATE websites RESTART IDENTITY CASCADE');
        DB::statement('TRUNCATE pages RESTART IDENTITY CASCADE');

        $cp = WebsiteBuilder::new(env('ADMIN_WEBSITE_NAME'), env('ADMIN_WEBSITE_SCHEME'), env('ADMIN_WEBSITE_HOST'), function ($websiteBuilder) {

            $websiteBuilder->setStorage('cp_root');

            // $users_management = ['url' => '', 'title' => 'Users Management', 'alt' => 'Users Management', 'new_tab' => false, 'clickable' => false, ];
            $web_properties = ['url' => '', 'title' => 'Web Properties', 'alt' => 'Web Properties', 'new_tab' => false, 'clickable' => false, ];
            $blog = ['url' => '', 'title' => 'Blog', 'alt' => 'Blog', 'new_tab' => false, 'clickable' => false, ];
            $media_management = ['url' => '', 'title' => 'Media Management', 'alt' => 'Media Management', 'new_tab' => false, 'clickable' => false, ];
            $settings = ['url' => '', 'title' => 'Settings', 'alt' => 'Settings', 'new_tab' => false, 'clickable' => false, ];

            $users = $websiteBuilder->addPage('Users', 'users');
            $users_permissions = $users->addChild('User Permissions', 'permissions');
            $groups = $websiteBuilder->addPage('Groups', 'groups');
            $permissions = $websiteBuilder->addPage('Permissions', 'permissions');
            $websites = $websiteBuilder->addPage('Websites', 'websites');
            $navigation = $websites->addChild('Navigation', 'menus');
            $pages = $websites->addChild('Pages', 'pages');
            $contents = $pages->addChild('Content', 'content');
            $blogEntries = $websites->addChild('Entries', 'blog-entries');
            $blogCategories = $websites->addChild('Categories', 'blog-categories');
            $blogTags = $websites->addChild('Tags', 'blog-tags');
            $galleries = $websiteBuilder->addPage('Galleries', 'galleries');

            $storage = $websiteBuilder->addPage('Storage', 'storage');
            $forms = $websiteBuilder->addPage('Forms', 'forms');

            $websiteBuilder->addMenu('main_nav')
                ->add(['url' => '', 'title' => 'Users Management', 'alt' => 'Users Management'], 1)->unclickable()->sub()
                    ->add($users, 1)->icon('users')->sub()
                        ->add($users_permissions, 1)
                        ->parent() // up 1
                    ->add($groups, 2)->icon('users')
                    ->add($permissions, 3)->icon('lock')->parent()
                ->add($web_properties, 2)->unclickable()->sub()
                    ->add($websites, 1)->sub() // down 1
                        ->add($navigation, 1)
                        ->add($pages, 2)->icon('page')->sub() // down 1
                            ->add($contents, 1)
                            ->parent()
                        ->add($blog, 3)->icon('page') ->sub()
                            ->add($blogEntries, 1)
                            ->add($blogCategories, 2)
                            ->add($blogTags, 3)
                            ->parent()
                        ->parent()
                    ->parent()
                ->add($media_management, 3)->unclickable()->sub()
                    ->add($galleries, 1)->icon('camera')
                    ->parent()
                ->add($settings, 4)->unclickable()->sub()
                    ->add($storage, 1)->icon('gear')
                    ->add($forms, 2)->icon('form');


        })->getWebsite();


        DB::statement("DELETE FROM forms WHERE name = 'websites'");

        $form = FormBuilder::new('websites', function (FormBuilder $builder) {
            $builder->string('Website Name', 'name')
                ->list()
                ->validation(['required'])
                ->sortable()
                ->searchable();

            $builder->select('Scheme', 'scheme')
                ->list()
                ->validation(['required'])
                ->sortable()
                ->searchable()
                ->dynamic([
                    'http' => 'http',
                    'https' => 'https',
                ]);

            $builder->string('Host', 'host')
                ->list()
                ->validation(['required'])
                ->sortable()
                ->searchable();

            $builder->fieldset('Configuration', 'config', function(FormBuilder $confBuilder){
                $confBuilder->select('Header', 'header')->dynamic(Section::class, function(FieldSource $source) {
                    $source->where('type', 'header');
                });

                $confBuilder->select('Footer', 'footer')->dynamic(Section::class, function(FieldSource $source) {
                    $source->where('type', 'footer');
                });

                $confBuilder->codeeditor('Layouts', 'layouts')->keyedRepeatable();

                $confBuilder->fieldset('Deployment', 'deployment', function (FormBuilder $depBuilder) {
                    $depBuilder->string('Publish From Path', 'publish_from')
                        ->validation(['required']);
                });
            });
        })->linkToResources(['websites.index', 'websites.show', 'websites.create'])
        ->getForm();

        WebsiteBuilder::edit($cp->id)->linkForm($form);

        DB::statement("DELETE FROM forms WHERE name = 'pages'");

        $form = FormBuilder::new('pages', function (FormBuilder $builder) {
            $builder->string('Page Title', 'title')->list()->validation(['required'])->sortable()->searchable();
            $builder->select('Parent', 'parent_id')->list(false)->dynamic(\P3in\Models\Page::class, function(FieldSource $source) {
                    $source->limit(4);
                    $source->where('website_id', \P3in\Models\Website::whereHost(env('ADMIN_WEBSITE_HOST'))->first()->id);
                });
            $builder->string('Website', 'website_id')->list(false)->validation(['required']);
        })->linkToResources(['pages.show', 'websites.pages.index', 'websites.pages.create', 'websites.pages.show'])
            ->getForm();

        WebsiteBuilder::edit($cp->id)->linkForm($form);

        DB::statement("DELETE FROM forms WHERE name = 'page-content-editor'");

        $form = FormBuilder::new('page-content-editor', function (FormBuilder $builder) {
            $builder->pageEditor('Page Editor', 'page-editor')->list(false);
        })->linkToResources(['pages.contents.index'])
        ->getForm();

        WebsiteBuilder::edit($cp->id)->linkForm($form);

        DB::statement("DELETE FROM forms WHERE name = 'menus'");

        FormBuilder::new('menus', function (FormBuilder $builder) {
            $builder->string('Name', 'name')->list()->validation(['required'])->sortable()->searchable();
        })->linkToResources(['websites.menus.index', 'websites.menus.create']);

        DB::statement("DELETE FROM forms WHERE name = 'menus-editor'");

        FormBuilder::new('menus-editor', function (FormBuilder $builder) {
            $builder->menuEditor('Menu', 'menu')->list(false);
        })->linkToResources(['websites.menus.show']);

        DB::statement("DELETE FROM forms WHERE name = 'create-link'");

        FormBuilder::new('create-link', function (FormBuilder $builder) {
            $builder->string('Label', 'title');
            $builder->string('Url', 'url');
            $builder->string('Alt', 'alt');
            $builder->string('Icon', 'icon');
            $builder->boolean('New Tab', 'new_tab');
            $builder->boolean('Clickable', 'clickable');
            $builder->wysiwyg('Content', 'content');
        });

        DB::statement("DELETE FROM forms WHERE name = 'edit-menu-item'");

        $form = FormBuilder::new('edit-menu-item', function (FormBuilder $builder) {
            $builder->string('Label', 'title');
            $builder->string('Alt', 'alt');
            $builder->string('Icon', 'icon');
            $builder->boolean('New Tab', 'new_tab');
            $builder->boolean('Clickable', 'clickable');
        })->getForm();

        WebsiteBuilder::edit($cp->id)->linkForm($form);

        DB::statement("DELETE FROM forms WHERE name = 'edit-link'");

        $form = FormBuilder::new('edit-link', function (FormBuilder $builder) {
            $builder->string('Label', 'title');
            $builder->string('Url', 'url');
            $builder->string('Alt', 'alt');
            $builder->string('Icon', 'icon');
            $builder->boolean('New Tab', 'new_tab');
            $builder->boolean('Clickable', 'clickable');
            $builder->wysiwyg('Content', 'content');
        })->getForm();

        WebsiteBuilder::edit($cp->id)->linkForm($form);
    }
}
