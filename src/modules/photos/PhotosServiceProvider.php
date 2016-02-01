<?php

namespace P3in\Modules\Providers;

use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\ServiceProvider;
use P3in\Models\Photo;

class PhotosServiceProvider extends ServiceProvider
{

    public function boot()
    {
        $loader = AliasLoader::getInstance();
        $loader->alias('Photo', Photo::class);
    }

    public function register()
    {
    }

    public function provides()
    {
        //
    }

}