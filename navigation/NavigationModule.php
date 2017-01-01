<?php

namespace P3in;

use P3in\BaseModule;

class NavigationModule extends BaseModule
{
    public $module_name = 'navigation';

    public function __construct()
    {
        \Log::info('Loading <Navigation> Module');
    }

    public function register()
    {
        \Log::info('Registering <Navigation> Module');
    }

    public function bootstrap()
    {
        \Log::info('Boostrapping <Navigation> Module');
    }
}
