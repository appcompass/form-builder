<?php

namespace P3in\Controllers;

use App\Http\Controllers\Controller;
use P3in\Models\NavigationItem;

class NavigationController extends Controller
{

	public function index()
	{
		return NavigationItem::all();
	}

	public function store()
	{

	}
}