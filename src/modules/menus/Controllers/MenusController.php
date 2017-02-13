<?php

namespace P3in\Controllers;

use P3in\Controllers\UiBaseController;
use P3in\Models\Website;
use Illuminate\Http\Request;

class MenusController extends UiBaseController
{
    public $meta_install =
    [
        'classname' => Menu::class,
        'index' => [
            'data_targets' => [
                [
                    'route' => 'websites.show',
                    'target' => '#main-content-out',
                ],[
                    'route' => 'websites.menus.index',
                    'target' => '#record-detail',
                ],
            ],
        ],
        'update' => [
            'data_targets' => [
                [
                    'route' => 'websites.show',
                    'target' => '#main-content-out',
                ],[
                    'route' => 'websites.menus.edit',
                    'target' => '#record-detail',
                ],
            ],
            'heading' => 'Navigation Manager',
            'route' => 'pages.update'
        ],
    ];

    /**
     *  init
     */
    public function __construct()
    {
        $this->middleware('auth');

        $this->controller_class = __CLASS__;
        $this->nav_name = 'websites';

        $this->setControllerDefaults();
    }

    public function index(Request $request, Website $website)
    {
        $menus = $website->menus
            ->load('items')
            ->map(function($menu, $key) {
                return [
                    'items' => $menu->render(),
                    'name' => $menu->name
                ];
            });

        return view('menus::index', compact('menus'));
    }
}
