<?php

namespace P3in\Jobs;

use Event;
use Illuminate\Bus\Queueable;
use P3in\Models\Alert as AlertModel;
use P3in\Events\Alert as AlertEvent;
use Illuminate\Queue\SerializesModels;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\Collection;


class SendDelayedAlert implements SelfHandling, ShouldQueue
{

    use Queueable, InteractsWithQueue, SerializesModels;

    /**
     *
     */
    private $users;

    /**
     *
     */
    private $alert;

    /**
     *
     */
    private $excludeEmittingUser;

    /**
     *
     */
    public function __construct(AlertModel $alert, Collection $users = null, $excludeEmittingUser = true)
    {
        if (! $alert->exists) {

            $alert->save();

        }

        $this->alert = $alert;

        $this->users = $users;

        $this->excludeEmittingUser = $excludeEmittingUser;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // replace the message {count} with actual count totals
        $this->alert->message = preg_replace('/(\{count\})/i', $this->alert->count, $this->alert->message);

        // replace the title {count} with actual count totals
        $this->alert->title = preg_replace('/(\{count\})/i', $this->alert->count, $this->alert->title);

        $this->alert->save();

        Event::fire(new AlertEvent($this->alert, $this->users, $this->excludeEmittingUser));

    }

}