<?php

namespace P3in;

use P3in\BaseModule;

class CpModule extends BaseModule
{
    public $module_name = 'cp';

    const PUBLIC_FORM_COMPONENTS_FOLDER = /* base_path() */ "../../cp/src/components/FormBuilder";

    protected $publishes = [
        'Models/templates/' => CpModule::PUBLIC_FORM_COMPONENTS_FOLDER,
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
