<?php

namespace P3in\Modules;

use P3in\Modules\BaseModule;

Class PagesModule extends BaseModule
{

	public $module_name = "PagesModule";

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
}