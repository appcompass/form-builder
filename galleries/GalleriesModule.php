<?php

namespace P3in;

use P3in\BaseModule;

class GalleriesModule extends BaseModule
{
    public $module_name = 'galleries';

    protected $publishes = [
        // publishes to disk instances by name.
        'Public/components/FormBuilder' => 'cp_form_fields',
    ];

    public function __construct()
    {
        // \Log::info('Loading <Galleries> Module');
    }

    public function register()
    {
        // \Log::info('Registering <Galleries> Module');
    }

    public function bootstrap()
    {
        // \Log::info('Boostrapping <Galleries> Module');
    }
}
