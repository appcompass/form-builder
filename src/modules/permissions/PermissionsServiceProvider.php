<?php

namespace P3in\Modules\Providers;

use BostonPads\Models\BpFieldUpload;
use BostonPads\Models\BpUnit;
use Illuminate\Contracts\Auth\Access\Gate as GateContract;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
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
use P3in\Policies\UnitsPolicy;

class PermissionsServiceProvider extends ServiceProvider
{


    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = true;

    /**
     * Laravel
     */
    protected $app;

    public function __construct(Application $app)
    {

        // @TODO p3ServiceProivder to inherit from, which could make available some common methods i.e. getting middleware etc...

        $this->app = $app;

    }

    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        Photo::class => ResourcesPolicy::class,
        Website::class => ResourcesPolicy::class,
        Gallery::class => ResourcesPolicy::class,
        Page::class => ResourcesPolicy::class,
        BlogPost::class => ResourcesPolicy::class,
        BlogCategory::class => ResourcesPolicy::class,
        BlogTag::class => ResourcesPolicy::class,
        User::class => ResourcesPolicy::class,
        Permission::class => ResourcesPolicy::class,
        Group::class => ResourcesPolicy::class,
        BpFieldUpload::class => ResourcesPolicy::class,
        BpUnit::class => ResourcesPolicy::class,
        \BostonPads\Models\BpFieldUpload::class => UnitsPolicy::class,
    ];

    /**
     *   Register bindings in the container
     *
     *
     *
     */
    public function register()
    {


    }

    /**
     * Bootstrap services
     *
     *
     *
     */
    public function boot(GateContract $gate)
    {
        $this->app->router->pushMiddlewareToGroup('web', CallIsAuthorized::class);
        parent::registerPolicies($gate);
    }
}