<?php

namespace P3in\Policies;

use Carbon\Carbon;
use P3in\Models\User;

class PhotosPolicy
{
    public function before(User $user, $ability)
    {
        info('Hit');
        // if ($user->isAdmin()) {
        //     return true;
        // }
    }

    public function view(User $user, $ability)
    {
        // info('Checkoing');
        // abort(403);
        // return false;
        // return $user->hasPermissions($this->index_perms);
    }

    public function create(User $user, $ability)
    {
        // return $user->hasPermissions($this->create_perms);
    }

    public function index()
    {
        info('Hit');
        return true;
    }

    public function store(User $user, $ability)
    {
        info('Storing a Photo');
        // return $user->hasPermissions($this->create_perms);
    }

    public function show(User $user, $ability)
    {
        // if ($user->hasPermissions($this->edit_perms)) {
        //     return true;
        // } elseif (is_object($ability) && $ability->user) {
        //     return $user->id == $ability->user->id;
        // }
    }

    public function update(User $user, $ability)
    {
        return false;
        info('Updating a Photo');
        // return $this->show($user, $ability);
    }

    public function edit(User $user, $ability)
    {
        // return $this->show($user, $ability);
    }

    public function destroy(User $user, $ability)
    {
        // if ($user->hasPermissions($this->destroy_perms)) {
        //     return true;
        // } elseif (is_object($ability) && $ability->user) {
        //     $hour_ago = Carbon::now()->subHours(1);

        //     return $user->id == $ability->user->id && $hour_ago->lte($ability->created_at);
        // }
    }
}
