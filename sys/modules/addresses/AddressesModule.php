<?php

namespace P3in;

use P3in\BaseModule;

class AddressesModule extends BaseModule {
	public $module_name = "addresses";

	public function __construct() {
		// \Log::info('Loading <Addresses> Module');
	}

	public function bootstrap() {
		// \Log::info('Boostrapping <Addresses> Module');
	}

	public function register() {
		// \Log::info('Registering <Addresses> Module');
		// Profile::registerProfiles($this->profiles);
	}
}
