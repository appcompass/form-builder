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
        return view('websites::settings', ['record' => Website::findOrFail($website_id)]);
    }

    public function store(Request $request, $website_id)
    {
        $website = Website::findOrFail($website_id);
        $website->settings($request->input('settings'));
        return view('websites::settings', ['record' => $website]);
    }

}