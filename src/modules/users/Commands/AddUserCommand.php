<?php

namespace P3in\Commands;

use Illuminate\Console\Command;

class AddUserCommand extends Command
{
    /**
    * The name and signature of the console command.
    *
    * @var string
    */
    protected $name = 'p3cms:add-users';

    /**
    * The console command description.
    *
    * @var string
    */
    protected $description = 'Add a User';

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

        $this->info('Reached!');


    }
}
