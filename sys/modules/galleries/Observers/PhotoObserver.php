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

        // logged user or "System user"
        $msg = \Auth::check() ? \Auth::user()->full_Name : 'System user';

        // generic-ish approach to class being observed naming
        $reflect = new \ReflectionClass(get_class($model));

        $photoable = $model->photoable;

        // {count} parsed and replaced on fire time
        $alert = AlertModel::firstOrCreate([
            'title' => '{count} New ' . $reflect->getShortName() . ' added.',
            'message' => $msg . ' added {count} ' . $reflect->getShortName() . '(s)',
            'channels' => 'media_actions',
            'req_perm' => 'alert.info',
            'batch' => true,
            'emitted_by' => \Auth::check() ? \Auth::user()->id : null,
            'alertable_id' => $photoable->id,
            'alertable_type' => get_class($photoable)
        ]);

        // BaseObserver@fire
        return $this->fire($alert, null, true, 5);

    }

}