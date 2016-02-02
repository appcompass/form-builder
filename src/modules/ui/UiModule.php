<?php

namespace P3in\Modules;

use P3in\Models\Navmenu;
use P3in\Modules\BaseModule;
use P3in\Traits\NavigatableTrait;
use Modular;

Class UiModule extends BaseModule
{

    use NavigatableTrait;

    public $module_name = "ui";

    public function __construct()
    {

    }

    public function bootstrap()
    {

    }

    public function register()
    {

        if (Modular::isLoaded('navigation')) {
            $cp_main_nav = Navmenu::byName('cp_main_nav');

            $cp_main_nav->addItem($this->navItem, 0);

            $cp_main_nav->addItem($this->navItem([
                'label' => 'Control Pannel Settings',
                'url' => '/ui/settings',
                'props' => [
                    'icon' => 'pencil',
                    'link' => [
                        'href' => '/ui/settings',
                        'data-target' => '#main-content-out'
                    ]
                ]
            ])->first(), 999);
        }

    }

    /**
     *
     */
    public function makeLink($overrides = [])
    {
        return array_replace([
            "label" => 'Dashboard',
            "url" => '',
            "req_perms" => null,
            "props" => [
                'icon' => 'dashboard',
                "link" => [
                    'href' => '/dashboard',
                    'data-target' => '#main-content-out'
                ],
            ]
        ], $overrides);
    }

}