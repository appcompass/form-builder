<?php

namespace P3in;

use P3in\BaseModule;

class WebsitesModule extends BaseModule {
	public $module_name = 'websites';

	public function __construct() {
		// \Log::info('Loading <Websites> Module');
	}

	public function bootstrap() {
		// \Log::info('Boostrapping <Websites> Module');
	}

	public function register() {
		// \Log::info('Registering <Websites> Module');
		// Profile::registerProfiles($this->profiles);
	}

	public function getRenderData($settings) {
		// bunch of cases we actually want to do stuff with these settings.
		return $settings;
	}
}
