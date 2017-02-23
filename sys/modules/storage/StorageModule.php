<?php

namespace P3in;

use P3in\BaseModule;
use P3in\PublishFiles;

class StorageModule extends BaseModule
{
    public $module_name = 'storage';

    protected $publishes = [
    ];

    public function __construct()
    {
        // \Log::info('Loading <Storage> Module');
    }

    public function bootstrap()
    {
        \Log::info('Bootstrapping <Storage> Module');
    }

    public function register()
    {
        \Log::info('Registering <Storage> Module');
    }
}
