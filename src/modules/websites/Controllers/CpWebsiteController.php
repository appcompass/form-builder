<?php
namespace P3in\Controllers;

use Illuminate\Http\Request;
use P3in\Models\Website;

class CpWebsiteController extends UiBaseController
{
    // protected $allowedCalls = ['index', 'create', 'store', 'show', 'edit', 'update', 'destroy'];

    /**
     *
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->setControllerDefaults(__DIR__);
    }

    /**
     *
     */
    public function index()
    {
        $this->records = Website::all();

        return $this->build('index', ['websites']);
    }

    /**
     *
     */
    public function create(Request $request)
    {
        return $this->build('create', ['websites']);
    }

    /**
     *
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'site_name' => 'required|unique:websites|max:255',
            'site_url' => 'required',
            'config' => 'site_connection',
        ]);


        $data = $request->all();

        $this->record = Website::create($data);

        return $this->build('show', ['websites', $this->record->id]);
    }

    /**
     *
     */
    public function show($id)
    {
        $this->record = Website::findOrFail($id);

        return $this->build('show', ['websites', $id]);
    }

    /**
     *
     */
    public function edit($id)
    {
        $this->record = Website::findOrFail($id);
        return $this->build('edit', ['websites', $id]);
    }

    /**
     *
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'site_name' => 'required|unique:websites|max:255',
            'site_url' => 'required',
            'config' => 'site_connection',
        ]);


        $data = $request->all();

        $this->record = Website::findOrFail($id);

        $this->record->update($data);

        return $this->build('edit', ['websites', $id]);
    }

}