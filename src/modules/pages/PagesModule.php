<?php

namespace P3in\Modules;

use Modular;
use P3in\Models\Navmenu;
use P3in\Models\NavigationItem;
use P3in\Models\Website;
use P3in\Modules\BaseModule;
use P3in\Traits\NavigatableTrait as Navigatable;

Class PagesModule extends BaseModule
{

    use Navigatable;

    public $module_name = "pages";

    public function __construct() {}

    public function bootstrap() {}

    public function register()
    {

        $this->checkOrSetUiConfig();

    }


    /**
     * Provides means for creating a NavigationItem item
     *
     */
    public function makeLink($overrides = [])
    {
        return array_replace([

        ], $overrides);
    }

    /**
     *  Set CMS module's config
     *
     */
    public function checkOrSetUiConfig() {

        $module = Modular::get($this->module_name);

            $module->config = [];
        return $module->save();
    }


}