<?php

namespace P3in\Modules;

use Modular;
use P3in\Models\Navmenu;
use P3in\Modules\BaseModule;
use P3in\Traits\NavigatableTrait as Navigatable;

Class UsersModule extends BaseModule
{

    use Navigatable;

    public $module_name = "users";

    public function __construct()
    {

    }

    public function bootstrap()
    {
        // echo "Bootstrapping UsersModule!";
    }

    public function register()
    {

        if (Modular::isLoaded('navigation')) {
            $main_nav = Navmenu::byName('cp_main_nav');
            $main_nav_sub_nav =  Navmenu::byName('cp_main_nav_users', 'Users Manager');

            $main_nav_sub_nav->addItem($this->navItem, 1);
            $main_nav->addChildren($main_nav_sub_nav, 1);
        }

    }

    /**
     *
     */
    public function makeLink()
    {
      return [
          "label" => 'All Users',
          "url" => '',
          "new_tab" => 'false',
          "req_perms" => null,
          "props" => [
            "icon" => "user",
            "link" => [
                "data-click" => "/cp/users",
                "data-target" => "#main-content",
                'href' => 'javascript:;',
            ]
          ]
      ];
    }

}