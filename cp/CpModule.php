<?php

namespace P3in;

use P3in\BaseModule;
use P3in\Models\Storage;
use P3in\PublishFiles;

class CpModule extends BaseModule
{
    public $module_name = 'cp';

    protected $publishes = [
        'Public/' => '../cp',
        'Models/templates/' => '../cp/src/components/FormBuilder',
    ];

    public function __construct()
    {
        // \Log::info('Loading <Cp> Module');
    }

    public function bootstrap()
    {
        \Log::info('Bootstrapping <Cp> Module');
    }

    public function register()
    {
        \Log::info('Registering <Cp> Module');
    }
}
