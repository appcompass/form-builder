<?php

namespace P3in;

use P3in\BaseModule;
use P3in\PublishFiles;

class PilotIoModule extends BaseModule
{
    public $module_name = 'pilot-io';

    protected $publishes = [
        // publishes to disk instances by name.
        // Public/' => 'cp_root',
        //'Models/FieldTypes/templates/' => 'cp_form_fields',
        'Public/components/FormBuilder' => 'cp_form_fields',
    ];

    // @TODO: programatically run: php artisan vendor:publish --provider="Tymon\JWTAuth\Providers\JWTAuthServiceProvider"
    public function __construct()
    {
        // \Log::info('Loading <Cp> Module');
    }

    public function bootstrap()
    {
    }

    public function register()
    {
    }
}
