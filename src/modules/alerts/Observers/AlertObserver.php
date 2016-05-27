<?php

namespace P3in\Observers;

/**
 *  Get the event
 *  Pass it to a method
 *  New up (or fetch) an AlertModel
 *  Fire an AlertEvent passing the AlertModel
 */

use Illuminate\Contracts\Events\Dispatcher as DispatcherContract;
use P3in\Models\User;
use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Logout;
use P3in\Events\Alert as AlertEvent;
use P3in\Models\Alert as AlertModel;
use Event;

class AlertObserver
{

    /**
     * Login/Logout
     */
    public function userAuthEvent($event)
    {

        switch(get_class($event)) {
            case 'Illuminate\Auth\Events\Login':
                $action = 'logged in.';
                break;
            case 'Illuminate\Auth\Events\Logout':
                $action = 'logged out.';
                break;
        }

        $user = $event->user;

        $alert = new AlertModel([
            'title' => ucfirst($user->first_name) . ' ' . $action,
            'message' => "{$user->full_name} has just $action",
            'req_perm' => 'alert.info', // @TODO this fetches all the users that own the perm through Permission::users()
            'props' => [
                'icon' => $user->avatar()
            ]
        ]);

        Event::fire(new AlertEvent($alert, $user));
    }

    /**
     * on ::created
     */
    public function created($model)
    {

        $msg = \Auth::check() ? \Auth::user()->full_Name : 'An anonymous user ';

        $reflect = new \ReflectionClass($model);

        $alert = new AlerModel([
            'title' => 'New ' . $reflect->getShortName() . ' added.',
            'message' => $msg . ' just added a ' . $reflect->getShortName(),
            'req_perm' => 'alert.info'
        ]);

        Event::fire(new AlertEvent($alert, $model));

        \Log::info($msg);
    }

    /**
     * On ::saved
     */
    public function updated($model)
    {

        \Log::info(get_class($model));

    }


    /**
     * Generic handler
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

        \event::fire(new \P3in\Events\Alert('Title', $event->message, 'info', $model, $event->icon));

    }

    /**
     * register listeners for the subscriber.
     */
    public function subscribe($events)
    {
        // Here we could link 'event' => class@method
        // @NOTE remember to fill the 'subscribe' array in the ServiceProvider

        $events->listen('Illuminate\Auth\Events\Login', '\P3in\Observers\AlertObserver@userAuthEvent');
        $events->listen('Illuminate\Auth\Events\Logout', '\P3in\Observers\AlertObserver@userAuthEvent');
    }

}