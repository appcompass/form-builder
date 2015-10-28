<?php

namespace P3in\Modules\Providers;

use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\ServiceProvider;

Class UiServiceProvider extends ServiceProvider
{
    public function boot()
    {
        //
    }

    public function register()
    {

        $this->app->register('Collective\Html\HtmlServiceProvider');

    }

    public function provides()
    {
        //
    }
}