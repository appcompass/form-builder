<?php

namespace P3in\Providers;

use Illuminate\Contracts\Auth\Access\Gate;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Intervention\Image\Facades\Image;
use Intervention\Image\ImageServiceProvider;
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
        $this->loadIntervention();

        Route::model('gallery', Gallery::class);
        Route::model('photo', Photo::class);
        Route::model('video', Video::class);

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
    }

    /**
     * Load Intervention for images handling
     */
    public function loadIntervention()
    {
        $this->app->register(ImageServiceProvider::class);

        $loader = AliasLoader::getInstance();

        $loader->alias('Image', Image::class);

        //@TODO: we require the use of imagick, not sure we should force this though.
        Config::set(['image' => ['driver' => 'imagick']]);
    }
}
