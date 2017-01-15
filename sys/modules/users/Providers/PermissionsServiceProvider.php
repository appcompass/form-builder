<?php

namespace P3in\Providers;

use Illuminate\Contracts\Auth\Access\Gate;
use P3in\Providers\BaseServiceProvider as ServiceProvider;

class PermissionsServiceProvider extends ServiceProvider
{
    public function boot(Gate $gate)
    {
    }

    public function register()
    {
        $this->app->bind(
            \P3in\Interfaces\UserPermissionsRepositoryInterface::class, \P3in\Repositories\UserPermissionsRepository::class
        );
        $this->app->bind(
            \P3in\Interfaces\PermissionsRepositoryInterface::class, \P3in\Repositories\PermissionsRepository::class
        );
    }
}
