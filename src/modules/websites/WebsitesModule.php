<?php

namespace P3in\Modules;

use P3in\Models\Website;
use P3in\Modules\BaseModule;
use P3in\Traits\NavigatableTrait as Navigatable;

Class WebsitesModule extends BaseModule
{

	public $module_name = "websites";

	public function __construct()
	{

	}

	public function bootstrap()
	{
		// echo "Bootstrapping AuthModule!";
	}

	public function register()
	{
		echo "Registering Websites Module";
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
			'order' => 2,
			'label' => 'Websites Manager',
			'icon' => 'fa-dashboard',
			'attributes' => [
				'data-click' => '/cp/websites',
				'data-target' => '#main-content',
			],
			'sub_nav' => null,
		];

	}
}