<?php

namespace P3in\Modules;

use P3in\Models\UiConfig;
use P3in\Models\Website;
use P3in\Modules\BaseModule;
use P3in\Traits\NavigatableTrait as Navigatable;

Class WebsitesModule extends BaseModule
{

	public $module_name = "websites";

	public function __construct()
	{

	}

	public function bootstrap()
	{
		// echo "Bootstrapping AuthModule!";
        $this->checkOrSetUiConfig();
	}

	public function register()
	{
		echo "Registering Websites Module";
	}


    public function checkOrSetUiConfig()
    {
        // we should probably put this in the model?  it's here for now.
        if (!UiConfig::where('module_name', $this->module_name)->count()) {
            UiConfig::create([
                'module_name' => $this->module_name,
                'config' => [
                    'base_url' => "/cp/{$this->module_name}",
                    'index' => [
                        'heading' => 'Manage Websites',
                        'table' => [
                            'headers' => [
                                'Name',
                                'Site URL',
                                'Description',
                                'Created',
                                'Updated',
                            ],
                            // we might want to restructure this to allow for formating details.
                            // i.e. wrapper details for things like items that require badges etc,
                            // or other simple things like datetime formats.
                            'rows' => [
                                'site_name' => [
                                    'type' => 'link_by_id',
                                    'target' => '#main-content',
                                ],
                                'site_url' => [
                                    'type' => 'link_to_blank',
                                ],
                                'description' => [
                                    'type' => '',
                                ],
                                'created_at' => [
                                    'type' => 'datetime',
                                ],
                                'updated_at' => [
                                    'type' => 'datetime',
                                ],
                            ],
                        ],
                    ],
                    'show' => [
                        'sub_section_name' => 'Sub Sections',
                    ],
                    'edit' => [
                    ],
                    'create' => [
                    ],
                    /* other stuff */
                ],
            ]);
        }
    }

	/**
	 * Render cpNav
	 *
	 *
	 */
	public function cpNav()
	{

		return [
			'name' => $this->module_name,
			'belongs_to' => null,
			'order' => 2,
			'label' => 'Websites Manager',
			'icon' => 'fa-dashboard',
			'attributes' => [
				'data-click' => '/cp/websites',
				'data-target' => '#main-content',
			],
			'sub_nav' => null,
		];

	}
}