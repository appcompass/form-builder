<?php

namespace P3in\Modules\Providers;

use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\ServiceProvider;

Class WebsitesServiceProvider extends ServiceProvider {

    public function boot()
    {
        // Register Middleware
        $kernel = $this->app->make('Illuminate\Contracts\Http\Kernel');
        $kernel->prependMiddleware('P3in\Modules\Middleware\ValidateAndSetWebsite');
    }

    public function register()
    {

        $this->app->register('Phaza\LaravelPostgis\DatabaseServiceProvider');

    }

    public function provides()
    {
        //
    }
}