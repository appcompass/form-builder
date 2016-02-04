<?php

namespace P3in\Modules\Providers;

use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;
use P3in\Models\Page;
use Roumen\Sitemap\SitemapServiceProvider;

Class PagesServiceProvider extends ServiceProvider {

    public function boot()
    {
        $this->app->register(SitemapServiceProvider::class);
    }

    public function register()
    {
        //
    }

    public function provides()
    {
        //
    }
}