<?php

namespace P3in;

use P3in\BaseModule;

class Plus3websiteModule extends BaseModule
{
    public $module_name = 'plus3website';

    protected $publishesComponents = [
        // publishes to disk instances by name.
        'Public/' => 'plus3website',
    ];

    public function __construct()
    {
        // \Log::info('Loading <'.ucwords($this->module_name).'> Module');
    }

    public function bootstrap()
    {
        // \Log::info('Bootstrapping <'.ucwords($this->module_name).'> Module');
    }

    public function register()
    {
        // \Log::info('Registering <'.ucwords($this->module_name).'> Module');
        // @TODO load stuff here. like caching routes etc
        // $this->setSeeders();
    }
}
