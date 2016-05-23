<?php

namespace P3in\Modules\Providers;

use Illuminate\Contracts\Auth\Access\Gate as GateContract;
use Illuminate\Foundation\Application;
use P3in\Providers\BaseServiceProvider as ServiceProvider;
use Illuminate\Routing\Router;
use P3in\Middleware\CallIsAuthorized;
use P3in\Models\BlogCategory;
use P3in\Models\BlogPost;
use P3in\Models\BlogTag;
use P3in\Models\Gallery;
use P3in\Models\Group;
use P3in\Models\Page;
use P3in\Models\Permission;
use P3in\Models\Photo;
use P3in\Models\User;
use P3in\Models\Website;
use P3in\Policies\ResourcesPolicy;

class PermissionsServiceProvider extends ServiceProvider
{

    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        Permission::class => ResourcesPolicy::class,
    ];

    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = true;

    /**
     * Laravel
     */
    // protected $app;

    // public function __construct(Application $app)
    // {

    //     $this->app = $app;

    // }

    /**
     * Bootstrap services
     *
     */
    public function boot(GateContract $gate)
    {
        $this->app->router->pushMiddlewareToGroup('web', CallIsAuthorized::class);
    }

    /**
     *   Register bindings in the container
     *
     */
    public function register()
    {


    }

}
