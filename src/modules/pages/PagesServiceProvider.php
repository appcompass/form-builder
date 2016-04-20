<?php

namespace P3in\Modules\Providers;

use Illuminate\Contracts\Auth\Access\Gate;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Validator;
use P3in\Models\Page;
use P3in\Policies\ControllersPolicy;
use Roumen\Sitemap\SitemapServiceProvider;

Class PagesServiceProvider extends AuthServiceProvider {

    protected $policies = [
        Page::class => ControllersPolicy::class,
    ];

    public function boot(Gate $gate)
    {
        $this->registerPolicies($gate);
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