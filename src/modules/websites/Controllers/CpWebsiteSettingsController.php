<?php
namespace P3in\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use P3in\Models\Section;
use P3in\Models\Website;

class CpWebsiteSettingsController extends UiBaseController
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     *
     */
    public function index($website_id)
    {
        $website = Website::findOrFail($website_id);

        return view('websites::settings/index', compact('website'))
            ->with('settings', $website->settings->data)
            ->with('headers', Section::headers()->get()->lists('name', 'id'))
            ->with('footers', Section::footers()->get()->lists('name', 'id'));
    }

    /**
     *
     */
    public function create($website_id)
    {
        $parent = Website::findOrFail($website_id);
        return view('websites::settings/create', compact('parent'));
    }

    /**
     *
     */
    public function store(Request $request, $website_id)
    {

        $website = Website::findOrFail($website_id);

        $data = $request->except(['_token', '_method']);

        $records = $website->settings($data);

        return $this->index($website_id);

        // return view('websites::settings/index', compact('records'))
            // ->with('parent', $website);
    }

    /**
     *
     *
     */
    public function update()
    {
        $parent = Website::findOrFail($website_id);

    }

    /**
     *
     */
    public function show($website_id, $id)
    {

        $parent = Website::findOrFail($website_id);
        $records = $parent->settings(); //id ?

        return view('websites::settings/show', compact('parent', 'records'));
    }

}