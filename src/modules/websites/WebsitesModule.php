<?php

namespace P3in\Modules;

use Modular;
use P3in\Models\Navmenu;
use P3in\Models\Website;
use P3in\Module;
use P3in\Modules\BaseModule;
use P3in\Traits\NavigatableTrait as Navigatable;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;

Class WebsitesModule extends BaseModule
{

    use Navigatable;

    /**
     * Module Name
     */
	public $module_name = "websites";

	public function __construct() {}

    /**
     * Bootstrap, runs every time
     *
     */
	public function bootstrap()
	{
    }

    /**
     * Register, runs only on module load
     *
     */
    public function register()
    {
        $this->setConfig();

        if (Modular::isLoaded('navigation')) {
            Navmenu::byName('cp_main_nav')->addItem($this->navItem, 2);
        }
	}

    /**
     *
     */
    public function makeLink($overrides = [])
    {
      return array_replace([
        "label" => 'Websites Manager',
        "url" => '',
        "req_perms" => null,
        "props" => [
            'icon' => 'dashboard',
            "link" => [
                'data-click' => '/websites',
                'data-target' => '#main-content-out'
            ],
        ]
      ], $overrides);
    }


    public function setConfig()
    {

        $module = Modular::get($this->module_name);

        $module->config = [];

        $module->save();
    }

}