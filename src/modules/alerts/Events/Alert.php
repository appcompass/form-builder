<?php

namespace P3in\Events;

use App\Events\Event;
use Auth;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Queue\SerializesModels;
use P3in\Jobs\SendDelayedAlert;
use P3in\Models\Alert as AlertModel;
use P3in\Models\Permission;
use P3in\Models\User;

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
     *  @param Eloquent\Collection $users users to distribute the alert to, use permission -if any- to distribute
     *  @param bool excludeEmittingUser exclude the user emitting the event Alert->emitted_by
     */
    public function __construct(AlertModel $alert, Collection $users = null, $excludeEmittingUser = true)
    {

        // this is for matching the channel, only the id is being exported
        $this->alert = $alert;

        // this is the only information we're putting on the queue/socket
        $this->id = $alert->id;

        if (is_null($users)) {

            $users = $this->collectUsers($alert);

        }

        return AlertModel::distribute($alert, $users, $excludeEmittingUser);

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
