<?php

namespace P3in\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use P3in\Builders\FormBuilder;
use P3in\Builders\WebsiteBuilder;
use P3in\Models\FieldSource;
use P3in\Models\Resource;
use P3in\Models\Section;

class WebsitesSeeder extends Seeder
{
    public function run()
    {

        WebsiteBuilder::new(env('ADMIN_WEBSITE_NAME'), env('ADMIN_WEBSITE_SCHEME'), env('ADMIN_WEBSITE_HOST'), function ($websiteBuilder) {
            $websiteBuilder->setStorage('cp_root');

            $dashboard = Resource::byRoute('cp-dashboard');

            $users = Resource::byRoute('users.index');
            $user = Resource::byRoute('users.show');
            $user_profile = Resource::byRoute('users.edit');
            $create_user = Resource::byRoute('users.create');
            $user_roles = Resource::byRoute('users.roles.index');
            $user_permissions = Resource::byRoute('users.permissions.index');

            $permissions = Resource::byRoute('permissions.index');
            $permission = Resource::byRoute('permissions.show');
            $permission_info = Resource::byRoute('permissions.edit');
            $create_permission = Resource::byRoute('permissions.create');

            $roles = Resource::byRoute('roles.index');
            $role = Resource::byRoute('roles.show');
            $role_info = Resource::byRoute('roles.edit');
            $create_role = Resource::byRoute('roles.create');
            $role_permissions = Resource::byRoute('roles.permissions.index');


            $resources = Resource::byRoute('resources.index');
            $resource = Resource::byRoute('resources.show');
            $resource_info = Resource::byRoute('resources.edit');

            $websites = Resource::byRoute('websites.index');
            $create_website = Resource::byRoute('websites.create');
            $website = Resource::byRoute('websites.show');
            $website_setup = Resource::byRoute('websites-setup');
            $website_settings = Resource::byRoute('websites.edit');
            $website_layouts = Resource::byRoute('websites.layouts.index');
            $website_layout = Resource::byRoute('websites.layouts.show');
            $website_layout_builder = Resource::byRoute('websites.layouts.edit');
            $navigations = Resource::byRoute('websites.menus.index');
            $navigation = Resource::byRoute('websites.menus.show');
            $navigation_builder = Resource::byRoute('websites.menus.edit');

            $pages = Resource::byRoute('websites.pages.index');
            $create_page = Resource::byRoute('websites.pages.create');
            $page = Resource::byRoute('websites.pages.show');

            $redirects = Resource::byRoute('websites.redirects.index');

            $galleries = Resource::byRoute('galleries.index');
            $gallery = Resource::byRoute('galleries.show');
            $gallery_info = Resource::byRoute('galleries.edit');
            $gallery_photos = Resource::byRoute('galleries.photos.index');
            $gallery_videos = Resource::byRoute('galleries.videos.index');

            // @TODO: storage workflow needs to be looked at a bit.
            $storages = Resource::byRoute('disks.index');
            $create_storage = Resource::byRoute('disks.create');
            $storage = Resource::byRoute('disks.show');
            $storage_info = Resource::byRoute('disks.edit');

            $forms = Resource::byRoute('forms.index');
            $create_forms = Resource::byRoute('forms.create');
            $form = Resource::byRoute('forms.show');
            $form_info = Resource::byRoute('forms.edit');
            // @TODO: form submissions?

            $websiteBuilder->addMenu('user_nav')
                ->add(['title' => 'Profile', 'url' => '/users/:current_user_id', 'alt' => 'Profile'], 1)->icon('user');

            $websiteBuilder->addMenu('main_nav')
                ->add($dashboard, 1)
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
