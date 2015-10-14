<?php

namespace P3in\Modules;

use P3in\Modules\BaseModule;
use P3in\Traits\NavigatableTrait;

Class UsersModule extends BaseModule
{

	// use NavigatableTrait;

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
		echo "Registering User Module";
	}

	public function getNavigation()
	{
		return ['users' => []];
	}

	public function getAlerts()
	{
		return "Alerts!!";
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
					'label' => 'All Users',
					'icon' => '',
					'attributes' => [
						'data-click' => '/cp/users',
						'data-target' => '#main-content',
					],
				]
			],
		];
	}
}