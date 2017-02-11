<?php

namespace P3in\Providers;

use Illuminate\Contracts\Auth\Access\Gate;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use P3in\Interfaces\GalleriesRepositoryInterface;
use P3in\Interfaces\GalleryPhotosRepositoryInterface;
use P3in\Interfaces\GalleryVideosRepositoryInterface;
use P3in\Models\Gallery;
use P3in\Models\Photo;
use P3in\Models\Video;
use P3in\Repositories\GalleriesRepository;
use P3in\Repositories\GalleryPhotosRepository;
use P3in\Repositories\GalleryVideosRepository;

class GalleriesServiceProvider extends ServiceProvider
{
    public function boot(Gate $gate)
    {
    }

    public function register()
    {
        foreach ([
            GalleriesRepositoryInterface::class => GalleriesRepository::class,
            GalleryPhotosRepositoryInterface::class => GalleryPhotosRepository::class,
            GalleryVideosRepositoryInterface::class => GalleryVideosRepository::class,
        ] as $key => $val) {
            $this->app->bind(
                $key, $val
            );
        }

        Route::model('galleries', Gallery::class);
        Route::model('photos', Photo::class);
        Route::model('videos', Video::class);

        Route::bind('gallery', function ($value) {
            return Gallery::findOrFail($value);
        });

        Route::bind('photo', function ($value) {
            return Photo::findOrFail($value);
        });

        Route::bind('video', function ($value) {
            return Video::findOrFail($value);
        });
    }
}
