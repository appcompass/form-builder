<?php

namespace P3in\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use P3in\Builders\FormBuilder;
use P3in\Builders\WebsiteBuilder;
use P3in\Models\FieldSource;
use P3in\Models\Section;

class WebsitesSeeder extends Seeder
{
    public function run()
    {
        // DB::statement('TRUNCATE websites RESTART IDENTITY CASCADE');
        // DB::statement('TRUNCATE pages RESTART IDENTITY CASCADE');

        $cp = WebsiteBuilder::new(env('ADMIN_WEBSITE_NAME'), env('ADMIN_WEBSITE_SCHEME'), env('ADMIN_WEBSITE_HOST'), function ($websiteBuilder) {

            $websiteBuilder->setStorage('cp_root');

            $login = Section::create([
                'name' => 'Login Template',
                'template' => 'Login',
                'type' => 'section'
            ]);
            $register = Section::create([
                'name' => 'Register Template',
                'template' => 'Register',
                'type' => 'section'
            ]);
            $passwordEmail = Section::create([
                'name' => 'password Email Template',
                'template' => 'PasswordEmail',
                'type' => 'section'
            ]);
            $passwordReset = Section::create([
                'name' => 'Password Reset Template',
                'template' => 'PasswordReset',
                'type' => 'section'
            ]);
            $home = Section::create([
                'name' => 'Dashboard Template',
                'template' => 'Home',
                'type' => 'section'
            ]);
            $list = Section::create([
                'name' => 'List Template',
                'template' => 'List',
                'type' => 'section'
            ]);
            $create = Section::create([
                'name' => 'Create Template',
                'template' => 'Create',
                'type' => 'section'
            ]);
            $edit = Section::create([
                'name' => 'Edit Template',
                'template' => 'Edit',
                'type' => 'section'
            ]);
            $show = Section::create([
                'name' => 'Show Template',
                'template' => 'Show',
                'type' => 'section'
            ]);

            // ->addContainer()
        //                  ->addSection($list)

            $login = $websiteBuilder->addPage('Login', 'login')->addSection($login);
            $register = $websiteBuilder->addPage('Register', 'register')->addSection($register);
            $passwordEmail = $websiteBuilder->addPage('Request Password Reset', 'request-password-reset')->addSection($passwordEmail);
            $passwordReset = $websiteBuilder->addPage('Reset Password', 'reset-password')->addSection($passwordReset);
            $home = $websiteBuilder->addPage('Dashbaord', '')->addSection($home);

            $users = $websiteBuilder->addPage('Users', 'users')->addSection($list);
            $user = $websiteBuilder->addPage('User', 'users', true)->addSection($show);
            $user_profile = $user->addChild('Profile', '')->addSection($edit);
            $user_roles = $user->addChild('Roles', 'roles')->addSection($list);

            $roles = $websiteBuilder->addPage('Roles', 'roles')->addSection($list);
            $role = $websiteBuilder->addPage('Role', 'roles', true)->addSection($show);
            $role_info = $role->addChild('Info', '')->addSection($edit);
            $role_permissions = $role->addChild('Permissions', 'permissions')->addSection($list);

            $permissions = $websiteBuilder->addPage('Permissions', 'permissions')->addSection($list);
            $permission = $websiteBuilder->addPage('Permission', 'permissions', true)->addSection($show);
            $permission_info = $permission->addChild('Info', '')->addSection($edit);

            $resources = $websiteBuilder->addPage('Resources', 'resources')->addSection($list);
            $resource = $websiteBuilder->addPage('Resource', 'resources', true)->addSection($show);
            $resource_info = $resource->addChild('Info', '')->addSection($edit);

            $websites = $websiteBuilder->addPage('Websites', 'websites')->addSection($list);
            $website = $websiteBuilder->addPage('Website', 'websites', true)->addSection($show);
            $website_info = $website->addChild('Info', '')->addSection($edit);
            $navigations = $website->addChild('Menus', 'menus')->addSection($list);
            $navigation = $website->addChild('Menu', 'menus', true)->addSection($show);
            $navigation_builder = $navigation->addChild('Editor', '')->addSection($edit);

            $pages = $website->addChild('Pages', 'pages')->addSection($list);
            $page = $website->addChild('Page', 'pages', true)->addSection($show);
            $page_info = $page->addChild('Info', '')->addSection($edit);
            $page_layouts = $page->addChild('Layout', 'layout')->addSection($list);
            $page_contents = $page->addChild('Content', 'contents')->addSection($list);
            // @TODO: work out the flow of blog.
            $blogEntries = $website->addChild('Blog Entries', 'blog-entries')->addSection($list);
            $blogCategories = $website->addChild('Blog Categories', 'blog-categories')->addSection($list);
            $blogTags = $website->addChild('Blog Tags', 'blog-tags')->addSection($list);
            $redirects = $website->addChild('Redirects', 'redirects')->addSection($list);

            $galleries = $websiteBuilder->addPage('Galleries', 'galleries')->addSection($list);
            $gallery = $websiteBuilder->addPage('Gallery', 'galleries', true)->addSection($show);
            $gallery_info = $gallery->addChild('Info', '')->addSection($edit);
            $gallery_photos = $gallery->addChild('Photos', 'photos')->addSection($list);
            $gallery_videos = $gallery->addChild('Videos', 'videos')->addSection($list);

            // @TODO: storage workflow needs to be looked at a bit.
            $storages = $websiteBuilder->addPage('Storage', 'storage')->addSection($list);
            $storage = $websiteBuilder->addPage('Storage', 'storages', true)->addSection($show);
            $storage_info = $storage->addChild('Info', '')->addSection($edit);
            $storage_types = $storage->addChild('Types', 'storage-types')->addSection($list);

            $forms = $websiteBuilder->addPage('Forms', 'forms')->addSection($list);
            $form = $websiteBuilder->addPage('Form', 'forms', true)->addSection($show);
            $form_info = $form->addChild('Info', '')->addSection($edit);
            // @TODO: form submissions?

            $websiteBuilder->addMenu('user_nav')
                ->add(['title' => 'Profile', 'url' => '/users/:current_user_id', 'alt' => 'Profile'], 1)->icon('user');

            $websiteBuilder->addMenu('main_nav')
                ->add(['title' => 'Dashboard', 'url' => '/', 'alt' => 'Dashboard'], 1)
                ->add(['title' => 'Users Management', 'alt' => 'Users Management'], 2)->sub()
                    ->add($users, 1)->icon('user')->sub()
                        ->add($user_profile, 1)->icon('user')
                        ->add($user_roles, 2)->icon('group')
                        ->parent()
                    ->add($roles, 2)->icon('group')->sub()
                        ->add($role_info, 1)->icon('group')
                        ->add($role_permissions, 2)->icon('permission')
                        ->parent()
                    ->add($permissions, 3)->icon('permission')->sub()
                        ->add($permission_info, 1)->icon('permission')
                        ->parent()
                    ->add($resources, 4)->icon('diamond')->sub()
                        ->add($resource_info, 1)->icon('diamond')
                        ->parent()
                    ->parent()
                ->add(['title' => 'Web Properties', 'alt' => 'Web Properties'], 3)->sub()
                    ->add($websites, 1)->icon('globe')->sub()
                        ->add($website_info, 1)->icon('edit')
                        ->add($pages, 2)->icon('pages')->sub()
                            ->add($page_info, 1)->icon('pages')
                            ->add($page_layouts, 2)->icon('page')
                            ->add($page_contents, 3)->icon('page')
                            ->parent()
                        // @TODO: blog end point flow needs to be worked out
                        ->add(['url' => '/blog', 'title' => 'Blog', 'alt' => 'Blog'], 3)->icon('page') ->sub()
                            ->add($blogEntries, 1)->icon('page')
                            ->add($blogCategories, 2)->icon('page')
                            ->add($blogTags, 3)->icon('page')
                            ->parent()
                        ->add($navigations, 4)->icon('navigation')->sub()
                            ->add($navigation, 1)->icon('pages')
                            ->add($navigation_builder, 2)->icon('page')
                            ->parent()
                        ->add($redirects, 5)->icon('redirect')
                        ->parent()
                    ->parent()
                ->add(['title' => 'Media Management', 'alt' => 'Media Management'], 4)->sub()
                    ->add($galleries, 1)->icon('camera')->sub()
                            ->add($gallery_info, 1)->icon('gallery')
                            ->add($gallery_photos, 2)->icon('image')
                            ->add($gallery_videos, 3)->icon('video')
                        ->parent()
                    ->parent()
                ->add(['title' => 'Settings', 'alt' => 'Settings'], 5)->sub()
                    ->add($storage, 1)->icon('settings')->sub()
                        ->add($storage_info, 1)->icon('settings')
                        ->add($storage_types, 2)->icon('settings')
                        ->parent()
                    ->add($forms, 2)->icon('file')->sub()
                        ->add($form_info, 1)->icon('file')
                        ;
        })->getWebsite();

        // DB::statement("DELETE FROM forms WHERE name = 'websites'");

        $form = FormBuilder::new('websites', function (FormBuilder $builder) {
            // $builder->setViewTypes(['list','grid']);
            $builder->string('Website Name', 'name')
                ->list()
                ->required()
                ->sortable()
                ->searchable()
                ->help('The Human Readable website name');
            $builder->select('Scheme', 'scheme')
                ->list()
                ->required()
                ->sortable()
                ->searchable()
                ->dynamic([
                    ['index' => 'http', 'label' => 'Plain (HTTP)'],
                    ['index' => 'https', 'label' => 'Secure (HTTPS)']
                ])
                ->help('Website Schema. We recommend website to be served using HTTPS');
            $builder->string('Host', 'host')
                ->list()
                ->required()
                ->sortable()
                ->searchable()
                ->help('Just the fully qualified hostname (FQDN)');

            $builder->fieldset('Configuration', 'config', function(FormBuilder $builder) {
                $builder->select('Header', 'header')
                    ->dynamic(Section::class, function(FieldSource $source) {
                        $source->where('type', 'header');
                        $source->select(['id AS index', 'name AS label']);
                    })
                    ->required()
                    ->help('Please select a Header');
                $builder->select('Footer', 'footer')
                    ->dynamic(Section::class, function(FieldSource $source) {
                        $source->where('type', 'footer');
                        $source->select(['id AS index', 'name AS label']);
                    })
                    ->required()
                    ->help('Please select a Footer');
                $builder->code('Layouts', 'layouts')
                    ->dynamic(['public', 'errors']);
                $builder->fieldset('Deployment', 'deployment', function (FormBuilder $depBuilder) {
                    $depBuilder->string('Publish From Path', 'publish_from')
                        ->required();
                });
            });

            // @NOTE another valid approach is
            // $builder->string('Title', 'config.meta.title')

            $builder->fieldset('Meta Data', 'config.meta', function(FormBuilder $builder) {
                $builder->string('Title', 'title')
                    ->required()
                    ->help('The title of the website as it apears in header');
                $builder->text('Description', 'description')
                    ->required()
                    ->help('The website desscription');
                $builder->text('Keywords', 'keywords')
                    ->help('The website keywords, though this is no longer used by many Search Engines');
                $builder->code('Custom Header HTML', 'custom_header_html')
                    ->help('Custom header HTML, CSS, JS');
                $builder->code('Custom Before Body End HTML', 'custom_before_body_end_html')
                    ->help('HTML, CSS, JS you may need to inject before the closing </body> tag on all pages.');
                $builder->code('Custom Footer HTML', 'custom_footer_html')
                    ->help('Custom footer HTML, CSS, JS');
                $builder->text('Robots.txt Contents', 'robots_txt')
                    ->help('The Contents of the robots.txt file for search engines.');
                $builder->string('Facebook Url', 'facebook_url')
                    ->required()
                    ->help('The title of the website as it apears in header');
                $builder->string('Instagram Url', 'instagram_url')
                    ->required()
                    ->help('The title of the website as it apears in header');
                $builder->string('Twitter Url', 'twitter_url')
                    ->required()
                    ->help('The title of the website as it apears in header');
                $builder->string('Google Plus Url', 'google_plus_url')
                    ->required()
                    ->help('The title of the website as it apears in header');
                $builder->string('LinkedIn Url', 'linkedin_url')
                    ->required()
                    ->help('The title of the website as it apears in header');
                $builder->config('Addtional Header Tags', 'custom')
                    // ->dynamic(['title', 'description', 'keywords'])
                    ->help('Additional meta tags to be added.');
            });
        })->linkToResources(['websites.index', 'websites.show', 'websites.create', 'websites.store', 'websites.update'])
        ->getForm();

        WebsiteBuilder::edit($cp->id)->linkForm($form);

        // DB::statement("DELETE FROM forms WHERE name = 'pages'");

        $form = FormBuilder::new('pages', function (FormBuilder $builder) {
            $builder->editor('Page');
            // $builder->setViewTypes(['list','grid']);
            $builder->string('Page Title', 'title')
                ->list()
                ->required()
                ->sortable()
                ->searchable();
            $builder->string('Slug', 'slug')
                ->list(false)
                ->required();
            $builder->select('Parent', 'parent_id')->list(false)
                ->dynamic(\P3in\Models\Page::class, function(FieldSource $source) {
                    $source->limit(4);
                    $source->where('website_id', \P3in\Models\Website::whereHost(env('ADMIN_WEBSITE_HOST'))->first()->id);
                    $source->select(['id AS index', 'title AS label']);
                });
        })->linkToResources(['pages.show', 'websites.pages.index', 'websites.pages.create', 'websites.pages.show'])
            ->getForm();

        WebsiteBuilder::edit($cp->id)->linkForm($form);

        // DB::statement("DELETE FROM forms WHERE name = 'menus'");

        FormBuilder::new('menus', function (FormBuilder $builder) {
            $builder->string('Name', 'name')->list()->required()->sortable()->searchable();
        })->linkToResources(['websites.menus.index', 'websites.menus.create']);

        // DB::statement("DELETE FROM forms WHERE name = 'menus-editor'");

        FormBuilder::new('menus-editor', function (FormBuilder $builder) {
            $builder->editor('Menu');
            // $builder->menuEditor('Menu', 'menu')->list(false);
        })->linkToResources(['websites.menus.show']);

        // DB::statement("DELETE FROM forms WHERE name = 'create-link'");

        FormBuilder::new('create-link', function (FormBuilder $builder) {
            $builder->string('Label', 'title');
            $builder->string('Url', 'url');
            $builder->string('Alt', 'alt');
            $builder->string('Icon', 'icon');
            $builder->boolean('New Tab', 'new_tab');
            $builder->boolean('Clickable', 'clickable');
            $builder->wysiwyg('Content', 'content');
        });

        // DB::statement("DELETE FROM forms WHERE name = 'edit-menu-item'");

        $form = FormBuilder::new('edit-menu-item', function (FormBuilder $builder) {
            $builder->string('Label', 'title');
            $builder->string('Alt', 'alt');
            $builder->string('Icon', 'icon');
            $builder->select('Permission Required', 'req_perm')->dynamic(\P3in\Models\Permission::class, function(FieldSource $source) {
                $source->select(['id AS index', 'label']);
            });
            $builder->boolean('New Tab', 'new_tab');
            $builder->boolean('Clickable', 'clickable');
        })->getForm();

        WebsiteBuilder::edit($cp->id)->linkForm($form);

        // DB::statement("DELETE FROM forms WHERE name = 'edit-link'");

        $form = FormBuilder::new('edit-link', function (FormBuilder $builder) {
            $builder->string('Label', 'title');
            $builder->string('Url', 'url');
            $builder->string('Alt', 'alt');
            $builder->string('Icon', 'icon');
            $builder->select('Permission Required', 'req_perm')->dynamic(\P3in\Models\Permission::class, function(FieldSource $source) {
                $source->select(['id AS index', 'label']);
            });
            $builder->boolean('New Tab', 'new_tab');
            $builder->boolean('Clickable', 'clickable');
            $builder->wysiwyg('Content', 'content');
        })->getForm();

        WebsiteBuilder::edit($cp->id)->linkForm($form);

        // DB::statement("DELETE FROM forms WHERE name = 'storage'");

        Formbuilder::new('storage', function(FormBuilder $builder) {
            $builder->string('Name', 'name')
                ->list()
                ->sortable()
                ->searchable()
                ->required();
            $builder->string('Type', 'type.name')
                ->list()
                ->edit(false)->sortable()
                ->searchable()
                ->required();
            $builder->select('Disk Instance', 'type_id')
                ->list(false)
                ->dynamic(\P3in\Models\StorageType::class, function(FieldSource $source) {
                    $source->select(['id AS index', 'name AS label']);
                })->required();
            // @TODO this is one way, but validation has issues (too long to explain here)
            // $builder->string('Root', 'config.root')->list()->sortable()->searchable()->required();
            $builder->fieldset('Configuration', 'config', function(FormBuilder $builder) {
                $builder->string('Root', 'root')
                    ->list()
                    ->sortable()
                    ->searchable()
                    ->required();
            })->list(false)->required();

        })->linkToResources(['storage.index', 'storage.show', 'storage.create', 'storage.store', 'storage.update']);

        FormBuilder::new('resources', function(FormBuilder $builder) {
            $builder->string('Resource', 'resource')->list()->sortable()->searchable()->required();
            $builder->string('Created', 'created_at')->list()->edit(false);
            $builder->select('Role required', 'req_role')->dynamic(\P3in\Models\Role::class, function(FieldSource $source) {
                $source->select(['id As index', 'label']);
            })->nullable();
        })->linkToResources(['resources.index', 'resources.show', 'resources.create']);

        FormBuilder::new('forms', function(FormBuilder $builder) {
            $builder->string('Name', 'name')->list(true)->sortable()->searchable();
            $builder->string('Editor', 'editor');
            $builder->string('Fields', 'fieldsCount')->edit(false)->list();
            $builder->string('Created', 'created_at')->edit(false);
            $builder->string('Ureated', 'updated_at')->edit(false);
        })->linkToResources(['forms.index', 'forms.show']);
    }
}
