<?php

namespace P3in\Modules;

use P3in\Models\Navmenu;
use P3in\Modules\BaseModule;
use P3in\Traits\NavigatableTrait;

Class UsersModule extends BaseModule
{

    use NavigatableTrait;

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

        Navmenu::byName('cp-main-nav')->addItem($this->navItem);

    }

    /**
     *
     */
    public function makeLink()
    {
      return [
          "label" => 'Users',
          "url" => '',
          "new_tab" => 'false',
          "req_perms" => null,
          "props" => [
            "icon" => "user",
            "link" => [
                "data-click" => "/cp/users",
                "data-target" => "#main-content",
            ]
          ]
      ];
    }

    /**
     * Render cpNav
     *
     *
     */
    public function cpNav()
    {
        return [
            'name' => $this->module_name,
            'belongs_to' => null,
            'order' => 1,
            'label' => 'Users Manager',
            'icon' => 'fa-users',
            'attributes' => [
                'href' => 'javascript:;',
            ],
            'sub_nav' => [
                [
                    'order' => 0,
                    'belongs_to' => $this->module_name,
                    'label' => 'All Users',
                    'icon' => '',
                    'attributes' => [
                        'data-click' => '/cp/users',
                        'data-target' => '#main-content',
                        'href' => 'javascript:;',
                    ],
                ]
            ],
        ];
    }
}