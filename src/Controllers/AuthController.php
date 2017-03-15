<?php

namespace P3in\Controllers;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Route;
use P3in\Events\Login;
use P3in\Events\Logout;

class AuthController extends Controller
{
    use AuthenticatesUsers;

    public function logout(Request $request)
    {
        $user = $this->guard()->user();

        $this->guard()->logout(true);

        event(new Logout($user));

        return response()->json([
            'message' => 'Logged out',
        ]);
    }

    public function user(Request $request)
    {
        return $request->user();
    }

    protected function credentials(Request $request)
    {
        $creds = $request->only($this->username(), 'password');
        $creds['active'] = 1;
        return $creds;
    }

    // we need to do things a bit differently using JWTAuth since it doesn't
    // fire events and the remember.  We also need the token to be setfor later
    // use in the controller, not sure why JWT doesn't do it internally...
    protected function attemptLogin(Request $request)
    {
        if($token = $this->guard()->attempt($this->credentials($request))) {
            $this->guard()->setToken($token);
            $user = $this->guard()->user();

            // jwt auth does not use events.
            event(new Login($user, $token));
        }
        return $token;
    }

    protected function validateLogin(Request $request)
    {
        // we add remember => true to the request since all token auth are set to remember (no session).
        $request->merge(array('remember' => true));
        $this->validate($request, [
            $this->username() => 'required', 'password' => 'required',
        ]);
    }

    protected function authenticated(Request $request, $user)
    {
        if ($token = $this->guard()->getToken()) {
            $token = $token->get();
        }else{
            return $this->sendFailedLoginResponse($request);
        }

        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => config('jwt.ttl') * 60,
            'user' => $user
        ]);
    }

    protected function sendFailedLoginResponse(Request $request)
    {
        return response()->json([
            'message' => Lang::get('auth.failed'),
        ], 401);
    }

}
