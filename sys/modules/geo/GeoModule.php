<?php

namespace P3in;

use P3in\BaseModule;

class GeoModule extends BaseModule
{
    public $module_name = "geo";

    public function __construct()
    {
        // \Log::info('Loading <Geo> Module');
    }

    public function bootstrap()
    {
        // \Log::info('Boostrapping <Geo> Module');
    }

    public function register()
    {
        // \Log::info('Registering <Geo> Module');
        // Profile::registerProfiles($this->profiles);
    }
}
