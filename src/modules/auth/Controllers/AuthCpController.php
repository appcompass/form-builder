<?php

namespace P3in\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use P3in\Models\User;
use Validator;
use Auth;

class AuthCpController extends Controller
{

	protected $loginPath ="/auth/login";
	protected $redirectAfterLogout = "/auth/login";
	protected $redirectPath = '/';
	protected $redirectTo = '/';

	use AuthenticatesAndRegistersUsers, ThrottlesLogins;

	/**
	 * Create a new authentication controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		// $this->middleware('guest', ['except' => ['getLogout', 'getLockScreen']]);
	}

	//-----------------------------------------------------------------------
	//
	//	NOTE:
	//       getLogin is implemented in the AuthenticatesUsers Trait
	//			 i don't think we need middleware in the AuthController
	//-----------------------------------------------------------------------


	public function getLogin()
	{
		// our CMS has it's own view for login.
		return view('auth::login');
	}

	/**
	 * 	Get the lock screen
	 *
	 *
	 */
	public function getLockScreen()
	{
		if (!\Auth::check()) {
			return redirect('/login');
		}

		return view('auth::lock-screen',[
			'user_fullname' => Auth::user()->full_name,
			'user_email' =>  Auth::user()->email,
			'user_avatar' => User::avatar(160),
		]);
	}

	/**
	 * Get a validator for an incoming registration request.
	 *
	 * @param  array  $data
	 * @return \Illuminate\Contracts\Validation\Validator
	 */
	protected function validator(array $data)
	{
		return Validator::make($data, [
			'first_name' => 'required|max:255',
			'last_name' => 'required|max:255',
			'email' => 'required|email|max:255|unique:users',
			'password' => 'required|confirmed|min:6',
			'phone' => 'required|max:16',
		]);
	}

	/**
	 * Create a new user instance after a valid registration.
	 *
	 * @param  array  $data
	 * @return User
	 */
	protected function create(array $data)
	{
		return User::create([
			'first_name' => $data['first_name'],
			'last_name' => $data['last_name'],
			'email' => $data['email'],
			'password' => bcrypt($data['password']),
			'phone' => $data['phone'],
			'active' => false
		]);
	}
}
