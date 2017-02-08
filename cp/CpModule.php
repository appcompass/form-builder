<?php

namespace P3in;

use P3in\BaseModule;
use P3in\Models\Storage;
use P3in\PublishFiles;

class CpModule extends BaseModule
{
    public $module_name = 'cp';

    public function __construct()
    {
        // \Log::info('Loading <Cp> Module');
    }

    public function bootstrap()
    {
        \Log::info('Bootstrapping <Cp> Module');
    }

    public function register()
    {
        \Log::info('Registering <Cp> Module');

        // these were seeded already.
        $cp_root = Storage::diskByName('cp_root');
        // $cp_components = Storage::diskByName('cp_components');
        $cp_form_fields = Storage::diskByName('cp_form_fields');

        $publisher = new PublishFiles();

        $publisher
            ->setSrc('cp', realpath(__DIR__.'/Public'))
            ->setSrc('fieldtypes', realpath(__DIR__.'/Models/templates'))
            ->publishFolder('cp', $cp_root, true)
            ->publishFolder('fieldtypes', $cp_form_fields, true);

        // @TODO load stuff here. like caching routes etc
        // $this->setSeeders();
    }
}
