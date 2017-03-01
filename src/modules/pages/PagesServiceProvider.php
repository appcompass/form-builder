<?php

namespace P3in\Modules\Providers;

use Illuminate\Contracts\Auth\Access\Gate;
use Illuminate\Foundation\AliasLoader;
use P3in\Providers\BaseServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Validator;
use P3in\Models\Page;
use P3in\Policies\ResourcesPolicy;
use Roumen\Sitemap\SitemapServiceProvider;

Class PagesServiceProvider extends ServiceProvider {

    protected $policies = [
        Page::class => ResourcesPolicy::class,
    ];

    public function boot(Gate $gate)
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
