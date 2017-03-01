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

            return $this->getUreads($request->user(), $request->page, $request->channel);

        }
    }

    /**
     *
     */
    public function update(Request $request, $alerts)
    {
        return $alerts->update(['read' => true]);
    }

    /**
     *  getUnreads
     *
     */
    protected function getUreads(User $user, $page = 1, $channel = null)
    {

        if ($last_login = \Cache::tags(['last_logins'])->get($user->email)) {

            $fromDate = new Carbon($last_login);

        } else {

            $fromDate = Carbon::now()->subDays(1);

        }

        $query = AlertUser::from($fromDate);

        if (! is_null($channel)) {

            $query->whereHas('alert', function($query) use ($channel) {

                    $query->where('channels', 'like', $channel);

                });

        }

        return $query->orderBy('created_at', 'desc')
            ->paginate(10)
            ->lists('alert');

    }

    /**
     *  getAlert
     */
    protected function getAlert($id)
    {
        if (AlertUser::userCanSee($id)) {

            return Alert::find($id);

        }
    }

}