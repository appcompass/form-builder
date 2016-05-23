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

    public function provides()
    {
        //
    }
}
