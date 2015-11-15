<?php

namespace P3in\Modules\Providers;

use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;

Class WebsitesServiceProvider extends ServiceProvider {

    public function boot()
    {
        // Register Middleware
        $kernel = $this->app->make('Illuminate\Contracts\Http\Kernel');
        $kernel->prependMiddleware('P3in\Modules\Middleware\ValidateAndSetWebsite');

        // Register Website Validation
        Validator::extend('site_connection', function($attribute, $value, $parameters, $validator) {
            var_dump($value);

            // return true;
            // return false;
        });

        Validator::replacer('site_connection', function($message, $attribute, $rule, $parameters) {
            return 'Unable to establish a connection to the server with the provided data.';
        });

    }

    public function register()
    {

        $this->app->register(Collective\Remote\RemoteServiceProvider::class);

    }

    public function provides()
    {
        //
    }
}