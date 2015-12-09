<?php

namespace P3in\Modules;

use P3in\Models\Alerts;
use P3in\Modules\BaseModule;

Class AlertsModule extends BaseModule
{

	public $module_name = "alerts";

	public function __construct()
	{
		parent::__construct();
	}

	public function fire()
	{
		return "Firing from {$this->module_name}";
	}


	public function bootstrap()
	{
		return [
			"message" => "Bootstrapping AlertsModule!"
		];
	}

	public function register()
	{
		echo "Registering Alerts Module";
	}

}