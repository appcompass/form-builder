<?php

namespace P3in\Modules\Providers;

use Illuminate\Contracts\Auth\Access\Gate;
use Illuminate\Foundation\AliasLoader;
use P3in\Providers\BaseServiceProvider as ServiceProvider;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Config;
use Intervention\Image\Facades\Image;
use Intervention\Image\ImageServiceProvider;
use P3in\Models\Photo;
use P3in\Policies\PhotosPolicy;

class PhotosServiceProvider extends ServiceProvider
{
    /**
     * Policies
     */
    protected $policies = [

        Photo::class => PhotosPolicy::class,

    ];

    /**
     * Listen
     */
    protected $listen = [];

    /**
     * Subscribe
     */
    protected $subscribe = [];

    /**
     * Observe
     */
    protected $observe = [
        // class watching (of which methods are being hit)
        \P3in\Observers\AlertObserver::class => [
            Photo::class,
            // additional models to be watched
        ]
    ];

    /**
     *
     */
    public function boot(Gate $gate, Router $router)
    {

        $this->loadIntervention();

        // Link delete event
        Photo::deleted(function ($photo) {

            $photo->galleryItem->delete();

        });

    }

    /**
     * Load Intervention for images handling
     */
    public function loadIntervention()
    {

        $this->app->register(ImageServiceProvider::class);

        $loader = AliasLoader::getInstance();

        $loader->alias('Image', Image::class);

        Config::set(['image' => ['driver' => 'imagick']]);

    }

    /**
     *
     */
    public function register() {}


}
