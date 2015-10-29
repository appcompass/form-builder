<?php
namespace P3in\Controllers;

use Illuminate\Http\Request;
use P3in\Models\Website;

class CpWebsiteController extends UiBaseController
{
    protected $allowedCalls = ['index', 'create', 'store', 'show', 'edit', 'update', 'destroy'];

    public function __construct()
    {
        $this->middleware('auth');
        $this->setControllerDefaults(__DIR__);

        $this->getNav();
    }

    public function index()
    {
        $this->records = Website::all();

        return $this->build('index');
    }

    public function create()
    {
        return $this->build('create');
    }

    public function store(Request $request)
    {
        $this->record = Website::create($request->all());

        return $this->build('show');
    }

    public function show($id)
    {
        $this->record = Website::findOrFail($id);

        return $this->build('show');
    }

    public function edit($id)
    {
        $this->record = Website::findOrFail($id);

        return $this->build('edit');
    }

    public function update(Request $request, $id)
    {
        $this->record = Website::findOrFail($id);

        $this->record->update($request->all());

        return $this->build('edit');
    }

}