<?php

namespace P3in\Modules;

use P3in\Models\Navmenu;
use P3in\Modules\BaseModule;
use P3in\Traits\NavigatableTrait;

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

		Navmenu::byName('cp-main-nav')->addItem($this->navItem);

	}

	/**
	 *
	 */
	public function makeLink()
	{
	    return [
	        "label" => 'Dashboard',
	        "url" => '',
	        "req_perms" => null,
	        "props" => [
	            'icon' => 'dashboard',
	            "link" => [
	                'data-click' => '/cp/galleries',
	                'data-target' => '#main-content'
	            ],
	        ]
	    ];
	}

}