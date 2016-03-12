<?php

namespace P3in\Modules\Providers;

use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\ServiceProvider;
use P3in\Models\Videos;

class VideosServiceProvider extends ServiceProvider
{

    public function boot()
    {
        $loader = AliasLoader::getInstance();
        $loader->alias('Videos', Videos::class);

    }

    public function register()
    {
    }

    public function provides()
    {
        //
    }

}
