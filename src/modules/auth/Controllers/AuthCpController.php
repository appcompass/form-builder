<?php

namespace P3in\Controllers;

use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;
use P3in\Controllers\UiBaseController;
use P3in\Models\User;
use Validator;

class AuthCpController extends UiBaseController
{

	protected $loginPath ="/auth/login";
	protected $redirectAfterLogout = "/auth/login";
	protected $redirectPath = '/';
	protected $redirectTo = '/';

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
     * Handle a login request to the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function postLogin(Request $request)
    {
        $this->validate($request, [
            $this->loginUsername() => 'required', 'password' => 'required',
        ]);

        $success = false;
        $message = $this->getFailedLoginMessage();
        $data = [
            'redirect' => $this->loginPath(),
        ];

        $credentials = $this->getCredentials($request);

        if (Auth::attempt($credentials, $request->has('remember'))) {
            $success = true;
            $message =  '';
            $data['redirect'] = $this->redirectPath();
        }


        // // If the login attempt was unsuccessful we will increment the number of attempts
        // // to login and redirect the user back to the login form. Of course, when this
        // // user surpasses their maximum number of attempts they will get locked out.
        // if ($throttles) {
        //     $this->incrementLoginAttempts($request);
        // }

        if ($request->wantsJson()) {
            return $this->json($data, $success, $message);
        }else{
            if ($success) {
                return redirect()->intended($this->redirectPath());
            }else{
                return redirect($this->loginPath())
                    ->withInput($request->only($this->loginUsername(), 'remember'))
                    ->withErrors([
                        $this->loginUsername() => $this->getFailedLoginMessage(),
                    ]);
            }
        }


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

    /**
     * Get the needed authorization credentials from the request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    protected function getCredentials(Request $request)
    {
        return $request->only($this->loginUsername(), 'password');
    }

    /**
     * Get the failed login message.
     *
     * @return string
     */
    protected function getFailedLoginMessage()
    {
        return Lang::has('auth.failed')
                ? Lang::get('auth.failed')
                : 'These credentials do not match our records.';
    }

    /**
     * Log the user out of the application.
     *
     * @return \Illuminate\Http\Response
     */
    public function getLogout()
    {
        Auth::logout();

        return redirect(property_exists($this, 'redirectAfterLogout') ? $this->redirectAfterLogout : '/');
    }

    /**
     * Get the path to the login route.
     *
     * @return string
     */
    public function loginPath()
    {
        return property_exists($this, 'loginPath') ? $this->loginPath : '/auth/login';
    }

    /**
     * Get the post register / login redirect path.
     *
     * @return string
     */
    public function redirectPath()
    {
        if (property_exists($this, 'redirectPath')) {
            return $this->redirectPath;
        }

        return property_exists($this, 'redirectTo') ? $this->redirectTo : '/';
    }

    /**
     * Get the login username to be used by the controller.
     *
     * @return string
     */
    public function loginUsername()
    {
        return property_exists($this, 'username') ? $this->username : 'email';
    }

}
