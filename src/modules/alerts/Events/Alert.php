<?php

namespace P3in\Events;

use Auth;
use App\Events\Event;
use P3in\Models\User;
use P3in\Models\Permission;
use P3in\Models\Alert as AlertModel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class Alert extends Event implements ShouldBroadcast
{
    use SerializesModels;

    /**
     *  Instead of relying on public props we export on broadcastWith
     *  which allows us to keep the alert private
     */
    protected $alert;


    /**
     *  Fire an Alert
     *
     *  @param P3in\Models\Alert $alert
     *  @param Illuminate\Eloquent\Model $related_model for polymorphic reference
     *  @param Eloquent\Collection $users users to distribute the alert to
     *  @param bool excludeEmittingUser exclude the user emitting the event Alert->emitted_by
     */
    public function __construct(AlertModel $alert, Model $related_model, Collection $users = null, $excludeEmittingUser = true)
    {
        // Link Alert to related_model
        $alert->alertable_id = $related_model->id;

        $alert->alertable_type = get_class($related_model);

        $alert->save();

        $this->alert = $alert;

        // this is the only information we're putting on the queue/socket
        $this->id = $alert->id;

        if (is_null($users)) {

            $users = $this->collectUsers($alert);

        }

        // distribute the alert to the users
        AlertModel::distribute($alert, $users, $excludeEmittingUser);

        return true;
    }

    /**
     *  Event payload
     */
    public function broadcastWith()
    {
        return [
            'id' => $this->alert->id
        ];
    }

    /**
     *  Get the channels the event should be broadcast on.
     *
     *  @return array
     */
    public function broadcastOn()
    {
        return explode(',', $this->alert->channels);
    }

    /**
     *  CollectUsers
     *
     */
    private function collectUsers(AlertModel $alert)
    {

        if ($alert->req_perm) {

            try {

                $perm = Permission::byType($alert->req_perm)->firstOrFail();

                return $perm->users();

            } catch (ModelNotFoundException $e) {

                return [];

            }

        } else {

            \Log::info("Alert $alert->id created with no permissions assigned.");

            $users = [];

        }
    }
}
