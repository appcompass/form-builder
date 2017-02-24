<?php

namespace P3in\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Storage;
use League\Flysystem\Sftp\SftpAdapter;
use League\Flysystem\Filesystem;
use P3in\Observers\FieldObserver;
use P3in\Models\Field;

class CpServiceProvider extends ServiceProvider
{
    public function boot()
    {
        \Log::info('Booting CP Module');

        Storage::extend('sftp', function ($app, $config) {
            $adapter = new SftpAdapter($config);

            return new Filesystem($adapter);
        });

    	Field::observe(FieldObserver::class);
    }

    public function register()
    {
        // $this->app->bind(
            // \P3in\Interfaces\StorageRepositoryInterface::class, \P3in\Repositories\StorageRepository::class
        // );
    }
}
