<?php

namespace P3in\Modules;

use P3in\Models\Website;
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

	/**
	 * Render cpNav
	 *
	 *
	 */
	public function cpNav()
	{

		$sub_nav = null;

		foreach (Website::all() as $site) {

			$sub_nav["/cp/websites/$site->id/pages"] = [
				'label' => $site->site_name,
				'sub_nav' => []
			];

		}

		return [
			'/cp/websites' => [
				'label' => 'Pages',
				'sub_nav' => $sub_nav,
			]
		];

	}
}