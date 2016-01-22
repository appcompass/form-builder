<?php

namespace P3in\Controllers;

use App\Http\Controllers\Controller;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Routing\Router;
use Modular;
use P3in\Models\Navmenu;
use P3in\Models\User;
use P3in\Models\Website;

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
        $this->module_name = 'ui';

        $this->setControllerDefaults();
    }

    public function getIndex()
    {
        return view('ui::layouts.main');
    }

    public function getLeftNav()
    {
        $cpNavs = Modular::cpNav();

        $nav = Navmenu::byName('cp_main_nav');

        return view('ui::sections/left-nav', compact('nav'));
    }

    public function getLeftAlerts()
    {
        return view('ui::sections/left-alerts');
    }

    public function getNotificationCenter()
    {
        return view('ui::sections/notification-center');
    }

    public function getDashboard()
    {
        return view('ui::sections/dashboard');
    }

    public function getUserFullName()
    {
        return Auth::user()->full_name;
    }

    public function getUserAvatar($size = 56)
    {
        $userEmail = \Auth::user()->email;
        return "http://www.gravatar.com/avatar/".md5($userEmail)."?s={$size}";
    }

    public function getUserNav()
    {
        return view('ui::sections/user-menu');
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

            $obj = $request->obj_name::find($request->obj_id);

            if (method_exists($obj , 'clone')) {

                $rslt = $obj->clone();

            }else{
                return $this->json([],false, 'Class cannot be cloned.');
            }
        }else{
            return $this->json([],false, 'Class does not exist.');
        }

        return $this->json($request->obj_redirect.'/'.$rslt->id.'/edit');
    }
}