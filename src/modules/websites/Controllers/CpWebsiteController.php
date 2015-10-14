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
        return view('websites::list', ['records' => Website::all()]);
    }

    public function create()
    {
        return view('websites::create');
    }

    public function store(Request $request)
    {
        $website = Website::create($request->all());
        return view('websites::detail', ['record' => $website]);

    }


    public function show($id)
    {
        return view('websites::detail', ['record' => Website::findOrFail($id)]);
    }

    public function edit($id)
    {
        return view('websites::connection', ['record' => Website::findOrFail($id)]);
    }

    public function update(Request $request, $id)
    {
        $website = Website::findOrFail($id);
        $website->update($request->all());
        return view('websites::connection', ['record' => $website]);
    }

    public function showSettings($id)
    {
        return view('websites::settings', ['record' => Website::findOrFail($id)]);
    }

    public function updateSettings(Request $request, $id)
    {
        return view('websites::settings', ['record' => Website::findOrFail($id)->settings($request->input('settings'))]);
    }

}