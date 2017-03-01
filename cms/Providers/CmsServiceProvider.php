<?php

namespace P3in\Providers;

use Illuminate\Contracts\Auth\Access\Gate;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\ServiceProvider;
use Intervention\Image\Facades\Image;
use Intervention\Image\ImageServiceProvider;
use League\Flysystem\Filesystem;
use League\Flysystem\Sftp\SftpAdapter;
use P3in\Middleware\ValidateWebsite;
use P3in\Models\Field;
use P3in\Models\Gallery;
use P3in\Models\Group;
use P3in\Models\Menu;
use P3in\Models\Page;
use P3in\Models\PageSectionContent;
use P3in\Models\Permission;
use P3in\Models\Photo;
use P3in\Models\Redirect;
use P3in\Models\User;
use P3in\Models\Video;
use P3in\Models\Website;
use P3in\Observers\FieldObserver;
use Roumen\Sitemap\SitemapServiceProvider;
use Tymon\JWTAuth\Providers\LaravelServiceProvider;
// use Roumen\Feed\FeedServiceProvider;

class CmsServiceProvider extends ServiceProvider
{
    private $bind_to_route = [
        'user' => User::class,
        'permission' => Permission::class,
        'group' => Group::class,
        'gallery' => Gallery::class,
        'photo' => Photo::class,
        'video' => Video::class,
        'website' => Website::class,
        'redirect' => Redirect::class,
        'page' => Page::class,
        'content' => PageSectionContent::class,
        'section' => Section::class,
        'menu' => Menu::class,
    ];

    public function boot()
    {
        $this->extendStorage();

        $this->bindToRoute();

        $this->registerDependentPackages();
    }

    public function register()
    {

        foreach ([
            'P3in\Interfaces\GalleriesRepositoryInterface' => 'P3in\Repositories\GalleriesRepository',
            'P3in\Interfaces\GalleryPhotosRepositoryInterface' => 'P3in\Repositories\GalleryPhotosRepository',
            'P3in\Interfaces\GalleryVideosRepositoryInterface' => 'P3in\Repositories\GalleryVideosRepository',
            'P3in\Interfaces\UserPermissionsRepositoryInterface', 'P3in\Repositories\UserPermissionsRepository',
            'P3in\Interfaces\PermissionsRepositoryInterface', 'P3in\Repositories\PermissionsRepository',
            'P3in\Interfaces\UsersRepositoryInterface', 'P3in\Repositories\UsersRepository',
            'P3in\Interfaces\GroupsRepositoryInterface', 'P3in\Repositories\GroupsRepository',
            'P3in\Interfaces\UserGroupsRepositoryInterface', 'P3in\Repositories\UserGroupsRepository',
            'P3in\Interfaces\UserPermissionsRepositoryInterface', 'P3in\Repositories\UserPermissionsRepository',
            'P3in\Interfaces\PermissionsRepositoryInterface', 'P3in\Repositories\PermissionsRepository',
            'P3in\Interfaces\WebsitesRepositoryInterface' => 'P3in\Repositories\WebsitesRepository',
            'P3in\Interfaces\WebsitePagesRepositoryInterface' => 'P3in\Repositories\WebsitePagesRepository',
            'P3in\Interfaces\WebsiteRedirectsRepositoryInterface' => 'P3in\Repositories\WebsiteRedirectsRepository',
            'P3in\Interfaces\PageContentRepositoryInterface' => 'P3in\Repositories\PageContentRepository',
            'P3in\Interfaces\PagesRepositoryInterface' => 'P3in\Repositories\PagesRepository',
            'P3in\Interfaces\MenusRepositoryInterface' => 'P3in\Repositories\MenusRepository',
            'P3in\Interfaces\WebsiteMenusRepositoryInterface' => 'P3in\Repositories\WebsiteMenusRepository',
        ] as $interface => $val) {
            $this->app->bind(
                $interface, $val
            );
        }

        $this->app['router']->middleware('validateWebsite', ValidateWebsite::class);

        // @TODO: currently a mix of views and stubs. should be better organized/split.
        $this->app['view']->addNamespace('cms', realpath(__DIR__.'/../Templates'));


    }

    /**
     * Load Intervention for images handling
     */
    public function registerDependentPackages()
    {
        $this->app->register(SitemapServiceProvider::class);
        // $this->app->register(FeedServiceProvider::class);
        $this->app->register(ImageServiceProvider::class);
        $this->app->register(LaravelServiceProvider::class);

        $loader = AliasLoader::getInstance();

        $loader->alias('Image', Image::class);

        //@TODO: we require the use of imagick, not sure we should force this though.
        Config::set(['image' => ['driver' => 'imagick']]);
    }

    public function extendStorage()
    {
        Storage::extend('sftp', function ($app, $config) {
            $adapter = new SftpAdapter($config);

            return new Filesystem($adapter);
        });
    }

    private function bindToRoute()
    {
        // @TODO: sort out Route::bind vs. Route::model.
        foreach ($this->bind_to_route as $key => $model) {
            Route::bind($key, function ($value) use ($model) {
                return $model::findOrFail($value);
            });

            Route::model($key, $model);
        }
    }
}
