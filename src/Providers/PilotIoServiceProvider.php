<?php

namespace P3in\Providers;

use Illuminate\Contracts\Auth\Access\Gate;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use Intervention\Image\ImageServiceProvider;
use P3in\Models\Field;
use P3in\Models\Gallery;
use P3in\Models\GalleryItem;
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
use P3in\Observers\GalleryItemObserver;
use P3in\Observers\PageObserver;
use P3in\Providers\BaseServiceProvider;
use Roumen\Sitemap\SitemapServiceProvider;
use Tymon\JWTAuth\Providers\LaravelServiceProvider;

class PilotIoServiceProvider extends BaseServiceProvider
{
    // @TODO: Implement the other middleware types commented out here.
    /**
     * The application's global HTTP middleware stack.
     *
     * These middleware are run during every request to your application.
     *
     * @var array
     */
    // protected $middleware = [
    // ];

    /**
     * The application's route middleware groups.
     *
     * @var array
     */
    protected $middlewareGroups = [
        'web' => [
            \P3in\Middleware\ValidateWebsite::class,
        ],
        'auth' => [
            \Illuminate\Auth\Middleware\Authenticate::class,
            // 'jwt.refresh',
        ],
        'api' => [
            \P3in\Middleware\AfterRoute::class,
        ]
    ];

    // /**
    //  * The application's route middleware.
    //  *
    //  * These middleware may be assigned to groups or used individually.
    //  *
    //  * @var array
    //  */
    // protected $routeMiddleware = [
    //     // 'jwt.auth' => Tymon\JWTAuth\Middleware\GetUserFromToken::class,
    //     // 'jwt.refresh' => Tymon\JWTAuth\Middleware\RefreshToken::class,

    // ];

    protected $observe = [
        FieldObserver::class => Field::class,
        GalleryItemObserver::class => [
            Photo::class,
            Video::class
        ],
        // PhotoObserver::class => Photo::class, //@TODO: old but possibly needed for Alerts? look into it when we get to Alerts.
        PageObserver::class => Page::class,
    ];

    protected $bind = [
        \P3in\Interfaces\UsersRepositoryInterface::class => \P3in\Repositories\UsersRepository::class,
        \P3in\Interfaces\UserPermissionsRepositoryInterface::class => \P3in\Repositories\UserPermissionsRepository::class,
        \P3in\Interfaces\PermissionsRepositoryInterface::class => \P3in\Repositories\PermissionsRepository::class,
        \P3in\Interfaces\GroupsRepositoryInterface::class => \P3in\Repositories\GroupsRepository::class,
        \P3in\Interfaces\UserGroupsRepositoryInterface::class => \P3in\Repositories\UserGroupsRepository::class,
        \P3in\Interfaces\GalleriesRepositoryInterface::class => \P3in\Repositories\GalleriesRepository::class,
        \P3in\Interfaces\GalleryPhotosRepositoryInterface::class => \P3in\Repositories\GalleryPhotosRepository::class,
        \P3in\Interfaces\GalleryVideosRepositoryInterface::class => \P3in\Repositories\GalleryVideosRepository::class,
        \P3in\Interfaces\MenusRepositoryInterface::class => \P3in\Repositories\MenusRepository::class,
        \P3in\Interfaces\WebsitesRepositoryInterface::class => \P3in\Repositories\WebsitesRepository::class,
        \P3in\Interfaces\WebsiteRedirectsRepositoryInterface::class => \P3in\Repositories\WebsiteRedirectsRepository::class,
        \P3in\Interfaces\PagesRepositoryInterface::class => \P3in\Repositories\PagesRepository::class,
        \P3in\Interfaces\WebsitePagesRepositoryInterface::class => \P3in\Repositories\WebsitePagesRepository::class,
        \P3in\Interfaces\PageContentRepositoryInterface::class => \P3in\Repositories\PageContentRepository::class,
        \P3in\Interfaces\WebsiteMenusRepositoryInterface::class => \P3in\Repositories\WebsiteMenusRepository::class,
    ];

    public function boot()
    {
        $this->bindToRoute();
    }

    public function register()
    {
        $this->registerDependentPackages();

        // @TODO: currently a mix of views and stubs. should be better organized/split.
        $this->app['view']->addNamespace('pilot-io', realpath(__DIR__.'/../Templates'));
    }

    /**
     * Load Intervention for images handling
     */
    private function registerDependentPackages()
    {
        $this->app->register(SitemapServiceProvider::class);
        // $this->app->register(FeedServiceProvider::class);
        $this->app->register(ImageServiceProvider::class);
        $this->app->register(LaravelServiceProvider::class);

        $loader = AliasLoader::getInstance();

        $loader->alias('Image', Image::class);
        $loader->alias('User', User::class);
        $loader->alias('Menu', Menu::class);
        $loader->alias('Gallery', Gallery::class);

        //@TODO: we require the use of imagick, not sure we should force this though.
        Config::set(['image' => ['driver' => 'imagick']]);
    }

    // @TODO: once we figure out this functionality once and for all, we can move the method into BaseServiceProvider and just store the array here.
    public function bindToRoute()
    {
        // @TODO: sort out Route::bind vs. Route::model.
        foreach ([
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
        ] as $key => $model) {
            Route::bind($key, function ($value) use ($model) {
                return $model::findOrFail($value);
            });

            Route::model($key, $model);
        }
    }
}
