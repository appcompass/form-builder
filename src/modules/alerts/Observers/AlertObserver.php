<?php

namespace P3in\Observers;

use Illuminate\Contracts\Events\Dispatcher as DispatcherContract;
use P3in\Models\User;
use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Logout;
use P3in\Events\Alert as AlertEvent;
use P3in\Models\Alert as AlertModel;
use Event;
use P3in\Observers\BaseObserver;

class AlertObserver extends BaseObserver
{

    /**
     *  Register listeners for the subscriber.
     *
     */
    public function subscribe($events)
    {
        // Here we could link 'event' => class@method
        // @NOTE remember to fill the 'subscribe' array in the ServiceProvider

        $events->listen('Illuminate\Auth\Events\Attempting', '\P3in\Observers\AlertObserver@attempt');
        $events->listen('Illuminate\Auth\Events\Login', '\P3in\Observers\AlertObserver@userAuthEvent');
        $events->listen('Illuminate\Auth\Events\Logout', '\P3in\Observers\AlertObserver@userAuthEvent');
    }

    /**
     *  Attempt
     *
     *  @param \Illuminate\Auth\Events\Attempting
     */
    public function attempt($attempting)
    {
        /**
         *  To ease the alert catch-up routine we store the last_login on Attempt event to get
         *  the timestamp before (if) it gets updated by the Login event handler
         */
        try {

            $user = User::where('email', $attempting->credentials['email'])->firstOrFail();

            \Cache::tags(['last_logins'])->put($user->email, $user->last_login, 60); // store last_login for an hour

        } catch (ModelNotFoundException $e) {}

    }

    /**
     *  Login/Logout
     *
     */
    public function userAuthEvent($event)
    {
        if ($event->user->isSystem()) {

            return;

        }

        $user = $event->user;

        $action = get_class($event) === 'Illuminate\Auth\Events\Login' ? 'in.' : 'out.';

        $alert = AlertModel::create([
            'title' => ucfirst($user->first_name) . ' logged ' . $action,
            'message' => "{$user->full_name} logged " . $action,
            'channels' => 'auth_events',
            'req_perm' => 'alert.info',
            'emitted_by' => $user->id,
            'alertable_id' => $user->id,
            'alertable_type' => get_class($user),
            'props' => [
                'icon' => $user->avatar()
            ]
        ]);

        return $this->fire($alert, null, true, 0);
    }

    /**
     *  On ::created
     *
     *  @NOTE this is a generic create "catchAll"
     */
    public function created($model)
    {

        $msg = \Auth::check() ? \Auth::user()->full_Name : 'An anonymous user ';

        $reflect = new \ReflectionClass(get_class($model));

        $alert = AlertModel::create([
            'title' => 'New ' . $reflect->getShortName() . ' added.',
            'message' => $msg . ' added a ' . $reflect->getShortName(),
            'channels' => 'actions',
            'req_perm' => 'alert.info',
            'alertable_id' => $user->id,
            'alertable_type' => get_class($user),
            'emitted_by' => \Auth::check() ? \Auth::user()->id : null
        ]);

        return $this->fire($alert, null, true, 0);
    }

    /**
     *  On ::saved
     *
     */
    public function updated($model)
    {
        // \Log::info(get_class($model));
    }

    /**
     *  Generic handler
     *
     */
    public function handle($event)
    {
        \Log::info('Handle method called');

        $model = null;

        // look for a model in the event object, use the last we find (leaf)
        foreach ($event as $arg) {

            if (is_object($arg)) {

                $model = $arg;

            }

        }

        $alert = AlertModel::create([
            'title' => 'Title', // @TODO pay attention to me!
            'message' => $event->message,
            'channel' => 'actions',
            'level' => 'info',
            'req_perm' => 'alert.info',
            'alertable_id' => $user->id,
            'alertable_type' => get_class($user),
        ]);

        return $this->fire($alert, null, true, 0);
    }

}