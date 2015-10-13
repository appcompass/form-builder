<?php
namespace P3in\Controllers;

use App\Http\Controllers\Controller;
use P3in\Models\Website;

class WebsiteController extends Controller
{

	public function __construct()
	{
		$this->middleware('auth');
	}

	public function index()
	{
		return view('websites::list', ['records' => Website::all()]);
	}
}