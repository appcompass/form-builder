<?php

namespace P3in\Modules;

use P3in\Modules\BaseModule;

Class AuthModule extends BaseModule
{

	public $module_name = "AuthModule";

	public function __construct()
	{

	}

	public function bootstrap()
	{
		// echo "Bootstrapping AuthModule!";
	}

	public function register()
	{
		echo "Registering Auth Module";
	}

	public function getAlerts()
	{
		return "Alerts!!";
	}
}