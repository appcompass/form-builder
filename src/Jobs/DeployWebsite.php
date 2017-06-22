<?php

namespace P3in\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use P3in\Builders\WebsiteBuilder;
use P3in\Models\Website;

class DeployWebsite implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $website;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Website $website)
    {
        $this->website = $website;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        info('fetching website builder.');
        $wb = WebsiteBuilder::edit($this->website);

        info('starting deployment for '.$this->website->host.'.');
        $result = $wb->compilePages()
            ->compileWebsite()
            ->deploy();
        info('deployment complete.', $result);
    }
}
