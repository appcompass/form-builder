<?php

namespace P3in\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use Illuminate\Http\Request;
use P3in\Controllers\UiBaseController;
use P3in\Models\Navmenu;

abstract class UiBaseResourceController extends Controller
{
    protected $model;
    protected $params;
    protected $user;
    public $meta;

    public function index(Request $request)
    {
        $this->template = 'ui::index';

        return $this->output($request, [
            'meta' => $this->meta,
            'records' => $this->model->get(),
        ]);
    }

    public function edit(Request $request)
    {
        $this->template = 'ui::edit';

        return $this->output($request, [
            'meta' => $this->meta,
            'record' => $this->record,
        ]);
    }

    public function create(Request $request)
    {
        $this->template = 'ui::create';

        return $this->output($request, [
            'meta' => $this->meta,
        ]);
    }

    public function store(Request $request)
    {

    }

    public function show(Request $request)
    {
        $this->template = 'ui::show';

        return $this->output($request, [
            'meta' => $this->meta,
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

    private function output(Request $request, $data, $success = true, $message = '')
    {
        if ($request->wantsJson()) {
            return $this->json($data, $success, $message);
        }else{
            return view($this->template, $data);
        }
    }

    private function getCpSubNav($id = null)
    {
        $navmenu_name = 'cp_'.$this->module_name.'_subnav';

        $navmenu = Navmenu::byName($navmenu_name);

        return $navmenu;
    }
    private function getLeftPanels() {}

}