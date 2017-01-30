<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        \DB::listen(function($query) { \Log::info($query->sql, $query->bindings); });
        \DB::listen(function($query) { \Log::info($query->time); });

        $this->app->bind('path.public', function () {
            return base_path() . '/../public/src';
        });

        $this->app->bind('path.components', function () {
            return base_path() . '/../cp/src/components';
        });

        $this->app->bind('path.websites', function () {
            return base_path() . '/../cp/src/websites';
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
