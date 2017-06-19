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

            $mediaEditor = $websiteBuilder->addSection([
                'name' => 'Media Editor',
                'template' => 'MediaEditor',
                'type' => 'section'
            ]);

            $login = $websiteBuilder->addPage('Login', 'login')->addSection($loginSection)->layout('Public');
            $register = $websiteBuilder->addPage('Register', 'register')->addSection($registerSection)->layout('Public');
            $passwordEmail = $websiteBuilder->addPage('Request Password Reset', 'request-password-reset')->addSection($passwordEmailSection)->layout('Public');
            $passwordReset = $websiteBuilder->addPage('Reset Password', 'reset-password', true)->addSection($passwordResetSection)->layout('Public');
            $home = $websiteBuilder->addPage('Dashbaord', 'dashboard')->addSection($homeSection)->layout('Private')->requiresAuth();

            $users = $websiteBuilder->addPage('Users', 'users')->addSection($list)->layout('Private')->requiresAuth()->resource('users.index');
            $create_user = $websiteBuilder->addPage('Create', 'users/create')->addSection($create)->layout('Private')->requiresAuth()->resource('users.create');
            $user = $websiteBuilder->addPage('User', 'users', true)->addSection($edit)->layout('Private')->requiresAuth()->resource('users.show');
            $user_profile = $user->addChild('Profile', '')->addSection($edit)->layout('Private')->requiresAuth()->resource('users.edit');
            $user_roles = $user->addChild('Roles', 'roles')->addSection($list)->layout('Private')->requiresAuth()->resource('users.roles.index');

            $roles = $websiteBuilder->addPage('Roles', 'roles')->addSection($list)->layout('Private')->requiresAuth()->resource('roles.index');
            $create_role = $websiteBuilder->addPage('Create', 'roles/create')->addSection($create)->layout('Private')->requiresAuth()->resource('roles.create');
            $role = $websiteBuilder->addPage('Role', 'roles', true)->addSection($edit)->layout('Private')->requiresAuth()->resource('roles.show');
            $role_info = $role->addChild('Info', '')->addSection($edit)->layout('Private')->requiresAuth()->resource('roles.edit');
            $role_permissions = $role->addChild('Permissions', 'permissions')->addSection($list)->layout('Private')->requiresAuth()->resource('roles.permissions.index');

            $permissions = $websiteBuilder->addPage('Permissions', 'permissions')->addSection($list)->layout('Private')->requiresAuth()->resource('permissions.index');
            $create_permission = $websiteBuilder->addPage('Create', 'permissions/create')->addSection($create)->layout('Private')->requiresAuth()->resource('permissions.create');
            $permission = $websiteBuilder->addPage('Permission', 'permissions', true)->addSection($edit)->layout('Private')->requiresAuth()->resource('permissions.show');
            $permission_info = $permission->addChild('Info', '')->addSection($edit)->layout('Private')->requiresAuth()->resource('permissions.edit');

            $resources = $websiteBuilder->addPage('Resources', 'resources')->addSection($list)->layout('Private')->requiresAuth()->resource('resources.index');
            $resource = $websiteBuilder->addPage('Resource', 'resources', true)->addSection($edit)->layout('Private')->requiresAuth()->resource('resources.show');
            $resource_info = $resource->addChild('Info', '')->addSection($edit)->layout('Private')->requiresAuth()->resource('resources.edit');

            $websites = $websiteBuilder->addPage('Websites', 'websites')->addSection($list)->layout('Private')->requiresAuth()->resource('websites.index');
            $create_website = $websiteBuilder->addPage('Create', 'websites/create')->addSection($create)->layout('Private')->requiresAuth()->resource('websites.create');
            $website = $websiteBuilder->addPage('Website', 'websites', true)->addSection($edit)->layout('Private')->requiresAuth()->resource('websites.show');
            $website_setup = $website->addChild('Setup', 'setup')->addSection($edit)->layout('Private')->requiresAuth()->resource('websites-setup');
            $website_settings = $website->addChild('Settings', '')->addSection($edit)->layout('Private')->requiresAuth()->resource('websites.edit');
            $website_layouts = $website->addChild('Layouts', 'layouts')->addSection($list)->layout('Private')->requiresAuth()->resource('websites.layouts.index');
            $website_layout = $website->addChild('Layout', 'layouts', true)->addSection($edit)->layout('Private')->requiresAuth()->resource('websites.layouts.show');
            $website_layout_builder = $website_layout->addChild('Builder', '')->addSection($pageEditor)->layout('Private')->requiresAuth()->resource('websites.layouts.edit');
            $navigations = $website->addChild('Menus', 'menus')->addSection($list)->layout('Private')->requiresAuth()->resource('websites.menus.index');
            $navigation = $website->addChild('Menu', 'menus', true)->addSection($edit)->layout('Private')->requiresAuth()->resource('websites.menus.show');
            $navigation_builder = $navigation->addChild('Editor', '')->addSection($edit)->layout('Private')->requiresAuth()->resource('websites.menus.edit');

            $pages = $website->addChild('Pages', 'pages')->addSection($list)->layout('Private')->requiresAuth()->resource('websites.pages.index');
            $create_page = $website->addChild('Create', 'pages/create')->addSection($pageEditor)->layout('FullScreen')->resource('websites.pages.create');
            $page = $website->addChild('Page', 'pages', true)->addSection($pageEditor)->layout('FullScreen')->resource('websites.pages.show');
            // $page_info = $page->addChild('Info', '')->addSection($pageEditor)->layout('FullScreen')->resource('websites.pages.edit');
            // $page_layouts = $page->addChild('Layout', 'layout')->addSection($pageEditor)->layout('FullScreen')->resource('pages.contents.index');
            // $page_contents = $page->addChild('Content', 'contents')->addSection($pageEditor)->layout('FullScreen')->resource('pages.contents.show');
            // // @TODO: work out the flow of blog.
            // $blogEntries = $website->addChild('Blog Entries', 'blog-entries')->addSection($list)->layout('Private')->requiresAuth()->resource('websites.blog-entries.index');
            // $blogCategories = $website->addChild('Blog Categories', 'blog-categories')->addSection($list)->layout('Private')->requiresAuth()->resource('websites.blog-categories.index');
            // $blogTags = $website->addChild('Blog Tags', 'blog-tags')->addSection($list)->layout('Private')->requiresAuth()->resource('websites.blog-tags.index');

            $redirects = $website->addChild('Redirects', 'redirects')->addSection($list)->layout('Private')->requiresAuth()->resource('websites.redirects.index');

            $galleries = $websiteBuilder->addPage('Galleries', 'galleries')->addSection($list)->layout('Private')->requiresAuth()->resource('galleries.index');
            $gallery = $websiteBuilder->addPage('Gallery', 'galleries', true)->addSection($edit)->layout('Private')->requiresAuth()->resource('galleries.show');
            $gallery_info = $gallery->addChild('Info', '')->addSection($edit)->layout('Private')->requiresAuth()->resource('galleries.edit');
            $gallery_photos = $gallery->addChild('Photos', 'photos')->addSection($mediaEditor)->layout('Private')->requiresAuth()->resource('galleries.photos.index');
            $gallery_videos = $gallery->addChild('Videos', 'videos')->addSection($list)->layout('Private')->requiresAuth()->resource('galleries.videos.index');

            // @TODO: storage workflow needs to be looked at a bit.
            $storages = $websiteBuilder->addPage('Storage', 'storage')->addSection($list)->layout('Private')->requiresAuth()->resource('disks.index');
            $create_storage = $websiteBuilder->addPage('Create', 'storage/create')->addSection($create)->layout('Private')->requiresAuth()->resource('disks.create');
            $storage = $websiteBuilder->addPage('Storage', 'storages', true)->addSection($edit)->layout('Private')->requiresAuth()->resource('disks.show');
            $storage_info = $storage->addChild('Info', '')->addSection($edit)->layout('Private')->requiresAuth()->resource('disks.edit');

            $forms = $websiteBuilder->addPage('Forms', 'forms')->addSection($list)->layout('Private')->requiresAuth()->resource('forms.index');
            $create_forms = $websiteBuilder->addPage('Create', 'forms/create')->addSection($create)->layout('Private')->requiresAuth()->resource('forms.create');
            $form = $websiteBuilder->addPage('Form', 'forms', true)->addSection($edit)->layout('Private')->requiresAuth()->resource('forms.show');
            $form_info = $form->addChild('Info', '')->addSection($edit)->layout('Private')->requiresAuth()->resource('forms.edit');
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
