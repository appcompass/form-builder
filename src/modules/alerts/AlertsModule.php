<?php

namespace P3in\Modules;

use P3in\Models\Alerts;
use P3in\Modules\BaseModule;
use Symfony\Component\Process\Process;

Class AlertsModule extends BaseModule
{

    public $module_name = "alerts";

    public function __construct()
    {
        parent::__construct();
    }

    public function fire()
    {
    }


    public function bootstrap()
    {
    }

    public function register()
    {
        // lets run the npm installs we need for the node scripts that get loaded on vendor publish.

        $path = resource_path('node-scripts');

        $process = new Process("mkdir -p {$path} && cd {$path} && npm install dotenv socket.io ioredis --save");

        $process->run(function ($type, $buffer) {
            echo $type;
            if (Process::ERR === $type) {
                echo 'ERR > '.$buffer;
            } else {
                echo 'OUT > '.$buffer;
            }
        });
    }

}