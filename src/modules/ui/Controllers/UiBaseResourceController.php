<?php

namespace P3in\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests;
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
        return $this->output($request, [
            'records' => $this->model->get(),
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
        $this->validate($request, $this->model->rules);

        $this->model->create($request->only($this->model->fillable));
        return $this->json('/'.$request->path());
    }

    public function update(Request $request)
    {
        $this->validate($request, $this->model->rules);

        $this->model->update($request->only($this->model->fillable));
        return $this->json('/'.$request->path());
    }

    public function destroy(Request $request)
    {
        $this->model->delete();
        return $this->json('/'.$request->path());
    }

    /**
     *  Gate Check
     */
    public function gateCheck($type)
    {
        if (\Gate::denies($type, get_class($this->model->getModel()))) {
            abort(403);
        }
    }


    public function init(Request $request, $model)
    {
        $route = $this->explainRoute($request);

        $this->model = $model->fromRoute($route->params);


        if ($route->name) {
            // Check permissions
            $this->gateCheck(get_class($this->model));

            // we take the route and convert it to a nav name so something.else becomes something_else
            $this->nav_name = str_replace(['.','-'], '_', $route->route_root);

            if (in_array($route->method_name, ['index', 'edit', 'create', 'show'])) {
                $this->setTemplate('ui::resourceful.'.$route->method_name);
            }
        }
    }

    public function explainRoute(Request $request)
    {
        $rtn = new \stdClass();
        $rtn->params = [];
        $rtn->name = null;
        $rtn->route_root = null;
        $rtn->method_name = null;

        $route = $request->route();

        if ($route) {
            $n = $route->getName();

            $rtn->params = $route->parameters();
            $rtn->name = $n;
            $rtn->route_root = substr($n, 0, strrpos($n, '.'));
            $rtn->method_name = substr($n, strrpos($n, '.')+1);
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
            $data['meta']->classname = get_class($this->model);
            $data['meta']->base_url = '/'.$request->path();
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
        // $menu = Cache::tags('cp_ui')->get('nav');

        $menu = Navmenu::fromCache('cp_ui', 'nav');

        return isset($menu->{$this->nav_name}) ? $menu->{$this->nav_name} : [];
    }

    private function getLeftPanels() {}

}
