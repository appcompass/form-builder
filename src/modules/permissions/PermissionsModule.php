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
		// echo "Bootstrapping PermissionsModule!";
	}

	public function register()
	{
		echo "Registering Auth Module";
	}

}