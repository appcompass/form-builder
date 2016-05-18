<?php

namespace P3in\Modules\Providers;

use Illuminate\Contracts\Auth\Access\Gate;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Config;
use Intervention\Image\Facades\Image;
use Intervention\Image\ImageServiceProvider;
use P3in\Models\Photo;
use P3in\Policies\PhotosPolicy;

class PhotosServiceProvider extends AuthServiceProvider
{
    protected $policies = [
        Photo::class => PhotosPolicy::class,
    ];

    public function boot(Gate $gate, Router $router)
    {
        $this->registerPolicies($gate);

        $loader = AliasLoader::getInstance();
        $loader->alias('Photo', Photo::class);

        // $router->model('photos', Photo::class);
        // Intervetion
        $this->app->register(ImageServiceProvider::class);
        $loader->alias('Image', Image::class);

        Config::set(['image' => ['driver' => 'imagick']]);
    }

    public function register()
    {
    }

    public function provides()
    {
        //
    }

}
