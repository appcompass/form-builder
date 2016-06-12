<?php

namespace P3in\Modules\Providers;

use Illuminate\Contracts\Auth\Access\Gate;
use Illuminate\Foundation\AliasLoader;
use P3in\Providers\BaseServiceProvider as ServiceProvider;
use Illuminate\Routing\Router;
use P3in\Models\Gallery;
use P3in\Models\User;
use P3in\Policies\GalleriesPolicy;
use P3in\Policies\ResourcesPolicy;
use P3in\Traits\HasGallery;

class GalleriesServiceProvider extends ServiceProvider
{

    /**`
     * Module's Policies
     *
     */
    protected $policies = [
        Gallery::class => ResourcesPolicy::class,
    ];

    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = true;


    /**
     *   Register bindings in the container
     *
     */
    public function register()
    {
    }

    /**
     * Bootstrap services
     *
     */
    public function boot(Router $router)
    {

        $router->model('galleries', Gallery::class);

    }

}
