<?php

namespace P3in\Modules\CoreModule;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use P3in\Models\User;

class CoreController extends Controller {

	public function __construct()
	{
		$this->middleware('auth');
	}

	public function getIndex()
	{
		return view('core::index');
	}

	public function getLeftNav()
	{
		return view('core::sections/left-nav');
	}

	public function getLeftAlerts()
	{
		return view('core::sections/left-alerts');
	}

	public function getNotificationCenter()
	{
		return view('core::sections/notification-center');
	}

	public function getDashboard()
	{
		return view('core::sections/dashboard');
	}

	public function getUserFullName()
	{
		return \Auth::user()->full_name;
	}

	public function getUserAvatar($size = 56)
	{
		return User::avatar($size);
	}

	public function getUserNav()
	{
		return view('core::sections/user-menu');
	}

}