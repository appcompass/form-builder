<?php

namespace P3in\Observers;

use Event;
use P3in\Events\Alert as AlertEvent;
use P3in\Models\Alert as AlertModel;

class PhotoObserver
{
    /**
     *  On ::created
     *
     */
    public function created($model)
    {

        $msg = \Auth::check() ? \Auth::user()->full_Name : 'An anonymous user ';

        $reflect = new \ReflectionClass(get_class($model));

        $alert = new AlertModel([
            'title' => 'New ' . $reflect->getShortName() . ' added.',
            'message' => $msg . ' added a ' . $reflect->getShortName(),
            'channels' => 'media_actions',
            'req_perm' => 'alert.info',
            'emitted_by' => \Auth::check() ? \Auth::user()->id : null
        ]);

        Event::fire(new AlertEvent($alert, $model, null, true));
    }

}