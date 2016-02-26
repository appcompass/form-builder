<?php

namespace P3in\Traits;

use P3in\Models\User;
use P3in\Profiles\BaseProfile;

trait hasProfileTrait
{

    public function user()
    {
        return $this->hasOne(User::class);
    }

    public function profile()
    {
        return $this->morphOne(BaseProfile::class, 'profileable');
    }

}