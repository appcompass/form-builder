<?php

namespace P3in\Observers;

use Illuminate\Contracts\Events\Dispatcher as DispatcherContract;
use P3in\Models\User;
use Illuminate\Auth\Events\Login;

class AlertObserver
{

    public function userLogin(Login $event)
    {
        $user = $event->user;

        $message = "$user->full_name just logged in.";

        $icon = $user->avatar();

        \event::fire(new \P3in\Events\Alert(ucfirst($user->first_name) . " logged in", $message, 'info', $user, $icon));
    }

    /**
     * on ::created
     */
    public function created($model)
    {

        if (\Auth::check()) {

            $msg = \Auth::user()->full_Name . " just ";

        } else {

            $msg = 'An anonymous user ';

        }

        $reflect = new \ReflectionClass($model);

        $msg .= 'added a ' . $reflect->getShortName();

        \event::fire(new \P3in\Events\Alert('New ' . $reflect->getShortName() . ' added.', $msg, 'info',  $model));

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

        $events->listen('Illuminate\Auth\Events\Login', '\P3in\Observers\AlertObserver@userLogin');
    }

}