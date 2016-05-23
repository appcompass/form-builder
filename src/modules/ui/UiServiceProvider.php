<?php

namespace P3in\Modules\Providers;

use Collective\Html\FormFacade;
use Collective\Html\HtmlFacade;
use Illuminate\Foundation\AliasLoader;
use P3in\Providers\BaseServiceProvider as ServiceProvider;

Class UiServiceProvider extends ServiceProvider
{
    public function boot()
    {

        AliasLoader::getInstance()->alias('Form', FormFacade::class);
        AliasLoader::getInstance()->alias('Html', HtmlFacade::class);

    }

    public function register()
    {

        $this->app->register('Collective\Html\HtmlServiceProvider');


    }

    public function provides()
    {
        //
    }
}