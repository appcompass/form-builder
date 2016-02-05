<?php

namespace P3in\Modules\Providers;

use Illuminate\Contracts\Auth\Access\Gate;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider;
use Illuminate\Support\ServiceProvider;
use P3in\Controllers\CpGalleriesController;
use P3in\Models\Gallery;
use P3in\Models\User;
use P3in\Policies\GalleriesPolicy;
use P3in\Traits\HasGallery;

class GalleriesServiceProvider extends ServiceProvider
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

        Gallery::class => ControllersPolicy::class,
        // CpGalleriesController::class => GalleriesPolicy::class
        // "P3in\Models\Gallery" => "P3in\Policies\GalleriesPolicy"

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
    public function boot(Gate $gate)
    {

        $loader = AliasLoader::getInstance();

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
    public function registerPolicies(Gate $gate)
    {
        foreach ($this->policies as $key => $value) {
            $gate->policy($key, $value);
        }
    }
}