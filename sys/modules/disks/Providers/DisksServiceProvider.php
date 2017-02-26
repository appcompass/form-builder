<?php

namespace P3in\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Storage;
use League\Flysystem\Sftp\SftpAdapter;
use League\Flysystem\Filesystem;

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
        $this->app->bind(
            \P3in\Interfaces\DisksRepositoryInterface::class, \P3in\Repositories\DisksRepository::class
        );
    }
}
