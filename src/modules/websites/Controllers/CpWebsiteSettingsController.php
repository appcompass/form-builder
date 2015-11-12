<?php
namespace P3in\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use P3in\Models\Website;

class CpWebsiteSettingsController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index($website_id)
    {
        $website = Website::findOrFail($website_id);

        return view('websites::settings/index', compact('website'))
            ->with('settings', $website->settings);
    }

    public function create($website_id)
    {
        $parent = Website::findOrFail($website_id);
        return view('websites::settings/create', compact('parent'));
    }

    public function store(Request $request, $website_id)
    {
        $parent = Website::findOrFail($website_id);
        $records = $parent->settings($request->input('settings'));

        return view('websites::settings/show', compact('parent', 'records'));
    }

    public function show($website_id, $id)
    {

        $parent = Website::findOrFail($website_id);
        $records = $parent->settings(); //id ?

        return view('websites::settings/show', compact('parent', 'records'));
    }

}