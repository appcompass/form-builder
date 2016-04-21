<?php

namespace P3in\Modules\Providers;

use Illuminate\Contracts\Auth\Access\Gate;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Validator;
use P3in\Commands\AddUserCommand;
use P3in\Models\Group;
use P3in\Models\User;
use P3in\Policies\ControllersPolicy;
use P3in\Policies\ResourcesPolicy;

Class UsersServiceProvider extends AuthServiceProvider {

    protected $policies = [
        User::class => ResourcesPolicy::class,
        Group::class => ResourcesPolicy::class,
    ];

    protected $commands = [
        AddUserCommand::class,
    ];

    public function boot(Gate $gate)
    {
        $this->registerPolicies($gate);
        $this->commands($this->commands);
    }

    public function register()
    {

    }

    public function provides()
    {
        //
    }
}
