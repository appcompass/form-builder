<?php

namespace P3in\Modules;

use P3in\Models\Website;
use P3in\Modules\BaseModule;

Class PagesModule extends BaseModule
{

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
        echo "Registering Pages Module";
    }

    /**
     * Render cpNav
     *
     *
     */
    public function cpNav()
    {

        $sub_nav = null;

        foreach (Website::all() as $site) {

            $sub_nav[] = [
                'name' => $site->site_name,
                'belongs_to' => $this->module_name,
                'order' => $site->id,
                'label' => $site->site_name,
                'icon' => null,
                'attributes' => [
                    'data-click' => "/cp/websites/{$site->id}/pages",
                    'data-target' => '#main-content',
                ],
                'sub_nav' => null
            ];

        }

        return [
            'name' => $this->module_name,
            'belongs_to' => null,
            'order' => 3,
            'label' => 'Pages Manager',
            'icon' => 'fa-book',
            'attributes' => [
                'href' => 'javascript:;',
            ],
            'sub_nav' => $sub_nav,
        ];

    }
}