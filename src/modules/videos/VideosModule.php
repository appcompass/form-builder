<?php

namespace P3in\Modules;

use Modular;
use P3in\Models\Gallery;
use P3in\Models\Navmenu;
use P3in\Models\Website;
use P3in\Modules\BaseModule;
use P3in\Traits\NavigatableTrait as Navigatable;

class VideosModule extends BaseModule
{
    use Navigatable;

    public $module_name = "videos";

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
        return array_replace([
            "label" => 'Videos',
            "url" => '/videos',
            "req_perms" => null,
            "props" => [
                "icon" => "camera",
                "link" => [
                    'href' => "/videos",
                    "data-target" => "#main-content-out",
                ]
            ]
        ], $overrides);
    }

}
