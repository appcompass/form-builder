<?php

namespace P3in\Modules;

use P3in\Modules\BaseModule;

Class UiModule extends BaseModule
{
	public $module_name = "ui";

	public function __construct()
	{

	}

	public function bootstrap()
	{

	}

	public function register()
	{

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
			'order' => 0,
			'label' => 'Dashboard',
			'icon' => 'fa-dashboard',
			'attributes' => [
				'data-click' => '/cp/dashboard',
				'data-target' => '#main-content',
			],
			'sub_nav' => null,
		];

	}
}