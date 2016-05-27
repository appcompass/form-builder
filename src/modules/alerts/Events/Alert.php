<?php

namespace P3in\Events;

use Auth;
use App\Events\Event;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Queue\SerializesModels;
use P3in\Models\User;
use P3in\Models\Alert as AlertStorage;

class Alert extends Event implements ShouldBroadcast
{
    use SerializesModels;

    /**
     * all public properties are exported, we only care about the hash
     */
    public $hash;

    /**
     * Create a new event instance.
     *
     *  @TODO too many parameters, build a class!! <- MOVE TO ALERT INJECT
     */
    public function __construct($title, $message, $level, $model, $icon = null)
    {

        // leave it like this, we need to be able to hit the method even if model is null
        if (is_null($model)) {

            dd("Model was empty");

        }

        $this->title = $title;

        $this->message = $message;

        $props = [
            'icon' => $icon
        ];

        // @TODO this will become a firstOrNew in case the alert is subject to rate limitation

        $alert = new AlertStorage([
            'title' => $title,
            'message' => $message,
            'req_perms' => 'alerts.info',
            'hash' => bcrypt(time()),
            'level' => 'info',
            'props' => json_encode($props)
        ]);


        $alert->alertable_id = $model->id;

        $alert->alertable_type = get_class($model);

        $alert->save();

        $this->hash = $alert->hash;

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
        return ['test-channel'];
    }
}
