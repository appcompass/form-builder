<?php

namespace P3in\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use P3in\Models\Gallery;
use P3in\Models\Photo;
use Gate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\View;
use P3in\Controllers\UiBaseController;
use P3in\Models\User;

class CpPhotosController extends UiBaseController
{

    public $meta_install = [
    ];

    public function __construct()
    {
        $this->middleware('auth');

        $this->controller_class = __CLASS__;
        $this->module_name = 'photos';

        $this->setControllerDefaults();
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $this->records = Photo::all();

        return $this->build('index', ['photos']);
    }

    /**
     * Display a form to create a resource.
     *
     * @return Response
     */
    public function create()
    {
        return View::make('photos::create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request)
    {

        // we commeted this out for now to skip over permisisons till we start seeding basic master admin permissions etc.
        // $this->user->can('create-photos');

        $record = Photo::store($request->file, $this->user);

        return view('photos::show', compact('record'));

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {

        $photo = Photo::findOrFail($id);

        return View::make('photos::show', compact('photo'));

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {

        $record = Photo::findOrFail($id);
        return View::make('photos::edit', compact('record'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $id)
    {

        $record = Photo::findOrFail($id);

        $this->validate($request, [

            "file" => 'required|mimes:jpg,jpeg,png'

        ]);

        $record = Photo::store($request->file, $this->user);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }
}
