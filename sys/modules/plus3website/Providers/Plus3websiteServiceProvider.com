<?php

namespace P3in\Providers;

use Illuminate\Contracts\Auth\Access\Gate;
use Illuminate\Support\ServiceProvider;

class Plus3websiteServiceProvider extends ServiceProvider
{
    public function boot(Gate $gate)
    {
    }

    public function register()
    {

    }
}
