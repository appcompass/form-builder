<?php

namespace P3in\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use Closure;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use P3in\Models\Navmenu;
use P3in\Traits\HasRouteMetaTrait;

abstract class UiBaseResourceController extends Controller
{
    use HasRouteMetaTrait;

    protected $model;
    protected $params;
    protected $user;
    protected $template;
    public $meta;

    public function index(Request $request)
    {
        $records = $this->builder->paginate($request->has('per_page') ? $request->per_page : 20);
        // $records->setPath('https://' . $request->getHttpHost() . '/' . $request->path());

        return $this->output($request, [
            'records' => $records,
        ]);
    }

    public function edit(Request $request)
    {
        return $this->output($request, [
            'record' => $this->model,
        ]);
    }

    public function create(Request $request)
    {
        return $this->output($request, [
        ]);
    }

    public function show(Request $request)
    {
        return $this->output($request, [
            'record' => $this->model,
            'nav' => $this->getCpSubNav(),
            'left_panels' => $this->getLeftPanels(),
        ]);
    }

    public function store(Request $request)
    {
        $this->validate($request, $this->model->getRules());

        $newRecord = $this->model->fill($request->only($this->model->getFillable()));
        $newRecord->save();

        return $this->json('/'.$request->path().'/'.$newRecord->getKey().'/edit');
    }

    public function update(Request $request)
    {
        $this->validate($request, $this->model->getRules());

        $this->model->update($request->only($this->model->getFillable()));
        return $this->json('/'.$request->path());
    }

    public function destroy(Request $request)
    {
        $this->model->delete();
        return $this->json($this->base_url);
    }

    /**
     *  Gate Check
     */
    public function gateCheck($type)
    {
        if (\Gate::denies($type, get_class($this->model))) {
            abort(403);
        }
    }


    public function init(Request $request, Closure $cb)
    {
        $route = $this->explainRoute($request);
        // put in to allow controllers to inject/overide metas.
        $this->meta = new \stdClass();

        if ($route->name) {

            $this->builder = $cb($route);
            $this->model = $this->builder->getModel();
            $model_name = get_class($this->model);

            $this->params = $route->params;
            $this->base_url = $route->base_url;
            $this->meta->method_name = $route->method_name;
            $this->meta->classname = $model_name;

            // Check permissions
            $this->gateCheck($model_name);

            // we take the route and convert it to a nav name so something.else becomes something_else
            $this->nav_name = str_replace(['.','-'], '_', $route->route_root);

            switch ($route->method_name) {
                case 'create':
                case 'edit':
                    $this->meta->base_url = $this->base_url;
                case 'index':
                case 'show':
                    $this->setTemplate('ui::resourceful.'.$route->method_name);
                break;
            }

            // if (in_array($route->method_name, ['index', 'edit', 'create', 'show'])) {
            //     $this->setTemplate('ui::resourceful.'.$route->method_name);
            // }
        }
    }

    public function explainRoute(Request $request)
    {
        $rtn = new \stdClass();
        $rtn->params = [];
        $rtn->name = null;
        $rtn->route_root = null;
        $rtn->method_name = null;
        $rtn->base_url = null;

        $route = $request->route();

        if ($route) {
            $n = $route->getName();
            $url = $request->path();
            $rtn->params = $route->parameters();
            $rtn->name = $n;
            $rtn->url = $url;

            $rtn->route_root = substr($n, 0, strrpos($n, '.'));
            $rtn->method_name = substr($n, strrpos($n, '.')+1);
            $rtn->base_url = '/'.substr($url, 0, strrpos($url, '/'));
        }

        return $rtn;
    }

    public function setTemplate($template_name, $force = false)
    {
        if (!$this->template || $force) {
            $this->template = $template_name;
        }
    }
    public function output(Request $request, $data, $success = true, $message = '')
    {
        $data['meta'] = $this->getMeta($request->route()->getName());

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
        }else{
            return view($this->template, $data);
        }
    }

    public function json($data, $success = true, $message = '')
    {
        $rtn = [
            'success' => $success,
            'data' => $data,
            'message' => $message,
        ];

        return response()->json($rtn);
    }


    public function getCpSubNav($id = null)
    {
        $menu = Navmenu::fromCache('cp_ui', 'nav');

        return isset($menu->{$this->nav_name}) ? $menu->{$this->nav_name} : [];
    }

    private function getLeftPanels() {}

}
