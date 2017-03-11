<?php

namespace P3in\Policies;

use P3in\Models\Permission;
use P3in\Models\PermissionsRequired;
use P3in\Models\Resource;
use P3in\Models\User;
use P3in\Requests\FormRequest;
use Route;

class ResourcesPolicy
{
    /**
     *  Check for root
     */
    public function before($user, $perm)
    {
        if ($user->isAdmin()) {

            return true;

        }
    }

    public function index(User $user)
    {
        $role = Resource::resolve(Route::currentRouteName())->req_role;

        if (is_null($role)) {

            return true;
        }

        return $user->hasRole($role);


        return false;
    }

    public function show(User $user)
    {
        info('Hit Show');

        return true;
    }

}
