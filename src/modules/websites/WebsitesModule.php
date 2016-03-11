<?php

namespace P3in\Modules;

use Modular;
use P3in\Models\Navmenu;
use P3in\Models\Website;
use P3in\Module;
use P3in\Modules\BaseModule;
use P3in\Traits\NavigatableTrait as Navigatable;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;

Class WebsitesModule extends BaseModule
{

    use Navigatable;

    /**
     * Module Name
     */
    public $module_name = "websites";

    public function __construct() {}

    /**
     * Bootstrap, runs every time
     *
     */
    public function bootstrap()
    {
    }

    /**
     * Register, runs only on module load
     *
     */
    public function register()
    {

    }

    /**
     *
     */
    public function makeLink()
    {
        return [
            [
                "label" => 'Websites Manager',
                'belongs_to' => ['cp_main_nav'],
                'sub_nav' => '',
                "req_perms" => 'cp-websites-manager',
                'order' => 3,
                "props" => [
                    'icon' => 'dashboard',
                    "link" => [
                        'href' => '/websites',
                        // 'data-target' => '#main-content-out'
                    ],
                ],
            ],[
                "label" => 'Setup',
                'belongs_to' => ['cp_websites_subnav'],
                'sub_nav' => '',
                "req_perms" => 'cp-websites-manager',
                'order' => 1,
                "props" => [
                    "icon" => "user",
                    "link" => [
                        'href' => "/edit",
                        // "data-target" => "#main-content-out",
                    ],
                ],
            ],[
                "label" => 'Settings',
                'belongs_to' => ['cp_websites_subnav'],
                'sub_nav' => '',
                "req_perms" => 'cp-websites-settings',
                'order' => 2,
                "props" => [
                    "icon" => "user",
                    "link" => [
                        'href' => "/settings",
                        // "data-target" => "#main-content-out",
                    ],
                ],
            ],[
                "label" => 'Manage Redirects',
                'belongs_to' => ['cp_websites_subnav'],
                'sub_nav' => '',
                "req_perms" => 'cp-websites-settings',
                'order' => 3,
                "props" => [
                    "icon" => "user",
                    "link" => [
                        'href' => "/redirects",
                        // "data-target" => "#main-content-out",
                    ],
                ],
            ],
        ];
    }

}