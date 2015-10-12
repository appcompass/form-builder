<?php

namespace P3in\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use P3in\Models\User;
use Auth;

class UiController extends Controller {

	public function __construct()
	{
		$this->middleware('auth');
	}

	public function getIndex()
	{
		return view('ui::index');
	}

	public function getLeftNav()
	{
		return view('ui::sections/left-nav');
	}

	public function getLeftAlerts()
	{
		return view('ui::sections/left-alerts');
	}

	public function getNotificationCenter()
	{
		return view('ui::sections/notification-center');
	}

	public function getDashboard()
	{
		return view('ui::sections/dashboard');
	}

	public function getUserFullName()
	{
		return Auth::user()->full_name;
	}

	public function getUserAvatar($size = 56)
	{
		return User::avatar($size);
	}

	public function getUserNav()
	{
		return view('ui::sections/user-menu');
	}

}