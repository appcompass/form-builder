<?php

namespace P3in\Modules\Providers;

use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\Facades\Config;
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
            if (empty($value['ssh_host'])) {
                return false;
            }
            Config::set('remote.connections.production', [
                'host'      => $value['ssh_host'],
                'username'  => $value['ssh_username'],
                'key'       => $value['ssh_key'],
                'keyphrase' => $value['ssh_keyphrase'],
            ]);

            $counter = 0;

            // \SSH should work here but for what ever reason it's not so we're just using the full path.
            $test = \SSH::run([

                "cd {$value['ssh_root']}",
                "ls -a",

            ], function($line) use (&$counter) {
                if (!strpos($line, 'No such file or directory')) {
                    $counter++;
                }
            });

            if ($counter) {
                return true;
            }

            return false;
        });

        Validator::replacer('site_connection', function($message, $attribute, $rule, $parameters) {
            return 'Unable to establish a connection to the server with the provided information.';
        });

    }

    public function register()
    {

        $this->app->register(\Collective\Remote\RemoteServiceProvider::class);

        $loader = AliasLoader::getInstance();
        $loader->alias('SSH', \Collective\Remote\RemoteFacade::class);

    }

    public function provides()
    {
        //
    }
}