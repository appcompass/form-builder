<?php

namespace P3in\Controllers;

use App\Http\Controllers\Controller;
use P3in\Models\NavigationItem;
use P3in\Models\Navmenu;

class NavigationController extends Controller
{

  /**
   *
   *
   */
  public function __construct()
  {
    $this->middleware('auth');
  }

  /**
   *
   *
   */
	public function index()
	{
    return Abort(404, 'No index here');
		return Navmenu::first();
	}

  /**
   *
   *
   */
  public function show($navmenu)
  {

    return Navmenu::byName($navmenu);

  }

	public function store()
	{

	}
}