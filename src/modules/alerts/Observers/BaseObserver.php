<?php

namespace P3in\Observers;

use Illuminate\Cache\RedisStore;
use P3in\Jobs\SendDelayedAlert;
use P3in\Models\Alert as AlertModel;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Bus\DispatchesJobs;

class BaseObserver
{

    use DispatchesJobs;

    /**
     *  we don't want child classes to play with the store directly
     *  let's keept it tight and keep all the redis related stuff here
     */
    private $redis;

    public function __construct(RedisStore $store)
    {
        $this->redis = $store->getRedis();
    }

    /**
     * Fire the alert
     *
     * @param AlertModel $alert the alert that will be fired
     * @param Collection $user Eloquent collection of users to be sent the alert to
     * @param bool excludeEmittingUser whether the user that emits the event should be removed from the list of recipients
     * @param int timeout number of seconds the alert should collect data for (0: send out asap)
     */
    public function fire(AlertModel $alert, Collection $user = null, $excludeEmittingUser = true, $timeout = 0)
    {
        // if the alert has been created in this same request
        // we dispatch the job on the default queue
        if ($alert->wasRecentlyCreated) {

            $alert->count = 1;

            $alert->save();

            $job_id = $this->dispatch(
                (new SendDelayedAlert($alert, null, $excludeEmittingUser))->delay($timeout)
            );

            $alert->job_id = $job_id;

            $alert->save();

        // otherwise we simply increment the alert's counter and increment the job
        // scheduled time by $timeout
        } else {

            if (! $alert->job_id) {

                throw new \Exception('Queue job_id must be set. Something is wrong with this alert.');

            }

            $alert->increment('count');

            $this->updateExpireTime($alert->job_id, 'default:delayed', $timeout);

        }

        return true;

    }

    /**
     *  updateExpireTime
     *
     *  Update expire time of a job in the queue using redis
     */
    public function updateExpireTime($job_id, $queue = 'default:delayed', $expires_in = 60)
    {
        $queue = 'queues:' . $queue;

        // filter out the job we're looking for in the queued
        $queued_jobs = array_flip($this->redis->command('zrange', [$queue, 0, -1, 'WITHSCORES']));

        $job = collect($queued_jobs)
            ->map(function($item) {
                return json_decode($item);
            })
            ->reject(function($item) use($job_id) {
                return $item->id != $job_id;
            });

        if (!count($job) || count($job) > 1) {

            return;

        }

        if ($job) {

            $ends = \Carbon\Carbon::now()->addSeconds($expires_in);

            $currently_ends = \Carbon\Carbon::createFromTimestamp($job->keys()->first());

            if ($currently_ends->lt($ends)) {

                $this->redis->command('zadd', [$queue, $ends->timestamp, json_encode($job->first())]);

            }

        }

    }

}