<?php

namespace P3in\Listeners;

use P3in\Events\Alert as AlertEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class AlertListener
{

    public function __construct()
    {

    }

    public function handle()
    {
        \Log::info(func_get_args());
        \Log::info('Alert event received');
    }

}