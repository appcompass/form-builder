<?php

namespace P3in\Modules\Providers;

use Illuminate\Foundation\AliasLoader;
use Illuminate\Contracts\Auth\Access\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Validator;
use P3in\Commands\AddUserCommand;
use P3in\Models\Website;
use P3in\Policies\ControllersPolicy;

Class UsersServiceProvider extends AuthServiceProvider {

    protected $policies = [
        User::class => ControllersPolicy::class,
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
