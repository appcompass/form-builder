<?php

namespace P3in\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Storage;
use League\Flysystem\Sftp\SftpAdapter;
use Illuminate\Support\Facades\Route;
use League\Flysystem\Filesystem;
use P3in\Observers\FieldObserver;
use P3in\Models\Field;
use Illuminate\Contracts\Auth\Access\Gate;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\Facades\Config;
use Intervention\Image\Facades\Image;
use Intervention\Image\ImageServiceProvider;
use P3in\Interfaces\GalleriesRepositoryInterface;
use P3in\Interfaces\GalleryPhotosRepositoryInterface;
use P3in\Interfaces\GalleryVideosRepositoryInterface;
use P3in\Models\Gallery;
use P3in\Models\Photo;
use P3in\Models\Video;
use P3in\Repositories\GalleriesRepository;
use P3in\Repositories\GalleryPhotosRepository;
use P3in\Repositories\GalleryVideosRepository;
use P3in\Middleware\ValidateWebsite;
use P3in\Models\Menu;
use P3in\Models\Page;
use P3in\Models\PageSectionContent;
use P3in\Models\Redirect;
use P3in\Models\Website;
use Roumen\Sitemap\SitemapServiceProvider;
// use Roumen\Feed\FeedServiceProvider;

class CmsServiceProvider extends ServiceProvider
{
    public function boot()
    {
        Storage::extend('sftp', function ($app, $config) {
            $adapter = new SftpAdapter($config);

            return new Filesystem($adapter);
        });

        Route::bind('user', function ($value) {
            return \P3in\Models\User::findOrFail($value);
        });

        Route::bind('permission', function ($value) {
            return \P3in\Models\Permission::findOrFail($value);
        });

        Route::bind('group', function ($value) {
            return \P3in\Models\Group::findOrFail($value);
        });

        $this->loadIntervention();

        Route::model('gallery', Gallery::class);
        Route::model('photo', Photo::class);
        Route::model('video', Video::class);

        Route::bind('gallery', function ($value) {
            return Gallery::findOrFail($value);
        });

        Route::bind('photo', function ($value) {
            return Photo::findOrFail($value);
        });

        Route::bind('video', function ($value) {
            return Video::findOrFail($value);
        });


        Route::model('websites', Website::class);
        Route::model('redirects', Redirect::class);
        // Route::model('settings', Setting::class);
        Route::model('pages', Page::class);
        Route::model('contents', PageSectionContent::class);
        // Route::model('sections', Section::class);
        Route::model('menus', Menu::class);

        Route::bind('website', function ($value) {
            return Website::findOrFail($value);
        });

        Route::bind('redirect', function ($value) {
            return Redirect::findOrFail($value);
        });

        // Route::bind('setting', function ($value) {
        //     return Setting::findOrFail($value);
        // });

        Route::bind('page', function ($value) {
            return Page::findOrFail($value);
        });

        Route::bind('content', function ($value) {
            return PageSectionContent::findOrFail($value);
        });

        Route::bind('menu', function ($value) {
            return Menu::findOrFail($value);
        });
    }

    public function register()
    {
        //@TODO: break this up now that it's one loader.
        $this->app->bind(
            \P3in\Interfaces\UserPermissionsRepositoryInterface::class, \P3in\Repositories\UserPermissionsRepository::class
        );
        $this->app->bind(
            \P3in\Interfaces\PermissionsRepositoryInterface::class, \P3in\Repositories\PermissionsRepository::class
        );

        $this->app->bind(
            \P3in\Interfaces\UsersRepositoryInterface::class, \P3in\Repositories\UsersRepository::class
        );

        $this->app->bind(
            \P3in\Interfaces\GroupsRepositoryInterface::class, \P3in\Repositories\GroupsRepository::class
        );

        $this->app->bind(
            \P3in\Interfaces\UserGroupsRepositoryInterface::class, \P3in\Repositories\UserGroupsRepository::class
        );

        $this->app->bind(
            \P3in\Interfaces\UserPermissionsRepositoryInterface::class, \P3in\Repositories\UserPermissionsRepository::class
        );

        $this->app->bind(
            \P3in\Interfaces\PermissionsRepositoryInterface::class, \P3in\Repositories\PermissionsRepository::class
        );

        $this->app->register(\Tymon\JWTAuth\Providers\LaravelServiceProvider::class);
        // $this->app->bind(
            // \P3in\Interfaces\StorageRepositoryInterface::class, \P3in\Repositories\StorageRepository::class
        // );

        foreach ([
            GalleriesRepositoryInterface::class => GalleriesRepository::class,
            GalleryPhotosRepositoryInterface::class => GalleryPhotosRepository::class,
            GalleryVideosRepositoryInterface::class => GalleryVideosRepository::class,
        ] as $key => $val) {
            $this->app->bind(
                $key, $val
            );
        }

        $this->app['router']->middleware('validateWebsite', ValidateWebsite::class);

        $this->app['view']->addNamespace('websites', realpath(__DIR__.'/../Templates'));

        $this->app->register(SitemapServiceProvider::class);
        // $this->app->register(FeedServiceProvider::class);

        foreach ([
            'P3in\Interfaces\WebsitesRepositoryInterface' => 'P3in\Repositories\WebsitesRepository',
            'P3in\Interfaces\WebsitePagesRepositoryInterface' => 'P3in\Repositories\WebsitePagesRepository',
            'P3in\Interfaces\WebsiteRedirectsRepositoryInterface' => 'P3in\Repositories\WebsiteRedirectsRepository',
            'P3in\Interfaces\PageContentRepositoryInterface' => 'P3in\Repositories\PageContentRepository',
            'P3in\Interfaces\PagesRepositoryInterface' => 'P3in\Repositories\PagesRepository',
            'P3in\Interfaces\MenusRepositoryInterface' => 'P3in\Repositories\MenusRepository',
            'P3in\Interfaces\WebsiteMenusRepositoryInterface' => 'P3in\Repositories\WebsiteMenusRepository',
        ] as $interface => $repo) {
            $this->app->bind(
                $interface, $repo
            );
        }
    }

    /**
     * Load Intervention for images handling
     */
    public function loadIntervention()
    {
        $this->app->register(ImageServiceProvider::class);

        $loader = AliasLoader::getInstance();

        $loader->alias('Image', Image::class);

        //@TODO: we require the use of imagick, not sure we should force this though.
        Config::set(['image' => ['driver' => 'imagick']]);
    }

}
