<?php

namespace P3in\Policies;

use P3in\Requests\FormRequest;
use P3in\Models\Permission;
use P3in\Models\PermissionsRequired;
use P3in\Models\User;

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
        info('Hit');

        return false;
    }

    public function show(User $user)
    {
        info('Hit Show');

        return false;
    }

}
