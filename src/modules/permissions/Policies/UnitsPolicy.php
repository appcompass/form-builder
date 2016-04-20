<?php

namespace P3in\Policies;

use P3in\Models\User;

class UnitsPolicy
{

    private $base_perms = [
        'unit-field-upload-galleries.index',
        'units.index',
    ];

    private $manager_perms = [
        'units.edit',
    ];

    public function before(User $user, $ability)
    {
        if ($user->isRoot()) {

            return true;

        }
    }

    public function show(User $user, $ability)
    {
        $model = \Request::route()->parameter('unit_field_upload_galleries');

        return $user->id == $model->user_id;
    }

    public function index(User $user, $ability)
    {
        return $user->hasPermissions($this->base_perms);
    }

    public function edit(User $user, $ability)
    {
        if (is_object($ability)) {

            return $user->id == $ability->user_id;

        } else {

            return $user->hasPermissions(array_merge($this->base_perms, $this->manager_perms));

        }
    }

    public function destroy(User $user, $ability)
    {
        return $this->edit($user, $ability);

    }

}
