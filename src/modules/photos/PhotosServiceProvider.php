<?php

namespace P3in\Modules\Providers;

use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\ServiceProvider;
use Intervention\Image\Facades\Image;
use Intervention\Image\ImageServiceProvider;
use P3in\Models\Photo;

class PhotosServiceProvider extends ServiceProvider
{

    public function boot()
    {
        $loader = AliasLoader::getInstance();
        $loader->alias('Photo', Photo::class);

        // Intervetion
        $this->app->register(ImageServiceProvider::class);
        $loader->alias('Image', Image::class);
    }

    public function register()
    {
    }

    public function provides()
    {
        //
    }

}