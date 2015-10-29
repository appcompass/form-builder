<?php

namespace P3in\Modules;

use P3in\Models\Website;
use P3in\Modules\BaseModule;
use P3in\Traits\NavigatableTrait;

Class PagesModule extends BaseModule
{

    use NavigatableTrait;

    public $module_name = "pages";

    public function __construct()
    {

    }

    public function bootstrap()
    {
        // echo "Bootstrapping PagesModule!";
    }

    public function register()
    {

    }

    public function makeLink()
    {
      return [];
    }

}