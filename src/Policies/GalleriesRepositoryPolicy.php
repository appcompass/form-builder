<?php

namespace P3in\Policies;

use Carbon\Carbon;
use Illuminate\Auth\Access\HandlesAuthorization;
use P3in\Models\Gallery;
use P3in\Models\User;
use P3in\Repositories\GalleriesRepository;

class GalleriesRepositoryPolicy
{
    use HandlesAuthorization;

    public function before(User $user, $ability)
    {
        if ($user->isAdmin()) {
            return true;
        }
    }

    public function view(User $user, GalleriesRepository $photo)
    {
        return true;
        // return $user->hasPermissions($this->index_perms);
    }

    public function create(User $user, $ability)
    {
        info('creating a photo');
        // return $user->hasPermissions($this->create_perms);
    }

    public function index()
    {
        info('Hit Galleries');
        return true;
    }

    public function store(User $user, GalleriesRepository $gallery)
    {
        // @NOTE this is being hit both on photo upload and gallery creation
        info('Storing a Photo from here?');

        return true;

        return $this->deny('Nup');
    }

    public function show(User $user, GalleriesRepository $repo)
    {
        if ($repo->getModel()->user->id !== $user->id) {

            return $this->deny('You can only see galleries you own.');

        }
        return true;
    }

    public function update(User $user, GalleriesRepository $repo)
    {
        if ($repo->getModel()->user->id !== $user->id) {

            return $this->deny('You cannot update a gallery if you\'re not the owner.');

        }

        return true;
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
