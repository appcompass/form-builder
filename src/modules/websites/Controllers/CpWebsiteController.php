<?php
namespace P3in\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use P3in\Models\UiConfig;
use P3in\Models\Website;

class CpWebsiteController extends UiBaseController
{

    public function __construct()
    {
        $this->middleware('auth');
        $this->setControllerDefaults(__DIR__);
    }

    public function index()
    {
        return parent::build('index', Website::all());
    }

    public function create()
    {
        return parent::build('create', Website::all());
    }

    public function store(Request $request)
    {
        return parent::build('create', Website::create($request->all()));
    }

    public function show($id)
    {
        return parent::build('show', Website::findOrFail($id));
    }

    public function edit($id)
    {
        return parent::build('edit', Website::findOrFail($id));
    }

    public function update(Request $request, $id)
    {
        return parent::build('edit', Website::findOrFail($id)->update($request->all()));
    }

}