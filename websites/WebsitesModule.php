<?php

namespace P3in;

use Modular;
use P3in\BaseModule;

Class WebsitesModule extends BaseModule
{
    public $module_name = 'websites';

    public function __construct()
    {
        \Log::info('Loading <Websites> Module');
    }

    public function bootstrap()
    {
        \Log::info('Boostrapping <Websites> Module');
    }

    public function register()
    {
        \Log::info('Registering <Websites> Module');
        // Profile::registerProfiles($this->profiles);
    }
}