<?php

namespace P3in\Policies;

use P3in\Models\User;

class UnitsPolicy
{

    public function before(User $user)
    {
        if ($user->isRoot()) {

            return true;

        }
    }

    public function index(User $user, $ability)
    {
        return true;
    }

    public function destroy(User $user, $ability)
    {

        return $user->isRoot();

    }

    public function edit(User $user, $ability)
    {

        if (is_object($ability)) {

            return $user->id === $ability->user_id;

        } else {

            return true;

        }

    }

}