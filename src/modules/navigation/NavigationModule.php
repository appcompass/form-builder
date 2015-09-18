<?php

namespace P3in\Modules;

use \App\Modules\BaseModule;

Class NavigationModule extends BaseModule
{

	public $module_name = "NavigationModule";

	public function __construct( )
	{

	}

	/**
	*	Add navItem
	*
	*
	*/
	public function addNavItem(Link $item)
	{

	}

	public function bootstrap()
	{
		require_once('helpers/LinkClass.php');
	}

	public function register()
	{
		echo "Registering Nav Module";
	}
}