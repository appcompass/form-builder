<?php

namespace P3in\Modules;

use Modular;
use P3in\Models\Gallery;
use P3in\Models\Navmenu;
use P3in\Models\Permission;
use P3in\Models\Website;
use P3in\Modules\BaseModule;
use P3in\Traits\NavigatableTrait as Navigatable;

class PhotosModule extends BaseModule
{
    use Navigatable;

    public $module_name = 'photos';

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
                'label' => 'All Photos',
                'belongs_to' => ['cp_main_nav_media'],
                'sub_nav' => '',
                'req_perms' => Permission::createCpRoutePerm('photos.index', 'All Photos'),
                'order' => 1,
                'props' => [
                    'icon' => 'picture-o',
                    'link' => [
                        'href' => '/photos',
                    ],
                ],
            ],[
                'label' => 'Photos',
                'belongs_to' => ['galleries'],
                'sub_nav' => '',
                'req_perms' => Permission::createCpRoutePerm('galleries.photos.index', 'Gallery Photos'),
                'order' => 2,
                'props' => [
                    'icon' => 'picture-o',
                    'link' => [
                        'href' => '/photos',
                    ],
                ],
            ],
        ];
    }
}
