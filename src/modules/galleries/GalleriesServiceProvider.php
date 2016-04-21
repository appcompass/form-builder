<?php

namespace P3in\Modules\Providers;

use Illuminate\Contracts\Auth\Access\Gate;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider;
use Illuminate\Routing\Router;
use P3in\Models\Gallery;
use P3in\Models\User;
use P3in\Policies\GalleriesPolicy;
use P3in\Policies\ResourcesPolicy;
use P3in\Traits\HasGallery;

class GalleriesServiceProvider extends AuthServiceProvider
{


    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = true;

    /**`
     *
     *
     */
    protected $policies = [

        Gallery::class => ResourcesPolicy::class,

    ];

    /**
     *   Register bindings in the container
     *
     *
     *
     */
    public function register()
    {
    }

    /**
     * Bootstrap services
     *
     *
     *
     */
    public function boot(Gate $gate, Router $router)
    {

        $this->registerPolicies($gate);
        $loader = AliasLoader::getInstance();

        $router->model('galleries', Gallery::class);

        // $gate->define('create-galleries', function(User $user) {
        //     dd($user);
        // });

        // $this->registerPolicies($gate);

    }

    /**
     * Register the application's policies.
     *
     * @param  \Illuminate\Contracts\Auth\Access\Gate  $gate
     * @return void
     */
    // public function registerPolicies(Gate $gate)
    // {
    //     foreach ($this->policies as $key => $value) {
    //         $gate->policy($key, $value);
    //     }
    // }
}
