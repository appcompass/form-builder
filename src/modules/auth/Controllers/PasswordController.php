<?php

namespace P3in\Controllers;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;

class PasswordController extends Controller
{

    use ResetsPasswords;

    // the view to be used to request a reset
    public $linkRequestView = 'auth::request-reset';

    // the actual password reset view
    public $resetView = 'auth::password-reset';

    // redirect after successful reset
    public $redirectTo = '/';

    /**
     * Create a new password controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }


    /**
    *   Override resetPassword
    *
    *   password was being double brcypt-ed
    *   in User->setPasswordAttribute
    */
    protected function resetPassword($user, $password)
    {
        $user->forceFill([
            'password' => $password, // we don't bcrypt beause of User->setPasswordAttribute
            'remember_token' => Str::random(60),
        ])->save();

        Auth::guard($this->getGuard())->login($user);
    }

}
