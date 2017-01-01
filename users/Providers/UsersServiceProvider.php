<?php

namespace P3in\Providers;

use Illuminate\Contracts\Auth\Access\Gate;
use Illuminate\Foundation\AliasLoader;
use P3in\Providers\BaseServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Validator;
use \Illuminate\Routing\Router;
// use P3in\Commands\AddUserCommand;
// use P3in\Models\Group;
use P3in\Models\User;
// use P3in\Policies\ControllersPolicy;
// use P3in\Policies\ResourcesPolicy;
// use P3in\Profiles\Profile;

Class UsersServiceProvider extends ServiceProvider {

    // protected $policies = [
    //     User::class => ResourcesPolicy::class,
    //     Group::class => ResourcesPolicy::class,
    // ];

    // protected $commands = [
    //     AddUserCommand::class,
    // ];

    /**
     * Subscribe
     */
    // protected $subscribe = [];

    /**
     *  Listen
     */
    // protected $listen = [];

    /**
     * Observe
     */
    // protected $observe = [];

    private $models = [
        'User',
        'Group',
        'UserGroups'
    ];

    public function boot(Gate $gate)
    {
        // \Route::model('user', \P3in\Models\User::class);

        // \App('router')->bind('model', function($value) {
        //     return \P3in\Models\User::findOrFail($value);
        // });


        // $this->commands($this->commands);

        // we clear the profile cache when the Profile Model either saves to, or deletes from it's records.
        // $clearCache = function($profile){
        //     Cache::forget('profile_types');
        // };

        // Profile::saved($clearCache);
        // Profile::deleted($clearCache);
    }

    public function register()
    {
        \Log::info('Running UserSerivceProvider.');

        // foreach ($this->models as $model) {

        //     $this->app->bind(
        //         "\\P3in\\Interfaces\\" . ucfirst($model) . 'sRepositoryInterface::class',
        //         "\\P3in\\Repositories\\" . ucfirst($model) . 'sRepository::class'
        //     );
        // }

        \Route::bind('user', function($value) {
            return \P3in\Models\User::findOrFail($value);
        });

        \Route::bind('permission', function($value) {
            return \P3in\Models\Permission::findOrFail($value);
        });

        \Route::bind('group', function($value) {
            return \P3in\Models\Group::findOrFail($value);
        });

        $this->app->bind(
            \P3in\Interfaces\UsersRepositoryInterface::class, \P3in\Repositories\UsersRepository::class
        );

        $this->app->bind(
            \P3in\Interfaces\GroupsRepositoryInterface::class, \P3in\Repositories\GroupsRepository::class
        );

        $this->app->bind(
            \P3in\Interfaces\UserGroupsRepositoryInterface::class, \P3in\Repositories\UserGroupsRepository::class
        );

        $this->app->bind(
            \P3in\Interfaces\UserPermissionsRepositoryInterface::class, \P3in\Repositories\UserPermissionsRepository::class
        );

        $this->app->bind(
            \P3in\Interfaces\PermissionsRepositoryInterface::class, \P3in\Repositories\PermissionsRepository::class
        );
    }

}
