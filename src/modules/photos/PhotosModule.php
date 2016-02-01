<?php

namespace P3in\Modules;

use P3in\Models\Gallery;
use P3in\Models\Navmenu;
use Modular;
use P3in\Traits\NavigatableTrait as Navigatable;
use P3in\Modules\BaseModule;

class PhotosModule extends BaseModule
{
    use Navigatable;

    public $module_name = "photos";

    /**
     * Runs every time
     */
    public function bootstrap()
    {
    }

    /**
     * Runs on module load
     */
    public function register()
    {
        $this->checkOrSetUiConfig();

        if (Modular::isLoaded('navigation')) {
            $main_nav = Navmenu::byName('cp_main_nav');
            $main_nav_media =  Navmenu::byName('cp_main_nav_media', 'Media Manager');

            $main_nav_media->addItem($this->navItem, 1);
            $main_nav->addChildren($main_nav_media, 5);
        }
    }

    /**
     *
     */
    public function makeLink($overrides = [])
    {
        return array_replace([
            "label" => 'Photos',
            "url" => '',
            "req_perms" => null,
            "props" => [
                "icon" => "camera",
                "link" => [
                    'href' => "/photos",
                    "data-target" => "#main-content-out",
                ]
            ]
        ], $overrides);
    }

    public function checkOrSetUiConfig()
    {

        $module = Modular::get($this->module_name);

        $module->config = [
            'base_url' => "/{$this->module_name}",
            'index' => [
                'heading' => 'Manage Images',
                'table' => [
                    'sortables' => ['Label', 'Status', 'Storage'],
                    'headers' => [
                        'Thumbnail',
                        'Label',
                        'Status',
                        'Storage',
                        'Type',
                        'Created',
                        'Updated',
                    ],
                    'rows' => [
                        'thumbnail' => [
                            'type' => 'image',
                        ],
                        'label' => [
                            'type' => 'text',
                        ],
                        'status' => [
                            'type' => 'text',
                        ],
                        'storage' => [
                            'type' => 'text',
                        ],
                        'photo_of' => [
                            'type' => 'option',
                            'option_name' => 'label'
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
                'heading' => 'Gallery Information',
                'route' => 'photos.update'
            ],
            'create' => [
                'heading' => 'Gallery Information',
                'route' => 'photos'
            ],
            'form' => [
                'route' => 'galleries.update',
                'fields' => [
                    [
                        'label' => 'Label',
                        'name' => 'label',
                        'placeholder' => 'Photo label',
                        'type' => 'text',
                        'help_block' => ''
                    ]
                ],
            ],
        ];

        $module->save();

    }
}