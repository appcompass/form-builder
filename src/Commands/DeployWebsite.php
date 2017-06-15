<?php

namespace P3in\Commands;

use Illuminate\Console\Command;
use P3in\Builders\PageBuilder;
use P3in\Builders\WebsiteBuilder;
use P3in\Models\Permission;
use P3in\Models\Role;
use App\User;
use P3in\Models\Website;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Process\Process;

class DeployWebsite extends Command
{
    /**
    * The name and signature of the console command.
    *
    * @var string
    */
    protected $name = 'pilot-io:deploy-website';

    /**
    * The console command description.
    *
    * @var string
    */
    protected $description = 'Deploy a website';

    /**
    * Create a new command instance.
    *
    * @return void
    */
    public function __construct()
    {
        parent::__construct();
    }

    /**
    * Execute the console command.
    *
    * @return mixed
    */
    public function handle()
    {
        $this->info('Lets get started!');
        $host = $this->argument('host');

        $website = Website::where('host', $host)->firstOrFail();

        $wb = WebsiteBuilder::edit($website);

        $wb->storePages()->storeWebsite();

        // run the local build.
        $process = new Process('npm install && npm run build', $wb->getStorePath(), null, null, null); //that last null param disables timeout.
        $process->run(function ($type, $buffer) {
            $this->line($buffer);
            // if (Process::ERR === $type) {
            //     $this->error($buffer);
            // } else {
            //     $this->info($buffer);
            // }
        });

        $wb->deploy();
    }

  /**
   *    Get the console command options.
   *
   *    @return array
   */
    protected function getArguments()
    {
        return [
            ['host', InputArgument::REQUIRED, "The hostname of the website you wish to deploy."]
        ];
    }
}
