<?php

namespace P3in;

use P3in\BaseModule;

class BlogModule extends BaseModule
{
    public $module_name = 'blog';

    public function __construct()
    {
        \Log::info('Loading <Blog> Module');
    }

    public function register()
    {
        \Log::info('Registering <Blog> Module');
    }

    public function bootstrap()
    {
        \Log::info('Boostrapping <Blog> Module');
    }
}
