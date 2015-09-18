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
		return User::all();
	}

	public function getAgents()
	{
		return view('users::agent-list', ['data' => User::all()]);
	}

	public function getWebUsers()
	{
		return view('users::web-user-list', ['data' => User::all()]);
	}

}