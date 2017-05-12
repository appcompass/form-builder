<?php

namespace P3in\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use P3in\Builders\FormBuilder;
use P3in\Builders\WebsiteBuilder;
use P3in\Models\FieldSource;
use P3in\Models\Section;

class ResourcesSeeder extends Seeder
{
    public function run()
    {

        FormBuilder::new('users', function (FormBuilder $builder) {
            $builder->string('First Name', 'first_name')->list()->required()->sortable()->searchable();
            $builder->string('Last Name', 'last_name')->list()->required()->sortable()->searchable();
            $builder->string('Email', 'email')->list()->validation(['required', 'email'])->sortable()->searchable();
            $builder->string('Phone Number', 'phone')->list()->required()->sortable()->searchable();
            $builder->boolean('Active', 'active')->list(false);
            $builder->string('Created', 'created_at')->list()->edit(false)->sortable()->searchable();
            $builder->string('Updated', 'updated_at')->list()->edit(false)->sortable()->searchable();
            $builder->secret('Password', 'password')->required();
        })->linkToResources(['users.index', 'users.show', 'users.create', 'users.update', 'users.store']);

        FormBuilder::new('user-roles', function (FormBuilder $builder) {
            $builder->string('Name', 'label')->list()->required()->sortable()->searchable();
        })->linkToResources(['users.roles.index']);

        FormBuilder::new('permissions', function (FormBuilder $builder) {
            $builder->string('Name', 'label')->list()->required()->sortable()->searchable();
            $builder->text('Description', 'description')->list(false)->required()->sortable()->searchable();
            $builder->string('Created', 'created_at')->list()->edit(false)->sortable()->searchable();
            $builder->string('Updated', 'updated_at')->list()->edit(false)->sortable()->searchable();
        })->linkToResources([['permissions.index' => 'admin'], ['permissions.show' => 'admin'], ['permissions.create' => 'admin'], ['permissions.store' => 'admin'], ['permissions.update' => 'admin']]);

        FormBuilder::new('roles', function (FormBuilder $builder) {
            $builder->string('Role Name', 'name')->list()->required()->sortable()->searchable();
            $builder->string('Role Label', 'label')->list()->required()->sortable()->searchable();
            $builder->text('Description', 'description')->list(false)->required()->sortable()->searchable();
            $builder->string('Created', 'created_at')->list()->edit(false)->sortable()->searchable();
            $builder->string('Updated', 'updated_at')->list()->edit(false)->sortable()->searchable();
        })->linkToResources([['roles.index' => 'admin'], ['roles.show' => 'admin'], ['roles.store' => 'admin'], ['roles.update' => 'admin']]);

        FormBuilder::new('role-permissions', function (FormBuilder $builder) {
            $builder->string('Name', 'label')->list()->required()->sortable()->searchable();
        })->linkToResources([['roles.permissions.index' => 'admin']]);


        FormBuilder::new('websites', function (FormBuilder $builder) {
            $builder->string('Website Name', 'name')->list()->required()->sortable()->searchable()
                ->help('The Human Readable website name');
            $builder->select('Scheme', 'scheme')->list()->required()->sortable()->searchable()
                ->dynamic([
                    ['index' => 'http', 'label' => 'Plain (HTTP)'],
                    ['index' => 'https', 'label' => 'Secure (HTTPS)']
                ])
                ->help('Website Schema. We recommend website to be served using HTTPS');
            $builder->string('Host', 'host')->list()->required()->sortable()->searchable()
                ->help('Just the fully qualified hostname (FQDN)');
            $builder->string('Created', 'created_at')->list()->edit(false)->sortable()->searchable();
            $builder->string('Updated', 'updated_at')->list()->edit(false)->sortable()->searchable();
            $builder->fieldset('Configuration', 'config', function (FormBuilder $builder) {
                $builder->select('Header', 'header')
                    ->dynamic(Section::class, function (FieldSource $source) {
                        $source->where('type', 'header');
                        $source->select(['id AS index', 'name AS label']);
                    })
                    ->required()
                    ->help('Please select a Header');
                $builder->select('Footer', 'footer')
                    ->dynamic(Section::class, function (FieldSource $source) {
                        $source->where('type', 'footer');
                        $source->select(['id AS index', 'name AS label']);
                    })
                    ->required()
                    ->help('Please select a Footer');
                $builder->code('Layouts', 'layouts')
                    // @TODO: We need to be able to provide the key value
                    // of the repeatable field and remove the dynamic flag.
                    // ->keyed()
                    // ->repeatable()
                    ->dynamic(['public', 'errors']);
                $builder->fieldset('Deployment', 'deployment', function (FormBuilder $depBuilder) {
                    $depBuilder->string('Publish From Path', 'publish_from')
                        ->required();
                });
            });

            $builder->fieldset('Meta Data', 'config.meta', function (FormBuilder $builder) {
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
                $builder->string('Google Analytics Tracking ID', 'ga_tracking_id')
                    ->help('Google Analytics Tracking ID in the format of: UA-XXXXX-Y');
                $builder->string('Facebook Url', 'facebook_url')
                    ->help('The title of the website as it apears in header');
                $builder->string('Instagram Url', 'instagram_url')
                    ->help('The title of the website as it apears in header');
                $builder->string('Twitter Url', 'twitter_url')
                    ->help('The title of the website as it apears in header');
                $builder->string('Google Plus Url', 'google_plus_url')
                    ->help('The title of the website as it apears in header');
                $builder->string('LinkedIn Url', 'linkedin_url')
                    ->help('The title of the website as it apears in header');
                // @TODO: We need to be able to provide the key value of the repeatable field,
                // not have a config field type with limited value field type constraints.
                $builder->config('Addtional Header Tags', 'custom')
                    // ->string('Addtional Header Tags', 'custom')
                    // ->keyed()
                    // ->repeatable()
                    ->help('Additional meta tags to be added.');
            });
        })->linkToResources(['websites.index', 'websites.show', 'websites.create', 'websites.store', 'websites.update']);

        FormBuilder::new('websites.redirects', function (FormBuilder $builder) {
            $builder->string('From', 'from')->list()->sortable()->searchable()->required();
            $builder->string('To', 'to')->list()->sortable()->searchable()->required();
            $builder->select('Type', 'type')->list()->required()->sortable()->searchable()
                ->dynamic([
                    [
                        'index' => '301',
                        'label' => 'Permanently Moved (301)'
                    ], [
                        'index' => '302',
                        'label' => 'Temporarily Moved (302)'
                    ]
                ])
                ->help('The Redirect type.');

            $builder->string('Created', 'created_at')->list()->edit(false)->sortable()->searchable();
            $builder->string('Updated', 'updated_at')->list()->edit(false)->sortable()->searchable();
            $builder->select('Role required', 'req_role')
                ->dynamic(\P3in\Models\Role::class, function (FieldSource $source) {
                    $source->select(['id As index', 'label']);
                })
                ->nullable();
        })->linkToResources(['websites.redirects.index', 'websites.redirects.store', 'websites.redirects.update']);

        FormBuilder::new('pages', function (FormBuilder $builder) {
            $builder->editor('Page');
            $builder->string('Page Title', 'title')->list()->required()->sortable()->searchable();
            $builder->string('Parent', 'parent.title')->list()->edit(false)->sortable()->searchable();
            $builder->string('URL', 'url')->list()->edit(false)->sortable()->searchable();
            $builder->boolean('Dynamic', 'dynamic_url')->list()->sortable();
            $builder->string('Created', 'created_at')->list()->edit(false)->sortable()->searchable();
            $builder->string('Updated', 'updated_at')->list()->edit(false)->sortable()->searchable();
            $builder->string('Slug', 'slug')->list(false)->required();
            $builder->select('Parent', 'parent_id')->list(false)->dynamic(\P3in\Models\Page::class, function (FieldSource $source) {
                $source->limit(4);
                // @TODO: we need to specify the website_id is the same as the current page's website_id.
                // $source->where('website_id', \P3in\Models\Website::whereHost(env('ADMIN_WEBSITE_HOST'))->first()->id);
                $source->select(['id AS index', 'title AS label']);
            });
            $builder->fieldset('Sitemap Data', 'config.sitemap', function (FormBuilder $builder) {
                $builder->text('Author', 'priority')->list(false)->required();
                $builder->select('Change Frequency', 'changefreq')->list(false)->required()->dynamic([
                    ['index' => 'always', 'label' => 'Always'],
                    ['index' => 'hourly', 'label' => 'Hourly'],
                    ['index' => 'daily', 'label' => 'Daily'],
                    ['index' => 'weekly', 'label' => 'Weekly'],
                    ['index' => 'monthly', 'label' => 'Monthly'],
                    ['index' => 'yearly', 'label' => 'Yearly'],
                    ['index' => 'never', 'label' => 'Never']
                ])->help('Website Schema. We recommend website to be served using HTTPS');
            });
            $builder->fieldset('Meta Data', 'config.head', function (FormBuilder $builder) {
                $builder->text('Author', 'head.author')->list(false)->required();
                $builder->text('Description', 'description')->list(false)->required();
                $builder->string('Keywords', 'keywords')->list(false)->required();
                $builder->string('Canonical URL', 'canonical')->list(false)->required();
                $builder->config('Addtional Header Tags', 'custom')->list(false)
                    ->help('Additional meta tags to be added. This is in addition to the website wide additional header tags.');
            });
            $builder->fieldset('Custom Code Inserts', 'config.code', function (FormBuilder $builder) {
                $builder->code('Custom Header HTML', 'custom_header_html')->list(false)
                    ->help('Custom header HTML, CSS, JS.  This is in addition to the website wide custom header html.');
                $builder->code('Custom Before Body End HTML', 'custom_before_body_end_html')->list(false)
                    ->help('HTML, CSS, JS you may need to inject before the closing </body> tag on all pages. This is in addition to the website wide custom before body end html.');
                $builder->code('Custom Footer HTML', 'custom_footer_html')->list(false)
                    ->help('Custom footer HTML, CSS, JS This is in addition to the website wide custom footer html.');
            });

        })->linkToResources(['pages.show', 'websites.pages.index', 'websites.pages.create', 'websites.pages.show']);


        FormBuilder::new('menus', function (FormBuilder $builder) {
            $builder->string('Name', 'name')->list()->required()->sortable()->searchable();
            $builder->string('Created', 'created_at')->list()->edit(false)->sortable()->searchable();
            $builder->string('Updated', 'updated_at')->list()->edit(false)->sortable()->searchable();
        })->linkToResources(['websites.menus.index', 'websites.menus.create']);

        FormBuilder::new('menus-editor', function (FormBuilder $builder) {
            $builder->editor('Menu');
            // $builder->menuEditor('Menu', 'menu')->list(false);
        })->linkToResources(['websites.menus.show']);

        FormBuilder::new('create-link', function (FormBuilder $builder) {
            $builder->string('Label', 'title');
            $builder->string('Url', 'url');
            $builder->string('Alt', 'alt');
            $builder->string('Icon', 'icon');
            $builder->boolean('New Tab', 'new_tab');
            $builder->boolean('Shared Link', 'shared')
                ->help('Checking this option allows this link to be visible and accessed via any installed website, and not just this website.');
            $builder->boolean('Clickable', 'clickable');
            $builder->wysiwyg('Content', 'content');
        });

        FormBuilder::new('edit-menu-item', function (FormBuilder $builder) {
            $builder->string('Label', 'title');
            $builder->string('Alt', 'alt');
            $builder->string('Icon', 'icon');
            $builder->select('Permission Required', 'req_perm')->dynamic(\P3in\Models\Permission::class, function (FieldSource $source) {
                $source->select(['id AS index', 'label']);
            });
            $builder->boolean('New Tab', 'new_tab');
            $builder->boolean('Clickable', 'clickable');
        });

        FormBuilder::new('edit-link', function (FormBuilder $builder) {
            $builder->string('Label', 'title');
            $builder->string('Url', 'url');
            $builder->string('Alt', 'alt');
            $builder->string('Icon', 'icon');
            $builder->select('Permission Required', 'req_perm')->dynamic(\P3in\Models\Permission::class, function (FieldSource $source) {
                $source->select(['id AS index', 'label']);
            });
            $builder->boolean('New Tab', 'new_tab');
            $builder->boolean('Clickable', 'clickable');
            $builder->wysiwyg('Content', 'content');
        });

        Formbuilder::new('storage', function (FormBuilder $builder) {
            $builder->string('Name', 'name')->list()->sortable()->searchable()->required();
            $builder->string('Type', 'type.name')->list()->edit(false)->sortable()->searchable()->required();
            $builder->select('Disk Instance', 'type_id')->list(false)->required()->dynamic(\P3in\Models\StorageType::class, function (FieldSource $source) {
                $source->select(['id AS index', 'name AS label']);
            });
            $builder->string('Created', 'created_at')->list()->edit(false)->sortable()->searchable();
            $builder->string('Updated', 'updated_at')->list()->edit(false)->sortable()->searchable();
            // @TODO this is one way, but validation has issues (too long to explain here)
            // $builder->string('Root', 'config.root')->list()->sortable()->searchable()->required();
            $builder->fieldset('Configuration', 'config', function (FormBuilder $builder) {
                $builder->string('Root', 'root')->list()->sortable()->searchable()->required();
            })->list(false)->required();
        })->linkToResources(['storage.index', 'storage.show', 'storage.create', 'storage.store', 'storage.update']);

        FormBuilder::new('resources', function (FormBuilder $builder) {
            $builder->string('Resource', 'resource')->list()->sortable()->searchable()->required();
            $builder->string('Created', 'created_at')->list()->edit(false)->sortable()->searchable();
            $builder->string('Updated', 'updated_at')->list()->edit(false)->sortable()->searchable();
            $builder->select('Role required', 'req_role')->dynamic(\P3in\Models\Role::class, function (FieldSource $source) {
                $source->select(['id As index', 'label']);
            })->nullable();
        })->linkToResources(['resources.index', 'resources.show', 'resources.create']);

        FormBuilder::new('forms', function (FormBuilder $builder) {
            $builder->string('Name', 'name')->list(true)->sortable()->searchable();
            $builder->string('Editor', 'editor');
            $builder->string('Fields', 'fieldsCount')->edit(false)->list();
            $builder->string('Created', 'created_at')->list()->edit(false)->sortable()->searchable();
            $builder->string('Updated', 'updated_at')->list()->edit(false)->sortable()->searchable();
            $builder->string('Updated', 'updated_at')->edit(false);
        })->linkToResources(['forms.index', 'forms.show']);

    }
}
