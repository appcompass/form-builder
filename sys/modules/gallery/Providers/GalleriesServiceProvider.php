<?php

namespace P3in\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Auth\Access\Gate;

class GalleriesServiceProvider extends ServiceProvider
{
    public function boot(Gate $gate)
    {
        \Log::info('booting <Galleries> module');
    }

    public function register()
    {
        $this->app->bind(
            \P3in\Interfaces\GalleriesRepositoryInterface::class, \P3in\Repositories\GalleriesRepository::class
        );

        \Route::bind('gallery', function($value) {
            return \P3in\Models\Gallery::findOrFail($value);
        });

    }
}