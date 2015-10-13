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

	public function cpNav()
	{
		return [
			'/cp/websites' => [
				'label' => 'Websites Manager',
				'sub_nav' => []
			]
		];
	}
}