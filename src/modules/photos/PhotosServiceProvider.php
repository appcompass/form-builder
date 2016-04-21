<?php

namespace P3in\Modules\Providers;

use Illuminate\Contracts\Auth\Access\Gate;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider;
use Intervention\Image\Facades\Image;
use Intervention\Image\ImageServiceProvider;
use P3in\Models\Photo;
use P3in\Policies\ResourcesPolicy;

class PhotosServiceProvider extends AuthServiceProvider
{
    protected $policies = [
        Photo::class => ResourcesPolicy::class,
    ];

    public function boot(Gate $gate)
    {
        $this->registerPolicies($gate);

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
