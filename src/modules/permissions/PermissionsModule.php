<?php

namespace P3in\Modules;

use P3in\Modules\BaseModule;

Class PermissionsModule extends BaseModule
{

    public $module_name = "permissions";

    public function __construct()
    {

    }

    public function bootstrap()
    {

    }

    public function register()
    {
        // echo "Registering Auth Module";
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
            'belongs_to' => 'users',
            'order' => 2,
            'label' => 'Permissions',
            'icon' => '',
            'attributes' => [
                'data-click' => '/cp/permissions',
                'data-target' => '#main-content',
                'href' => 'javascript:;',
            ],
            'sub_nav' => null,
        ];
    }

}