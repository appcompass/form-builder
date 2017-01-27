<?php

namespace P3in\Providers;

use Illuminate\Contracts\Auth\Access\Gate;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use P3in\Interfaces\MenusRepositoryInterface;
use P3in\Interfaces\PageContentsRepositoryInterface;
use P3in\Interfaces\PageSectionsRepositoryInterface;
use P3in\Interfaces\PagesRepositoryInterface;
use P3in\Interfaces\WebsiteMenusRepositoryInterface;
use P3in\Interfaces\WebsitePagesRepositoryInterface;
use P3in\Interfaces\WebsiteRedirectsRepositoryInterface;
use P3in\Interfaces\WebsiteSettingsRepositoryInterface;
use P3in\Interfaces\WebsitesRepositoryInterface;
use P3in\Middleware\ValidateWebsite;
use P3in\Models\Menu;
use P3in\Models\Page;
use P3in\Models\PageComponentContent;
use P3in\Models\Redirect;
// use P3in\Models\Section;
use P3in\Models\Setting;
use P3in\Models\Website;
use P3in\Repositories\MenusRepository;
use P3in\Repositories\PageContentsRepository;
use P3in\Repositories\PageSectionsRepository;
use P3in\Repositories\PagesRepository;
use P3in\Repositories\WebsiteMenusRepository;
use P3in\Repositories\WebsitePagesRepository;
use P3in\Repositories\WebsiteRedirectsRepository;
use P3in\Repositories\WebsiteSettingsRepository;
use P3in\Repositories\WebsitesRepository;
use Roumen\Sitemap\SitemapServiceProvider;
use Roumen\Feed\FeedServiceProvider;

class WebsitesServiceProvider extends ServiceProvider
{
    public function boot(Gate $gate)
    {
    }

    public function register()
    {
        $this->app['router']->middleware('validateWebsite', ValidateWebsite::class);

        $this->app['view']->addNamespace('websites', realpath(__DIR__.'/../Templates'));

        $this->app->register(SitemapServiceProvider::class);
        $this->app->register(FeedServiceProvider::class);

        // we shoudl prob make this a method that runs through $this->bindings
        foreach ([
            WebsitesRepositoryInterface::class => WebsitesRepository::class,
            WebsitePagesRepositoryInterface::class => WebsitePagesRepository::class,
            WebsiteRedirectsRepositoryInterface::class => WebsiteRedirectsRepository::class,
            WebsiteSettingsRepositoryInterface::class => WebsiteSettingsRepository::class,
            PageContentsRepositoryInterface::class => PageContentsRepository::class,
            PageSectionsRepositoryInterface::class => PageSectionsRepository::class,
            PagesRepositoryInterface::class => PagesRepository::class,
            MenusRepositoryInterface::class => MenusRepository::class,
            WebsiteMenusRepositoryInterface::class => WebsiteMenusRepository::class,
        ] as $interface => $repo) {
            $this->app->bind(
                $interface, $repo
            );
        }

        Route::model('websites', Website::class);
        Route::model('redirects', Redirect::class);
        Route::model('settings', Setting::class);
        Route::model('pages', Page::class);
        Route::model('contents', PageComponentContent::class);
        // Route::model('sections', Section::class);
        Route::model('menus', Menu::class);

        Route::bind('website', function ($value) {
            return Website::findOrFail($value);
        });

        Route::bind('redirect', function ($value) {
            return Redirect::findOrFail($value);
        });

        Route::bind('setting', function ($value) {
            return Setting::findOrFail($value);
        });

        Route::bind('page', function ($value) {
            return Page::findOrFail($value);
        });

        Route::bind('content', function ($value) {
            return PageComponentContent::findOrFail($value);
        });

        Route::bind('menu', function ($value) {
            return Menu::findOrFail($value);
        });
    }
}
