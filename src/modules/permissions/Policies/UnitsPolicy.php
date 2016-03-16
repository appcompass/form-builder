<?php

namespace P3in\Policies;

use P3in\Models\User;

class UnitsPolicy
{

    public function before(User $user, $ability)
    {

        if ($user->isRoot()) {

            return true;

        }
    }

    public function show(User $user, $ability)
    {
        foreach(\Request::route()->parameters('unit_field_upload_galleries') as $val) {

            return $val->user_id == $user->id;

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

            return $user->id == $ability->user_id;

        } else {

            return true;

        }

    }

}