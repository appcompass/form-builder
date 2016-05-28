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
     * all public properties are exported, we only care about the id
     */
    public $id;

    /**
     * Fire an Alert
     *
     * @param P3in\Models\Alert $alert
     * @param Illuminate\Eloquent\Model $model for polymorphic reference
     * @param Eloquent\Collection $users users to distribute the alert to
     * @param bool excludeEmittingUser exclude the user emitting the event Alert->emitted_by
     */
    public function __construct(AlertModel $alert, Model $model, Collection $users = null, $excludeEmittingUser = true)
    {

        $alert->alertable_id = $model->id;

        $alert->alertable_type = get_class($model);

        $alert->save();

        // this is the only information we're putting on the queue/socket
        $this->id = $alert->id;

        // @TODO move this to a collectUsers() method
        if (is_null($users)) {

            if ($alert->req_perm) {

                try {

                    $perm = Permission::byType($alert->req_perm)->firstOrFail();

                    $users = $perm->users();

                } catch (ModelNotFoundException $e) {

                    $users = [];

                    \Log::warning("Alert permission was set to " . $alert->req_perm . " but no such permissions seems to exist.");

                }

            } else {

                \Log::info("Alert $alert->id created with no permissions assigned.");

                $users = [];

            }

        }

        AlertModel::distribute($alert, $users, $excludeEmittingUser);

        \Log::info('Alert stored, event fired');

        return true;

    }

    /**
     * Get the channels the event should be broadcast on.
     *
     * @return array
     */
    public function broadcastOn()
    {
        return ['auth-events'];
    }
}
