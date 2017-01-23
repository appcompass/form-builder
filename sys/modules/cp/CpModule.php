<?php

namespace P3in;

use P3in\BaseModule;

class CpModule extends BaseModule
{
    public $module_name = 'cp';

    protected $publishesComponents = [
        'Models/templates/' => '/FormBuilder',
    ];

    public function __construct()
    {
        // \Log::info('Loading <Cp> Module');
    }

    public function bootstrap()
    {
        // \Log::info('Bootstrapping <Cp> Module');
    }

    public function register()
    {
        // \Log::info('Registering <Cp> Module');
        // @TODO load stuff here. like caching routes etc
        // $this->setSeeders();
    }
}
