<?php

namespace P3in\Modules\Providers;

use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;
use P3in\Commands\AddUserCommand;
use P3in\Models\Website;

Class UsersServiceProvider extends ServiceProvider {

    protected $commands = [
        AddUserCommand::class,
    ];

    public function boot()
    {
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
