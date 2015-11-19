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

        if (Modular::isLoaded('navigation')) {
            $main_nav = Navmenu::byName('cp_main_nav');
            $main_nav_sub_nav =  Navmenu::byName('cp_main_nav_users', 'Users Manager');

            $main_nav_sub_nav->addItem($this->navItem, 2);
            $main_nav->addChildren($main_nav_sub_nav, 1);
        }

    }

    /**
     *
     */
    public function makeLink($overrides = [])
    {
      return array_replace([
          "label" => 'Permissions',
          "url" => '',
          "new_tab" => 'false',
          "req_perms" => null,
          "props" => [
            "icon" => "user",
            "link" => [
                'href' => "/permissions",
                "data-target" => "#main-content-out",
            ]
          ]
      ], $overrides);
    }

}