<?php

namespace P3in\Controllers;

use Illuminate\Http\Request;

use P3in\Models\User;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class UserController extends Controller
{

	public function getIndex()
	{
		return view('users::user-list', ['data' => User::all()]);
	}

}