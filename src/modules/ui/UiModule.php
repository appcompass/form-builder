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
                'url' => 'cp/ui/settings',
                'props' => [
                    'icon' => 'pencil',
                    'link' => [
                        'data-click' => '/cp/ui/settings',
                        'data-target' => '#main-content'
                    ]
                ]
            ])->first(), 999);
        }



        // $cp_main_nav =  Navmenu::byName('cp_main_nav_pages', 'Pages Manager');


        // foreach(Website::all() as $website) {

        //     $item = $website->navItem([
        //         'label' => $website->site_name,
        //         'url' => 'cp/websites'.$website->id.'/pages',
        //         'props' => [
        //             // 'icon' => 'file-text-o',
        //             'icon' => 'globe',
        //             'link' => [
        //                 'data-click' => '/cp/websites/'.$website->id.'/pages',
        //                 'data-target' => '#main-content'
        //             ]
        //         ]
        //     ])->get()->first();

        //     $cp_main_nav->addItem($item);

        // }





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
	                'data-click' => '/cp/dashboard',
	                'data-target' => '#main-content'
	            ],
	        ]
	    ], $overrides);
	}

}