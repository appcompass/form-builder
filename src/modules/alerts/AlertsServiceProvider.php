<?php

namespace P3in\Modules\Providers;

use P3in\Providers\BaseServiceProvider as ServiceProvider;
use Illuminate\Contracts\Events\Dispatcher as DispatcherContract;
use Illuminate\Contracts\Auth\Access\Gate as GateContract;

Class AlertsServiceProvider extends ServiceProvider
{

    /**
     * Listeners
     *  this links an event (class) to a class that must implement a handle() method
     */
    protected $listen = [
        // 'Illuminate\Auth\Events\Login' => [
        //     P3in\Observers\AlertObserver::class
        // ]
    ];

    /**
     * Subscribe
     * list all the classes that contain a subscribe() method
     */
    protected $subscribe = [
        \P3in\Observers\AlertObserver::class
    ];

    public function boot()
    {

        // Register Auth Token routes
        // Add Auth Tokens controller -> add a new type to auth_tokens table and refresh the token on user login
        // link event listener to user login?

    }

    public function register()
    {
        $this->publishes([
            __DIR__.'/NodeJS/' => app_path('scripts')
        ], 'node-scripts');
    }

}