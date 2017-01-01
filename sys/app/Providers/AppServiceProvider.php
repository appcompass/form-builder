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
        // \DB::listen(function($query) { \Log::info($query->sql, $query->bindings); });
        // \DB::listen(function($query) { \Log::info($query->time); });

        $this->app->bind('path.public', function() {
            return base_path() . '/../public/src';
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
