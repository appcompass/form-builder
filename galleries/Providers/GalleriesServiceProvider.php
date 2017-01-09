<?php

namespace P3in\Providers;

use Illuminate\Contracts\Auth\Access\Gate;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use P3in\Interfaces\GalleriesRepositoryInterface;
use P3in\Models\Gallery;
use P3in\Models\Photo;
use P3in\Repositories\GalleriesRepository;

class GalleriesServiceProvider extends ServiceProvider
{
    public function boot(Gate $gate)
    {
        \Log::info('booting <Galleries> module');
    }

    public function register()
    {
        $this->app->bind(
            GalleriesRepositoryInterface::class, GalleriesRepository::class
        );

        Route::model('galleries', Gallery::class);
        Route::model('photos', Photo::class);

        Route::bind('gallery', function($value) {
            return Gallery::findOrFail($value);
        });

        Route::bind('photo', function($value) {
            return Photo::findOrFail($value);
        });

    }
}