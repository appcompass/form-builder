<?php
namespace P3in\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
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

	public function create()
	{
		Website::create([
			'site_name' => 'BostonPads.com',
			'site_url' => 'http://www.bostonpads.com',
			'config' => [
				'from_email' => 'website@bostonpads.com',
				'from_name' => 'BostonPads.com',
				'managed' => true,
				'ssh_host' => '',
				'ssh_username' => '',
				'ssh_password' => '',
				'ssh_key' => '',
				'ssh_keyphrase' => '',
				'ssh_root' => '/usr/share/nginx/bostonpads.com/htdocs/html',
			],
		]);
	}

	public function show($id)
	{
		return view('websites::detail', ['record' => Website::findOrFail($id)]);
	}

	public function showConnection($id)
	{
		return view('websites::connection', ['record' => Website::findOrFail($id)]);
	}

	public function updateConnection(Request $request, $id)
	{
		$website = Website::findOrFail($id);
		$website->update($request->all());
		return view('websites::connection', ['record' => $website]);
	}

	public function showConfig($id)
	{
		return view('websites::config', ['record' => Website::findOrFail($id)]);
	}

}