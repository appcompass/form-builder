<?php

namespace P3in\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use Auth;
use Illuminate\Http\Request;
use Modular;
use P3in\Models\Navmenu;
use P3in\Models\User;
use P3in\Models\Website;

class UiController extends UiBaseController {

    public function __construct()
    {
        // parent::__construct();
        $this->middleware('auth');
        $this->setControllerDefaults(__DIR__);
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

    // private function buildCpNav($cpNavs)
    // {
    //     $out = [];
    //     $main_sort = [];
    //     $sub_nav_sort = [];

    //     // construct parents.
    //     foreach ($cpNavs as $module_name => $module_nav) {
    //         if (empty($module_nav['belongs_to'])) {
    //             $out[$module_nav['name']] = $module_nav;
    //             $main_sort[] = $module_nav['order'];
    //             if (!empty($module_nav['sub_nav'])) {
    //                 foreach ($module_nav['sub_nav'] as $sub_nav) {
    //                     $sub_nav_sort[$module_name][] = $sub_nav['order'];
    //                 }
    //             }
    //         }
    //     }

    //     // sort the output array by the sort order.
    //     array_multisort($main_sort, $out);

    //     // construct sub navs.
    //     foreach ($cpNavs as $module_name => $module_nav) {
    //         if (!empty($module_nav['belongs_to'])) {
    //             $out[$module_nav['belongs_to']]['sub_nav'][] = $module_nav;
    //             $sub_nav_sort[$module_nav['belongs_to']][] = $module_nav['order'];
    //         }

    //     }

    //     // sort sub navs for each module.
    //     foreach ($out as $module_name => $row) {
    //         if (!empty($sub_nav_sort[$module_name])) {
    //             array_multisort($sub_nav_sort[$module_name], $row['sub_nav']);
    //             $out[$module_name]['sub_nav'] = $row['sub_nav'];
    //         }
    //     }

    //     return $out;
    // }

}