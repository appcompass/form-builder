<?php

namespace P3in\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use Closure;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use P3in\Models\Navmenu;
use P3in\Traits\HasFormTrait;
use P3in\Traits\HasGateCheckTrait;
use P3in\Traits\HasRouteMetaTrait;
use ReflectionMethod;
use ReflectionClass;

abstract class UiAbstractController extends Controller
{
    use HasRouteMetaTrait, HasFormTrait, HasGateCheckTrait;

    protected $model;
    protected $params;
    protected $user;
    protected $template;
    public $meta;

    public function __construct(Request $request)
    {
        $this->meta = json_decode(json_encode($this->meta));
        $this->explainRoute($request);
    }

    protected function setTemplate($template_name, $force = false)
    {
        if (!$this->template || $force) {
            $this->template = $template_name;
        }
    }

    protected function output(Request $request, $data = [], $success = true, $message = '')
    {
        $data['meta'] = $this->getMeta($request->route()->getName());
        $this->meta->form = isset($this->meta->form_name) ? $this->getForm($this->meta->form_name) : null;

        // @TODO: The below to two attributes are here only for backwards compatibility. so kill it when we can.
        if ($data['meta']) {
            $data['meta']->base_url = '/'.$request->path();
        }

        // we do this to allow injection/overide on a per controller basis.
        if (!empty($this->meta)) {
            foreach ($this->meta as $key => $val) {
                $data['meta']->$key = $val;
            }
        }

        if ($request->wantsJson()) {
            return $this->json($data, $success, $message);
        }elseif($request->ajax()){
            return view($this->template, $data);
        }else{
            // this is just a tem example.
            return view('ui::layouts.main', ['main_content' => view($this->template, $data)]);
        }
    }

    protected function json($data, $success = true, $message = '', $code = 200)
    {
        $rtn = [
            'success' => $success,
            'data' => $data,
            'message' => $message,
        ];

        return response()->json($rtn, $code);
    }

    public function explainRoute(Request $request)
    {
        $route = $request->route();

        if ($route) {
            $n = $route->getName();
            $url = $request->path();
            $method_name = substr($n, strrpos($n, '.')+1);

            $this->params = $route->parameters();
            $this->base_url = '/'.substr($url, 0, strrpos($url, '/'));
            $this->url = '/'.$url;
            $this->meta->route_root = substr($n, 0, strrpos($n, '.'));
            $this->meta->method_name = $method_name;

            // Check permissions
            // $this->gateCheck($method_name);

            // we take the route and convert it to a nav name so something.else becomes something_else
            $this->nav_name = str_replace(['.','-'], '_', $route->route_root);

            switch ($method_name) {
                case 'create':
                case 'edit':
                    $this->meta->base_url = $this->base_url;
                case 'index':
                case 'show':
                    $this->setTemplate('ui::resourceful.'.$method_name);
                break;
            }




        }
    }

    public function getCpSubNav($id = null)
    {
        $menu = Navmenu::fromCache('cp_ui', 'nav');

        return isset($menu->{$this->nav_name}) ? $menu->{$this->nav_name} : [];
    }
}
