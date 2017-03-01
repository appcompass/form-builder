<?php

namespace P3in\Modules;

use Modular;
use P3in\Models\Navmenu;
use P3in\Modules\BaseModule;
use P3in\Traits\NavigatableTrait as Navigatable;

Class PermissionsModule extends BaseModule
{
    use Navigatable;

    public $module_name = "permissions";

    public function __construct()
    {

    }

    public function bootstrap()
    {

    }

    public function register()
    {

    }

    /**
     *
     */
    public function makeLink()
    {
        return [];
    }

}