<?php

namespace P3in\Seeders;

use Illuminate\Database\Seeder;
use P3in\Models\Resource;

class ResourcesSeeder extends Seeder
{
    public function run()
    {
        Resource::build('cp-dashboard')->setLayout('Private')->setComponent('Home')->setTitle('Dashbaord')->setPermission('cp_login')->requiresAuth();

        Resource::build('users.index')->setLayout('Private')->setComponent('List')->setTitle('Users')->setPermission('users_admin')->requiresAuth();
        Resource::build('users.show')->setLayout('Private')->setComponent('Edit')->setTitle('User')->setPermission('users_admin')->requiresAuth();
        Resource::build('users.edit')->setLayout('Private')->setComponent('Edit')->setTitle('Profile')->setPermission('users_admin')->requiresAuth();
        Resource::build('users.create')->setLayout('Private')->setComponent('Create')->setTitle('Create')->setPermission('users_admin')->requiresAuth();

        Resource::build('users.roles.index')->setLayout('Private')->setComponent('List')->setTitle('Roles')->setPermission('users_admin')->requiresAuth();
        Resource::build('users.permissions.index')->setLayout('Private')->setComponent('List')->setTitle('Permissions')->setPermission('users_admin')->requiresAuth();

        Resource::build('permissions.index')->setLayout('Private')->setComponent('List')->setTitle('Permissions')->setPermission('permissions_admin')->requiresAuth();
        Resource::build('permissions.show')->setLayout('Private')->setComponent('Edit')->setTitle('Permission')->setPermission('permissions_admin')->requiresAuth();
        Resource::build('permissions.edit')->setLayout('Private')->setComponent('Edit')->setTitle('Info')->setPermission('permissions_admin')->requiresAuth();
        Resource::build('permissions.create')->setLayout('Private')->setComponent('Create')->setTitle('Create')->setPermission('permissions_admin')->requiresAuth();

        Resource::build('roles.index')->setLayout('Private')->setComponent('List')->setTitle('Roles')->setPermission('permissions_admin')->requiresAuth();
        Resource::build('roles.show')->setLayout('Private')->setComponent('Edit')->setTitle('Role')->setPermission('permissions_admin')->requiresAuth();
        Resource::build('roles.edit')->setLayout('Private')->setComponent('Edit')->setTitle('Info')->setPermission('permissions_admin')->requiresAuth();
        Resource::build('roles.create')->setLayout('Private')->setComponent('Create')->setTitle('Create')->setPermission('permissions_admin')->requiresAuth();
        Resource::build('roles.permissions.index')->setLayout('Private')->setComponent('List')->setTitle('Permissions')->setPermission('permissions_admin')->requiresAuth();

        Resource::build('resources.index')->setLayout('Private')->setComponent('List')->setTitle('Resources')->setPermission('resources_admin')->requiresAuth();
        Resource::build('resources.show')->setLayout('Private')->setComponent('Edit')->setTitle('Resource')->setPermission('resources_admin')->requiresAuth();
        Resource::build('resources.edit')->setLayout('Private')->setComponent('Edit')->setTitle('Info')->setPermission('resources_admin')->requiresAuth();
        Resource::build('resources.create')->setLayout('Private')->setComponent('Create')->setTitle('Create')->setPermission('resources_admin')->requiresAuth();

        Resource::build('websites.index')->setLayout('Private')->setComponent('List')->setTitle('Websites')->setPermission('websites_admin_view')->requiresAuth();
        Resource::build('websites.show')->setLayout('Private')->setComponent('Edit')->setTitle('Website')->setPermission('websites_admin_view')->requiresAuth();
        Resource::build('websites.edit')->setLayout('Private')->setComponent('Edit')->setTitle('Settings')->setPermission('websites_admin_create')->requiresAuth();
        Resource::build('websites.create')->setLayout('Private')->setComponent('Create')->setTitle('Create')->setPermission('websites_admin_create')->requiresAuth();
        Resource::build('websites-setup')->setLayout('Private')->setComponent('Create')->setTitle('Setup')->setPermission('websites_admin_create')->requiresAuth();
        Resource::build('websites.layouts.index')->setLayout('Private')->setComponent('List')->setTitle('Layouts')->setPermission('websites_layouts_admin')->requiresAuth();
        Resource::build('websites.layouts.create')->setLayout('FullScreen')->setComponent('WebsiteLayoutEditor')->setTitle('Create')->setPermission('websites_layouts_admin')->requiresAuth();
        Resource::build('websites.layouts.show')->setLayout('FullScreen')->setComponent('WebsiteLayoutEditor')->setTitle('Layout')->setPermission('websites_layouts_admin')->requiresAuth();
        Resource::build('websites.layouts.edit')->setLayout('FullScreen')->setComponent('WebsiteLayoutEditor')->setTitle('Builder')->setPermission('websites_layouts_admin')->requiresAuth();
        Resource::build('websites.menus.index')->setComponent('List')->setTitle('Menus')->setPermission('websites_menus_admin')->requiresAuth();
        Resource::build('websites.menus.show')->setComponent('Edit')->setTitle('Menu')->setPermission('websites_menus_admin')->requiresAuth();
        Resource::build('websites.menus.edit')->setComponent('Edit')->setTitle('Editor')->setPermission('websites_menus_admin')->requiresAuth();

        Resource::build('websites.pages.index')->setLayout('Private')->setComponent('List')->setTitle('Pages')->setPermission('websites_pages_admin')->requiresAuth();
        Resource::build('websites.pages.create')->setLayout('FullScreen')->setComponent('WebsitePageEditor')->setTitle('Create')->setPermission('websites_pages_admin')->requiresAuth();
        Resource::build('websites.pages.show')->setLayout('FullScreen')->setComponent('WebsitePageEditor')->setTitle('Page')->setPermission('websites_pages_admin')->requiresAuth();
        Resource::build('websites.pages.edit')->setLayout('FullScreen')->setComponent('WebsitePageEditor')->setTitle('Info')->setPermission('websites_pages_admin')->requiresAuth();
        Resource::build('pages.contents.index')->setLayout('FullScreen')->setComponent('WebsitePageEditor')->setTitle('Layout')->setPermission('websites_pages_admin')->requiresAuth();
        Resource::build('pages.contents.show')->setLayout('FullScreen')->setComponent('WebsitePageEditor')->setTitle('Content')->setPermission('websites_pages_admin')->requiresAuth();

        Resource::build('websites.redirects.index')->setLayout('Private')->setComponent('List')->setTitle('Redirects')->setPermission('websites_admin_create')->requiresAuth();

        Resource::build('galleries.index')->setLayout('Private')->setComponent('List')->setTitle('Galleries')->setPermission('media')->requiresAuth();
        Resource::build('galleries.show')->setLayout('Private')->setComponent('Edit')->setTitle('Gallery')->setPermission('media')->requiresAuth();
        Resource::build('galleries.edit')->setLayout('Private')->setComponent('Edit')->setTitle('Info')->setPermission('media')->requiresAuth();
        Resource::build('galleries.photos.index')->setLayout('Private')->setComponent('MediaEditor')->setTitle('Photos')->setPermission('media')->requiresAuth();
        Resource::build('galleries.videos.index')->setLayout('Private')->setComponent('MediaEditor')->setTitle('Videos')->setPermission('media')->requiresAuth();

        // @TODO: storage workflow needs to be looked at a bit.
        Resource::build('disks.index')->setLayout('Private')->setComponent('List')->setTitle('Storage')->setPermission('storage_admin')->requiresAuth();
        Resource::build('disks.create')->setLayout('Private')->setComponent('Create')->setTitle('Create')->setPermission('storage_admin')->requiresAuth();
        Resource::build('disks.show')->setLayout('Private')->setComponent('Edit')->setTitle('Storage')->setPermission('storage_admin')->requiresAuth();
        Resource::build('disks.edit')->setLayout('Private')->setComponent('Edit')->setTitle('Info')->setPermission('storage_admin')->requiresAuth();

        Resource::build('forms.index')->setLayout('Private')->setComponent('List')->setTitle('Forms')->setPermission('forms_admin')->requiresAuth();
        Resource::build('forms.create')->setLayout('Private')->setComponent('Create')->setTitle('Create')->setPermission('forms_admin')->requiresAuth();
        Resource::build('forms.show')->setLayout('Private')->setComponent('Edit')->setTitle('Form')->setPermission('forms_admin')->requiresAuth();
        Resource::build('forms.edit')->setLayout('Private')->setComponent('Edit')->setTitle('Info')->setPermission('forms_admin')->requiresAuth();
    }
}
