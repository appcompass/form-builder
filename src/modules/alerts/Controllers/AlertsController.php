<?php

namespace P3in\Controllers;

use App\Http\Controllers\Controller;
use P3in\Models\User;
use P3in\Models\Alert;
use P3in\Models\AlertUser;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AlertsController extends Controller
{

    /**
     *  index
     */
    public function index(Request $request)
    {
        if ($request->has('alert_id')) {

            return $this->getAlert($request->alert_id);

        } else {

            return $this->getUreads($request->user());

        }
    }

    /**
     *  getUnreads
     *
     */
    protected function getUreads(User $user)
    {
        if ($last_login = \Cache::tags(['last_logins'])->get($user->email)) {

            return AlertUser::from(new Carbon($last_login))
                ->get()
                ->load('alert')
                ->lists('alert');

        }

        return;
    }

    /**
     *  getAlert
     */
    protected function getAlert($id)
    {
        if (AlertUser::userCanSee($id)) {

            return Alert::find($id);

        }

        // AlertUser::where('alert_id', $id)
        //     ->where('user_id', \Auth::user()->id)
        //     ->exists();

        // $gotMail = (bool) \DB::table('alert_user')
            // ->count();

        // if ($gotMail) {
            // return AlertModel::where('id', $id)->first();
        // }
    }


}