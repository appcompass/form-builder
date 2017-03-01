<?php

namespace P3in\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Storage;
use League\Flysystem\Sftp\SftpAdapter;
use League\Flysystem\Filesystem;
use P3in\Models\StorageConfig;
use Route;

class DisksServiceProvider extends ServiceProvider
{
    public function boot()
    {
        Storage::extend('sftp', function ($app, $config) {
            $adapter = new SftpAdapter($config);

            return new Filesystem($adapter);
        });
    }

    public function register()
    {
        Route::bind('storage', function ($value) {
            return StorageConfig::findOrFail($value);
        });

        $this->app->bind(
            \P3in\Interfaces\DisksRepositoryInterface::class, \P3in\Repositories\DisksRepository::class
        );
    }
}
