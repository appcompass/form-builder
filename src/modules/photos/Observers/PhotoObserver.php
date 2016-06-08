<?php

namespace P3in\Observers;

use Event;
use P3in\Jobs\SendDelayedAlert;
use P3in\Observers\BaseObserver;
use P3in\Events\Alert as AlertEvent;
use P3in\Models\Alert as AlertModel;

class PhotoObserver extends BaseObserver
{

    /**
     *  Created
     *  No need for specific behavior atm
     */
    public function created($model)
    {
        return $this->updated($model);
    }


    /**
     *  Updated
     *
     */
    public function updated($model)
    {

        // we only care for instances of photos that belong to something
        // because we need to link the alert to the coreesponding related model
        if (!$model->photoable_id) {
            return;
        }

        // logged user or "System user" a
        $msg = \Auth::check() ? \Auth::user()->full_Name : 'System user';

        // generic-ish approach to class being observed naming
        $reflect = new \ReflectionClass(get_class($model));

        $model = $model->photoable;

        // {count} parsed and replaced on fire time
        $alert = AlertModel::firstOrCreate([
            'title' => '{count} New ' . $reflect->getShortName() . ' added.',
            'message' => $msg . ' added {count} ' . $reflect->getShortName() . '(s)',
            'channels' => 'media_actions',
            'req_perm' => 'alert.info',
            'batch' => true,
            'emitted_by' => \Auth::check() ? \Auth::user()->id : null,
            'alertable_id' => $model->id,
            'alertable_type' => get_class($model)
        ]);

        $alert = AlertModel::firstOrCreate([
            'title' => 'Alert title',
            'message' => 'body',
            'channels' => 'dot.separated.channels',
            'req_perm' => 'single_permission_name',
            'batch' => true | false,
            'emitted_by' => 'id of the emitting user',
            'alertable_id' => 'model id that fired the event we are firing',
            'alertable_type' => 'class of the model firing the alert'
        ]);


        // BaseObserver@fire
        return $this->fire($alert, null, true, 10);

    }

}