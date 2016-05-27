<?php

namespace P3in\Modules\Providers;

use Illuminate\Contracts\Auth\Access\Gate;
use Illuminate\Foundation\AliasLoader;
use P3in\Providers\BaseServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Validator;
use P3in\Commands\AddUserCommand;
use P3in\Models\Group;
use P3in\Models\User;
use P3in\Policies\ControllersPolicy;
use P3in\Policies\ResourcesPolicy;
use P3in\Profiles\Profile;

Class UsersServiceProvider extends ServiceProvider {

    protected $policies = [
        User::class => ResourcesPolicy::class,
        Group::class => ResourcesPolicy::class,
    ];

    protected $commands = [
        AddUserCommand::class,
    ];

    /**
     * Subscribe
     */
    protected $subscribe = [
        // example:
        // '\P3in\Observers\AlertObserver'
        // method being hit: subscribe()
        //      subscribe() returns a key-value pair of event -> class@method
        //      $events->listen('Illuminate\Auth\Events\Login', '\P3in\Observers\AlertObserver@userLogin');
    ];

    /**
     *  Listen
     */
    protected $listen = [
        // example:
        // 'Illuminate\Auth\Events\Login' => [
        //     \P3in\Observers\AlertObserver::class
        // ],
        // method being hit: handle()
    ];

    /**
     * Observe
     */
    protected $observe = [
        // example:
        // \P3in\Observers\AlertObserver::class => [
            // Photo::class
        // ]
        // method being hit: depends on Model event (created(), deleted(), etc...)
    ];

    public function boot(Gate $gate)
    {
        $this->commands($this->commands);

        // we clear the profile cache when the Profile Model either saves to, or deletes from it's records.
        $clearCache = function($profile){
            Cache::forget('profile_types');
        };

        Profile::saved($clearCache);
        Profile::deleted($clearCache);
    }

    public function register()
    {

    }

}
