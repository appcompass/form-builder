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
     *
     */
    protected $policies = [

        Photo::class => PhotosPolicy::class,

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
