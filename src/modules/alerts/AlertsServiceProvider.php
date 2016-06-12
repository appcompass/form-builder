<?php

namespace P3in\Modules\Providers;

use Illuminate\Contracts\Auth\Access\Gate as GateContract;
use Illuminate\Contracts\Events\Dispatcher as DispatcherContract;
use P3in\Observers\AlertObserver;
use P3in\Providers\BaseServiceProvider as ServiceProvider;

Class AlertsServiceProvider extends ServiceProvider
{
    //
    // EXAMPLE DOC
    //

    /**
     * Subscribe
     */
    // protected $subscribe = [
        // example:
        // '\P3in\Observers\AlertObserver'
        // method being hit: subscribe()
        //      subscribe() returns a key-value pair of event -> class@method
        //      $events->listen('Illuminate\Auth\Events\Login', '\P3in\Observers\AlertObserver@userLogin');
    // ];

    /**
     *  Listen
     */
    // protected $listen = [
        // example:
        // 'Illuminate\Auth\Events\Login' => [
        //     \P3in\Observers\AlertObserver::class
        // ],
        // method being hit: handle()
    // ];

    /**
     * Observe
     */
    // protected $observe = [
        // example:
        // \P3in\Observers\AlertObserver::class => [
            // Photo::class
        // ]
        // method being hit: depends on Model event (created(), deleted(), etc...)
    // ];


    /**
     * Listeners
     *  this links an event (class) to a class that must implement a handle() method
     */


    // END OF DOC

    protected $listen = [];
    protected $observe = [];

    /**
     * Subscribe
     * list all the classes that contain a subscribe() method
     */
    protected $subscribe = [
        AlertObserver::class
    ];

    public function boot() {}

    public function register()
    {
        $path = resource_path('node-scripts');

        $this->publishes([
            __DIR__.'/NodeJs/' => $path,
        ], 'node-scripts');

    }

    public function subscribe($events)
    {
    }

}