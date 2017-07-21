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

        WebsiteBuilder::new(env('ADMIN_WEBSITE_NAME'), env('ADMIN_WEBSITE_SCHEME'), env('ADMIN_WEBSITE_HOST'), function ($websiteBuilder) {
            $websiteBuilder->setStorage('cp_root');

            $loginSection = $websiteBuilder->addSection([
                'name' => 'Login Template',
                'template' => 'Login',
                'type' => 'section'
            ]);
            $registerSection = $websiteBuilder->addSection([
                'name' => 'Register Template',
                'template' => 'Register',
                'type' => 'section'
            ]);
            $passwordEmailSection = $websiteBuilder->addSection([
                'name' => 'password Email Template',
                'template' => 'PasswordEmail',
                'type' => 'section'
            ]);
            $passwordResetSection = $websiteBuilder->addSection([
                'name' => 'Password Reset Template',
                'template' => 'PasswordReset',
                'type' => 'section'
            ]);
            $homeSection = $websiteBuilder->addSection([
                'name' => 'Dashboard Template',
                'template' => 'Home',
                'type' => 'section'
            ]);
            $list = $websiteBuilder->addSection([
                'name' => 'List Template',
                'template' => 'List',
                'type' => 'section'
            ]);
            $create = $websiteBuilder->addSection([
                'name' => 'Create Template',
                'template' => 'Create',
                'type' => 'section'
            ]);
            $edit = $websiteBuilder->addSection([
                'name' => 'Edit Template',
                'template' => 'Edit',
                'type' => 'section'
            ]);
            $show = $websiteBuilder->addSection([
                'name' => 'Show Template',
                'template' => 'Show',
                'type' => 'section'
            ]);

            $pageEditor = $websiteBuilder->addSection([
                'name' => 'Website Page Editor Template',
                'template' => 'WebsitePageEditor',
                'type' => 'section'
            ]);

            $websiteLayoutEditor = $websiteBuilder->addSection([
                'name' => 'Website Layout Editor Template',
                'template' => 'WebsiteLayoutEditor',
                'type' => 'section'
            ]);

            $mediaEditor = $websiteBuilder->addSection([
                'name' => 'Media Editor',
                'template' => 'MediaEditor',
                'type' => 'section'
            ]);

            $publicLayout = $websiteBuilder->addLayout('Public')->getLayout();
            $privateLayout = $websiteBuilder->addLayout('Private')->getLayout();
            $fullScreenLayout = $websiteBuilder->addLayout('FullScreen')->getLayout();

            $login = $websiteBuilder->addPage('Login', 'login')->setPermission('guest')->addSection($loginSection)->layout($publicLayout);
            $register = $websiteBuilder->addPage('Register', 'register')->setPermission('guest')->addSection($registerSection)->layout($publicLayout);
            $passwordEmail = $websiteBuilder->addPage('Request Password Reset', 'request-password-reset')->setPermission('guest')->addSection($passwordEmailSection)->layout($publicLayout);
            $passwordReset = $websiteBuilder->addPage('Reset Password', 'reset-password', true)->setPermission('guest')->addSection($passwordResetSection)->layout($publicLayout);
            $home = $websiteBuilder->addPage('Dashbaord', 'dashboard')->setPermission('cp-login')->addSection($homeSection)->layout($privateLayout)->requiresAuth();

            $users = $websiteBuilder->addPage('Users', 'users')->setPermission('users_admin')->addSection($list)->layout($privateLayout)->requiresAuth()->resource('users.index');
            $create_user = $websiteBuilder->addPage('Create', 'users/create')->setPermission('users_admin')->addSection($create)->layout($privateLayout)->requiresAuth()->resource('users.create');
            $user = $websiteBuilder->addPage('User', 'users', true)->setPermission('users_admin')->addSection($edit)->layout($privateLayout)->requiresAuth()->resource('users.show');
            $user_profile = $user->addChild('Profile', '')->setPermission('users_admin')->addSection($edit)->layout($privateLayout)->requiresAuth()->resource('users.edit');
            $user_roles = $user->addChild('Roles', 'roles')->setPermission('users_admin')->addSection($list)->layout($privateLayout)->requiresAuth()->resource('users.roles.index');
            $user_permissions = $user->addChild('Permissions', 'permissions')->setPermission('users_admin')->addSection($list)->layout($privateLayout)->requiresAuth()->resource('users.permissions.index');

            $roles = $websiteBuilder->addPage('Roles', 'roles')->setPermission('permissions_admin')->addSection($list)->layout($privateLayout)->requiresAuth()->resource('roles.index');
            $create_role = $websiteBuilder->addPage('Create', 'roles/create')->setPermission('permissions_admin')->addSection($create)->layout($privateLayout)->requiresAuth()->resource('roles.create');
            $role = $websiteBuilder->addPage('Role', 'roles', true)->setPermission('permissions_admin')->addSection($edit)->layout($privateLayout)->requiresAuth()->resource('roles.show');
            $role_info = $role->addChild('Info', '')->setPermission('permissions_admin')->addSection($edit)->layout($privateLayout)->requiresAuth()->resource('roles.edit');
            $role_permissions = $role->addChild('Permissions', 'permissions')->setPermission('permissions_admin')->addSection($list)->layout($privateLayout)->requiresAuth()->resource('roles.permissions.index');

            $permissions = $websiteBuilder->addPage('Permissions', 'permissions')->setPermission('permissions_admin')->addSection($list)->layout($privateLayout)->requiresAuth()->resource('permissions.index');
            $create_permission = $websiteBuilder->addPage('Create', 'permissions/create')->setPermission('permissions_admin')->addSection($create)->layout($privateLayout)->requiresAuth()->resource('permissions.create');
            $permission = $websiteBuilder->addPage('Permission', 'permissions', true)->setPermission('permissions_admin')->addSection($edit)->layout($privateLayout)->requiresAuth()->resource('permissions.show');
            $permission_info = $permission->addChild('Info', '')->setPermission('permissions_admin')->addSection($edit)->layout($privateLayout)->requiresAuth()->resource('permissions.edit');

            $resources = $websiteBuilder->addPage('Resources', 'resources')->setPermission('resources_admin')->addSection($list)->layout($privateLayout)->requiresAuth()->resource('resources.index');
            $resource = $websiteBuilder->addPage('Resource', 'resources', true)->setPermission('resources_admin')->addSection($edit)->layout($privateLayout)->requiresAuth()->resource('resources.show');
            $resource_info = $resource->addChild('Info', '')->setPermission('resources_admin')->addSection($edit)->layout($privateLayout)->requiresAuth()->resource('resources.edit');

            $websites = $websiteBuilder->addPage('Websites', 'websites')->setPermission('websites_admin_view')->addSection($list)->layout($privateLayout)->requiresAuth()->resource('websites.index');
            $create_website = $websiteBuilder->addPage('Create', 'websites/create')->setPermission('websites_admin_create')->addSection($create)->layout($privateLayout)->requiresAuth()->resource('websites.create');
            $website = $websiteBuilder->addPage('Website', 'websites', true)->setPermission('websites_admin_view')->addSection($edit)->layout($privateLayout)->requiresAuth()->resource('websites.show');
            $website_setup = $website->addChild('Setup', 'setup')->setPermission('websites_admin_create')->addSection($edit)->layout($privateLayout)->requiresAuth()->resource('websites-setup');
            $website_settings = $website->addChild('Settings', '')->setPermission('websites_admin_create')->addSection($edit)->layout($privateLayout)->requiresAuth()->resource('websites.edit');
            $website_layouts = $website->addChild('Layouts', 'layouts')->setPermission('websites_layouts_admin')->addSection($list)->layout($privateLayout)->requiresAuth()->resource('websites.layouts.index');
            $website_layout = $website->addChild('Layout', 'layouts', true)->setPermission('websites_layouts_admin')->addSection($edit)->layout($privateLayout)->requiresAuth()->resource('websites.layouts.show');
            $website_layout_builder = $website_layout->addChild('Builder', '')->setPermission('websites_layouts_admin')->addSection($websiteLayoutEditor)->layout($privateLayout)->requiresAuth()->resource('websites.layouts.edit');
            $navigations = $website->addChild('Menus', 'menus')->setPermission('websites_menus_admin')->addSection($list)->layout($privateLayout)->requiresAuth()->resource('websites.menus.index');
            $navigation = $website->addChild('Menu', 'menus', true)->setPermission('websites_menus_admin')->addSection($edit)->layout($privateLayout)->requiresAuth()->resource('websites.menus.show');
            $navigation_builder = $navigation->addChild('Editor', '')->setPermission('websites_menus_admin')->addSection($edit)->layout($privateLayout)->requiresAuth()->resource('websites.menus.edit');

            $pages = $website->addChild('Pages', 'pages')->setPermission('websites_pages_admin')->addSection($list)->layout($privateLayout)->requiresAuth()->resource('websites.pages.index');
            $create_page = $website->addChild('Create', 'pages/create')->setPermission('websites_pages_admin')->addSection($pageEditor)->layout($fullScreenLayout)->resource('websites.pages.create');
            $page = $website->addChild('Page', 'pages', true)->setPermission('websites_pages_admin')->addSection($pageEditor)->layout($fullScreenLayout)->resource('websites.pages.show');
            // $page_info = $page->addChild('Info', '')->setPermission('')->addSection($pageEditor)->layout($fullScreenLayout)->resource('websites.pages.edit');
            // $page_layouts = $page->addChild('Layout', 'layout')->setPermission('')->addSection($pageEditor)->layout($fullScreenLayout)->resource('pages.contents.index');
            // $page_contents = $page->addChild('Content', 'contents')->setPermission('')->addSection($pageEditor)->layout($fullScreenLayout)->resource('pages.contents.show');
            // // @TODO: work out the flow of blog.
            // $blogEntries = $website->addChild('Blog Entries', 'blog-entries')->setPermission('')->addSection($list)->layout($privateLayout)->requiresAuth()->resource('websites.blog-entries.index');
            // $blogCategories = $website->addChild('Blog Categories', 'blog-categories')->setPermission('')->addSection($list)->layout($privateLayout)->requiresAuth()->resource('websites.blog-categories.index');
            // $blogTags = $website->addChild('Blog Tags', 'blog-tags')->setPermission('')->addSection($list)->layout($privateLayout)->requiresAuth()->resource('websites.blog-tags.index');

            $redirects = $website->addChild('Redirects', 'redirects')->setPermission('websites_admin_create')->addSection($list)->layout($privateLayout)->requiresAuth()->resource('websites.redirects.index');

            $galleries = $websiteBuilder->addPage('Galleries', 'galleries')->setPermission('media')->addSection($list)->layout($privateLayout)->requiresAuth()->resource('galleries.index');
            $gallery = $websiteBuilder->addPage('Gallery', 'galleries', true)->setPermission('media')->addSection($edit)->layout($privateLayout)->requiresAuth()->resource('galleries.show');
            $gallery_info = $gallery->addChild('Info', '')->setPermission('media')->addSection($edit)->layout($privateLayout)->requiresAuth()->resource('galleries.edit');
            $gallery_photos = $gallery->addChild('Photos', 'photos')->setPermission('media')->addSection($mediaEditor)->layout($privateLayout)->requiresAuth()->resource('galleries.photos.index');
            $gallery_videos = $gallery->addChild('Videos', 'videos')->setPermission('media')->addSection($list)->layout($privateLayout)->requiresAuth()->resource('galleries.videos.index');

            // @TODO: storage workflow needs to be looked at a bit.
            $storages = $websiteBuilder->addPage('Storage', 'storage')->setPermission('storage_admin')->addSection($list)->layout($privateLayout)->requiresAuth()->resource('disks.index');
            $create_storage = $websiteBuilder->addPage('Create', 'storage/create')->setPermission('storage_admin')->addSection($create)->layout($privateLayout)->requiresAuth()->resource('disks.create');
            $storage = $websiteBuilder->addPage('Storage', 'storages', true)->setPermission('storage_admin')->addSection($edit)->layout($privateLayout)->requiresAuth()->resource('disks.show');
            $storage_info = $storage->addChild('Info', '')->setPermission('storage_admin')->addSection($edit)->layout($privateLayout)->requiresAuth()->resource('disks.edit');

            $forms = $websiteBuilder->addPage('Forms', 'forms')->setPermission('forms_admin')->addSection($list)->layout($privateLayout)->requiresAuth()->resource('forms.index');
            $create_forms = $websiteBuilder->addPage('Create', 'forms/create')->setPermission('forms_admin')->addSection($create)->layout($privateLayout)->requiresAuth()->resource('forms.create');
            $form = $websiteBuilder->addPage('Form', 'forms', true)->setPermission('forms_admin')->addSection($edit)->layout($privateLayout)->requiresAuth()->resource('forms.show');
            $form_info = $form->addChild('Info', '')->setPermission('forms_admin')->addSection($edit)->layout($privateLayout)->requiresAuth()->resource('forms.edit');
            // @TODO: form submissions?

            $websiteBuilder->addMenu('user_nav')
                ->add(['title' => 'Profile', 'url' => '/users/:current_user_id', 'alt' => 'Profile'], 1)->icon('user');

            $websiteBuilder->addMenu('main_nav')
                ->add(['title' => 'Dashboard', 'url' => '/', 'alt' => 'Dashboard'], 1)
                ->add(['title' => 'Users Management', 'alt' => 'Users Management'], 2)->sub()
                    ->add($users, 1)->icon('user')->sub()
                        ->add($user_profile, 1)->icon('user')
                        ->add($user_roles, 2)->icon('group')
                        ->add($user_permissions, 3)->icon('permission')
                        ->parent()
                    ->add($roles, 2)->icon('group')->sub()
                        ->add($role_info, 1)->icon('edit')
                        ->add($role_permissions, 2)->icon('permission')
                        ->parent()
                    ->add($permissions, 3)->icon('permission')->sub()
                        ->add($permission_info, 1)->icon('edit')
                        ->parent()
                    ->parent()
                ->add(['title' => 'Web Properties', 'alt' => 'Web Properties'], 3)->sub()
                    ->add($websites, 1)->icon('globe')->sub()
                        ->add($website_setup, 1)->icon('settings')
                        ->add($website_settings, 2)->icon('edit')
                        ->add($website_layouts, 3)->icon('layouts')
                        ->add($pages, 4)->icon('pages')
                        // ->sub()
                        //     ->add($page_info, 1)->icon('edit')
                        //     ->add($page_layouts, 2)->icon('page')
                        //     ->add($page_contents, 3)->icon('page')
                        //     ->parent()
                        // // @TODO: blog end point flow needs to be worked out
                        // ->add(['url' => '/blog', 'title' => 'Blog', 'alt' => 'Blog'], 3)->icon('page') ->sub()
                        //     ->add($blogEntries, 1)->icon('page')
                        //     ->add($blogCategories, 2)->icon('page')
                        //     ->add($blogTags, 3)->icon('page')
                        //     ->parent()
                        ->add($navigations, 5)->icon('navigation')->sub()
                            ->add($navigation, 1)->icon('pages')
                            ->add($navigation_builder, 2)->icon('page')
                            ->parent()
                        ->add($redirects, 6)->icon('redirect')
                        ->parent()
                    ->parent()
                ->add(['title' => 'Media Management', 'alt' => 'Media Management'], 4)->sub()
                    ->add($galleries, 1)->icon('camera')->sub()
                            ->add($gallery_info, 1)->icon('edit')
                            ->add($gallery_photos, 2)->icon('image')
                            ->add($gallery_videos, 3)->icon('video')
                        ->parent()
                    ->parent()
                ->add(['title' => 'Settings', 'alt' => 'Settings'], 5)->sub()
                    ->add($storage, 1)->icon('settings')->sub()
                        ->add($storage_info, 1)->icon('settings')
                        ->parent()
                    ->add($forms, 2)->icon('file')->sub()
                        ->add($form_info, 1)->icon('file')
                        ->parent()
                    ->add($resources, 4)->icon('diamond')->sub()
                        ->add($resource_info, 1)->icon('edit')
                        ;
        });
    }
}
