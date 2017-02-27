<?php

namespace P3in\Providers;

use Illuminate\Contracts\Auth\Access\Gate;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use P3in\Middleware\ValidateWebsite;
use P3in\Models\Menu;
use P3in\Models\Page;
use P3in\Models\PageSectionContent;
use P3in\Models\Redirect;
use P3in\Models\Website;
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
}
