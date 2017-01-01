<?php

namespace P3in;

use P3in\BaseModule;

class TestModule extends BaseModule
{
    public $module_name = 'test';

    public function __construct()
    {
        \Log::info('Loading <Test> Module');
    }

    public function register()
    {
        \Log::info('Registering <Test> Module');
    }

    public function bootstrap()
    {
        \Log::info('Boostrapping <Test> Module');
    }
}