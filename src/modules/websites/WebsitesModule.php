<?php

namespace P3in\Modules;

use P3in\Modules\BaseModule;
use P3in\Traits\NavigatableTrait as Navigatable;

Class WebsitesModule extends BaseModule
{

	public $module_name = "WebsitesModule";

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
}