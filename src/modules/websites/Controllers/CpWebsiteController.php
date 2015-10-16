<?php
namespace P3in\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use P3in\Models\Website;

class CpWebsiteController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
    	$records = Website::all();
        return view('websites::index', compact('records'));
    }

    public function create()
    {
        return view('websites::create');
    }

    public function store(Request $request)
    {
        $record = Website::create($request->all());
        return view('websites::show', compact('record'));

    }


    public function show($id)
    {

        $record = Website::findOrFail($id)->load('pages.template.sections');

        return view('websites::show')->with('record', $record);
    }

    public function edit($id)
    {
        return view('websites::edit', ['record' => Website::findOrFail($id)]);
    }

    public function update(Request $request, $id)
    {
        $record = Website::findOrFail($id);
        $record->update($request->all());
        return view('websites::edit', compact('record'));
    }

}