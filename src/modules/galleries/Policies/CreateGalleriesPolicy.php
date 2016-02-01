<?php

namespace P3in\Policies;

use P3in\Models\Gallery;
use P3in\Models\User;

class GalleriesPolicy
{

  public function __construct()
  {

  }

  public function update(User $user, Gallery $gallery)
  {
    return $user->id === $gallery->user_id;
  }

}