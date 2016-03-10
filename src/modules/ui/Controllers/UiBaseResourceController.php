<?php

namespace P3in\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use Illuminate\Http\Request;
use P3in\Models\Navmenu;
use P3in\Traits\HasRouteMetaTrait;

abstract class UiBaseResourceController extends Controller
{
    use HasRouteMetaTrait;

    protected $model;
    protected $params;
    protected $user;
    public $meta;

    public function index(Request $request)
    {
        $this->template = 'ui::resourceful.index';
        $this->model = $this->model->getModel();
        return $this->output($request, [
            'records' => $this->model->get(),
        ]);
    }

    public function edit(Request $request)
    {
        $this->template = 'ui::resourceful.edit';

        return $this->output($request, [
            'record' => $this->model,
        ]);
    }

    public function create(Request $request)
    {
        $this->template = 'ui::resourceful.create';

        return $this->output($request, [
        ]);
    }

    public function store(Request $request)
    {

    }

    public function show(Request $request)
    {
        $this->template = 'ui::resourceful.show';
        $this->module_name = str_replace('.', '_', $request->route()->getName());

        return $this->output($request, [
            'record' => $this->model,
            'nav' => $this->getCpSubNav(),
            'left_panels' => $this->getLeftPanels(),
        ]);
    }

    public function update(Request $request)
    {

    }

    public function destroy(Request $request)
    {

    }

    public function setBaseModel(Request $request, $model)
    {
        $route = $request->route();
        $params = $route ? $route->parameters() : [];
        $this->model = $model->fromRoute($params);
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


    private function getCpSubNav($id = null)
    {
        $navmenu_name = 'cp_'.$this->module_name.'_subnav';

        $navmenu = Navmenu::byName($navmenu_name);

        return $navmenu;
    }
    private function getLeftPanels() {}

}