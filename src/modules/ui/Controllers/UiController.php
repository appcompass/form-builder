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

    public function __construct()
    {
        // parent::__construct();
        $this->middleware('auth');
        $this->setControllerDefaults(__DIR__);

        $this->meta = new \stdClass(); // we don't need anything here atm, but we need this to be defined.
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

    // this method needs some SERIOUS abstraction...
    public function postRequestMeta(Request $request)
    {
        $rtn = [
            'success' => false,
            'data' => [],
            'message' => 'a url must be passed.',
        ];

        if (!empty($request->url)) {
            // default catch all.
            $uriAry = explode('/',trim($request->url,'/'));
            $target = $this->setDataTarget($uriAry);

            // now lets split the url up into the resources and it's params
            $resources = [];
            $params = [];
            $both = [&$resources, &$params];
            array_walk($uriAry, function($v, $k) use ($both) { $both[$k % 2][] = $v; });

            // get url's route controller name and method (aka the route action)
            $action = Route::getRoutes()->match(Request::create($request->url))->getActionName();
            list($class, $method) = explode('@', $action);

            $rtn['message'] = 'The url must have a defined route.';
            if ($class && $method) {

                // lets get the meta data for this controller.
                $metaData = with(new $class)->meta;

                $rtn['message'] = 'The controller for this route needs target meta data.';
                if (!empty($metaData->$method) && !empty($metaData->$method->data_targets)) {
                    $rtn['success'] = true;
                    $rtn['message'] = '';
                    $tree = [];
                    $rtn['data'] = $this->buildTree($tree, $metaData->$method->data_targets, $params);
                }
            }

            if (!$rtn['success']) {
                $rtn['data'] = [
                    'url' => $request->url,
                    'target' => $target,
                ];
            }
        }

        return response()->json($rtn);
    }

    private function buildTree(&$tree, $data, $params)
    {
        foreach ($data as $i => $row) {
            // lets find out how many params we are working with.
            $route = Route::getRoutes()->getByName($row->route);
            $matches = [];
            preg_match_all('/{\$?([_a-z][\w\.]+[\w])}/' , $route->uri(), $matches);

            // now lets get the url using the route and the params that apply to this route.
            $url =  route($row->route, array_slice($params, 0, count($matches[0])), false);
            $target = $row->target;

            unset($data[$i]);

            $tree = [
                'url' => $url,
                'target' => $target,
                'next' => !empty($data) ? $this->buildTree($tree, $data, $params) : [],
            ];
            break;
        }
        return $tree;
    }

}