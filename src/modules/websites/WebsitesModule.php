<?php

namespace P3in\Modules;

use Modular;
use P3in\Models\Navmenu;
use P3in\Models\Permission;
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
    public $module_name = 'websites';

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
                'label' => 'Websites Manager',
                'belongs_to' => ['cp_main_nav'],
                'sub_nav' => '',
                'req_perms' => Permission::createCpRoutePerm('websites.index'),
                'order' => 3,
                'props' => [
                    'icon' => 'desktop',
                    'link' => [
                        'href' => '/websites',
                    ],
                ],
            ],[
                'label' => 'Setup',
                'belongs_to' => ['websites'],
                'sub_nav' => '',
                'req_perms' => Permission::createCpRoutePerm('websites.edit'),
                'order' => 1,
                'props' => [
                    'icon' => 'gears',
                    'link' => [
                        'href' => '/edit',
                    ],
                ],
            ],[
                'label' => 'Settings',
                'belongs_to' => ['websites'],
                'sub_nav' => '',
                'req_perms' => Permission::createCpRoutePerm('websites.settings.index'),
                'order' => 2,
                'props' => [
                    'icon' => 'pencil-square-o',
                    'link' => [
                        'href' => '/settings',
                    ],
                ],
            ],[
                'label' => 'Manage Redirects',
                'belongs_to' => ['websites'],
                'sub_nav' => '',
                'req_perms' => Permission::createCpRoutePerm('websites.redirects.index'),
                'order' => 3,
                'props' => [
                    'icon' => 'mail-reply',
                    'link' => [
                        'href' => '/redirects',
                    ],
                ],
            ],
        ];
    }

}
