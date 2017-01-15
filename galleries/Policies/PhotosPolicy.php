<?php

namespace P3in\Policies;

use Carbon\Carbon;
use P3in\Models\User;

class PhotosPolicy
{
    private $index_perms = [
        'photos.index',
        'galleries.photos.index',
    ];

    private $create_perms = [
        'photos.create',
        'galleries.photos.create',
    ];

    private $edit_perms = [
        'photos.edit',
        'galleries.photos.edit',
    ];

    private $destroy_perms = [
        'photos.destroy',
        'galleries.photos.destroy',
    ];

    public function before(User $user, $ability)
    {
        if ($user->isRoot() || $user->isManager()) {
            return true;
        }
    }

    public function index(User $user, $ability)
    {
        return $user->hasPermissions($this->index_perms);
    }

    public function create(User $user, $ability)
    {
        \Log::info($user->allPermissions());
        return $user->hasPermissions($this->create_perms);
    }

    public function store(User $user, $ability)
    {
        return $user->hasPermissions($this->create_perms);
    }

    public function show(User $user, $ability)
    {
        if ($user->hasPermissions($this->edit_perms)) {
            return true;
        } elseif (is_object($ability) && $ability->user) {
            return $user->id == $ability->user->id;
        }
    }

    public function update(User $user, $ability)
    {
        return $this->show($user, $ability);
    }

    public function edit(User $user, $ability)
    {
        return $this->show($user, $ability);
    }

    public function destroy(User $user, $ability)
    {
        if ($user->hasPermissions($this->destroy_perms)) {
            return true;
        } elseif (is_object($ability) && $ability->user) {
            $hour_ago = Carbon::now()->subHours(1);
            return $user->id == $ability->user->id && $hour_ago->lte($ability->created_at);
        }
    }
}
