<?php

namespace P3in\Modules;

use Modular;
use P3in\Models\Gallery;
use P3in\Models\Navmenu;
use P3in\Models\Website;
use P3in\Modules\BaseModule;
use P3in\Traits\NavigatableTrait as Navigatable;

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
    }

    /**
     *
     */
    public function makeLink($overrides = [])
    {
        return [
            [
                "label" => 'Photos',
                'belongs_to' => ['cp_main_nav_media'],
                'sub_nav' => '',
                "req_perms" => 'cp-media-photos-manager',
                'order' => 1,
                "props" => [
                    "icon" => "camera",
                    "link" => [
                        'href' => "/photos",
                    ],
                ],
            ]
        ];
    }
}