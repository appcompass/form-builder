<?php

namespace P3in\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Auth\Access\Gate;

class WebsitesServiceProvider extends ServiceProvider
{
    public function boot(Gate $gate)
    {
        \Log::info('booting <Websites> module');
    }

    public function register()
    {
        $this->app->bind(
            \P3in\Interfaces\WebsitesRepositoryInterface::class, \P3in\Repositories\WebsitesRepository::class
        );

        $this->app->bind(
            \P3in\Interfaces\WebsitePagesRepositoryInterface::class, \P3in\Repositories\WebsitePagesRepository::class
        );

        $this->app->bind(
            \P3in\Interfaces\PagesRepositoryInterface::class, \P3in\Repositories\PagesRepository::class
        );

        $this->app->bind(
            \P3in\Interfaces\MenusRepositoryInterface::class, \P3in\Repositories\MenusRepository::class
        );

        \Route::bind('website', function($value) {
            return \P3in\Models\Website::findOrFail($value);
        });

        \Route::bind('page', function($value) {
            return \P3in\Models\Page::findOrFail($value);
        });

        \Route::bind('menu', function($value) {
            return \P3in\Models\Menu::findOrFail($value);
        });

    }
}