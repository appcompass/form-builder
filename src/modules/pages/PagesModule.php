<?php

namespace P3in\Modules;

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
}