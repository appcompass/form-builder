<?php

namespace P3in\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use P3in\Repositories\GalleryPhotosRepository;
use P3in\Models\Gallery;
use P3in\Models\Photo;
use P3in\Models\User;
use Carbon\Carbon;

class GalleryPhotosRepositoryPolicy
{
    use HandlesAuthorization;

    // @TODO move before up in the inheritance chain and inherit it
    public function before(User $user, $ability)
    {
        if ($user->isAdmin()) {

            return true;

        }
    }

    public function index(User $user)
    {
        return true;
    }

    public function store(User $user, GalleryPhotosRepository $repo)
    {
        $gallery = $repo->getParent();

        if ($repo->getParent()->user->id !== $user->id) {

            return $this->deny('You cannot upload images to this gallery.');

        }

        return true;
    }

    public function destroy(User $user, GalleryPhotosRepository $repo)
    {
        if ($repo->getParent()->user->id !== $user->id || $repo->getModel()->user_id !== $user->id) {

            return $this->deny('Why would you think you can delete that doesn\'t belong you.');

        }

        return true;
    }
}
