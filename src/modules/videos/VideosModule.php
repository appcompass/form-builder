<?php

namespace P3in\Modules;

use Modular;
use P3in\Models\Gallery;
use P3in\Models\Navmenu;
use P3in\Models\Permission;
use P3in\Models\Website;
use P3in\Modules\BaseModule;
use P3in\Traits\NavigatableTrait as Navigatable;

class VideosModule extends BaseModule
{
    use Navigatable;

    public $module_name = 'videos';

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
    public function makeLink()
    {
        return [
            [
                'label' => 'All Videos',
                'belongs_to' => ['cp_main_nav_media'],
                'sub_nav' => '',
                'req_perms' => Permission::createCpRoutePerm('videos.index', 'All Videos'),
                'order' => 2,
                'props' => [
                    'icon' => 'film',
                    'link' => [
                        'href' => '/videos',
                    ],
                ],
            ],[
                'label' => 'Videos',
                'belongs_to' => ['galleries'],
                'sub_nav' => '',
                'req_perms' => Permission::createCpRoutePerm('galleries.videos.index', 'Gallery Videos'),
                'order' => 3,
                'props' => [
                    'icon' => 'film',
                    'link' => [
                        'href' => '/videos',
                    ],
                ],
            ],
        ];
    }

}
