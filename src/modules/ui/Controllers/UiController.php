<?php

namespace P3in\Controllers;

use App\Http\Controllers\Controller;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Route;
use Modular;
use P3in\Models\Navmenu;
use P3in\Models\User;
use P3in\Models\Website;
use P3in\Modules\UiModule;

class UiController extends UiBaseController {

    public $meta_install = [
        'getDashboard' => [
            'data_targets' => [
                [
                    'route' => 'dashboard',
                    'target' => '#main-content-out',
                ]
            ],
        ],
    ];

    public function __construct()
    {
        // parent::__construct();
        $this->middleware('auth');

        $this->controller_class = __CLASS__;
        // $this->nav_name = 'cp_ui_subnav';

        $this->setControllerDefaults();
    }

    public function getIndex()
    {
        return view('ui::layouts.main');
    }

    public function getLeftNav()
    {
        $allNavs = Navmenu::fromCache('cp_ui', 'nav');

        $nav = isset($allNavs->cp_main_nav) ? $allNavs->cp_main_nav : [];

        return view('ui::sections.left-nav')
            ->with('nav', $nav);
    }

    public function getLeftAlerts()
    {
        return view('ui::sections.left-alerts');
    }

    public function getNotificationCenter()
    {
        return view('ui::sections.notification-center');
    }

    public function getDashboard()
    {
        return view('ui::sections.dashboard');
    }

    public function getUserFullName()
    {
        return Auth::user()->full_name;
    }

    public function getUserAvatar($size = 56)
    {
        $userEmail = \Auth::user()->email;
        return "//www.gravatar.com/avatar/".md5($userEmail)."?s={$size}";
    }

    public function getUserNav()
    {
        return view('ui::sections.user-menu');
    }

    public function postRequestMeta(Request $request)
    {
        $rtn = $this->requestMeta($request->url);

        return response()->json($rtn);
    }

    public function postDeleteModal(Request $request)
    {
        return view('ui::partials/delete-modal', [
            'url' => $request->resource,
        ]);
    }

    public function postCloneResource(Request $request)
    {
        if (class_exists($request->obj_name)) {

            $obj = with(new $request->obj_name)->findOrFail($request->obj_id);

            if (method_exists($obj , 'cloneRecord')) {

                $rslt = $obj->cloneRecord();

            }else{
                return $this->json([],false, 'Class cannot be cloned.');
            }
        }else{
            return $this->json([],false, 'Class does not exist.');
        }

        return $this->json($request->obj_redirect.'/'.$rslt->id.'/edit');
    }
}
