<?php

namespace P3in\Controllers;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Route;
use P3in\Models\User;

class AuthController extends Controller
{
    use ThrottlesLogins;

    public function login(Request $request)
    {
        $this->validateLogin($request);

        if ($this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }
        $credentials = [
            'email' => $request->email,
            'password' => $request->password,
            'active' => 1,
        ];
        if ($token = $this->guard()->attempt($credentials)) {
            return $this->sendLoginResponse($request, $token);
        }

        $this->incrementLoginAttempts($request);

        return $this->sendFailedLoginResponse($request);
    }

    public function logout(Request $request)
    {
        $this->guard()->logout();

        return response()->json([
            'message' => 'Logged out',
        ]);
    }

    protected function validateLogin(Request $request)
    {
        $this->validate($request, [
            $this->username() => 'required', 'password' => 'required',
        ]);
    }

    protected function sendLoginResponse(Request $request, string $token)
    {
        $this->clearLoginAttempts($request);

        $user = $this->guard()->user();
        // lets save the last_login timestamp.
        $user->last_login = Carbon::now();
        $user->save();

        return $this->authenticated($request, $user, $token);
    }

    protected function sendFailedLoginResponse(Request $request)
    {
        return response()->json([
            'message' => Lang::get('auth.failed'),
        ], 401);
    }

    protected function authenticated(Request $request, $user, string $token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => config('jwt.ttl') * 60
        ]);
    }

    public function username()
    {
        return 'email';
    }

    protected function guard()
    {
        return Auth::guard();
    }

}
