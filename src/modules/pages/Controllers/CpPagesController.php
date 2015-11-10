<?php

namespace P3in\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use Illuminate\Http\Request;
use P3in\Models\NavigationItem;
use P3in\Models\Navmenu;
use P3in\Models\Page;
use P3in\Models\Website;

class CpPagesController extends UiBaseController
{

    /**
    *
    */
    public function __construct()
    {

        $this->middleware('auth');

        parent::setControllerDefaults(__DIR__);

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() { /* Creation is performed in CpWebsitePagesController */ }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) { /* We create pages through CpWebsitePagesController */ }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        $this->record = Page::findOrFail($id);

        return parent::build('show');

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $this->record = Page::findOrFail($id);

        return parent::build('edit');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $reques
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $page_id)
    {

        $this->record = Page::findOrFail($page_id);

        $this->record->update($request->all());

        return parent::build('edit');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
