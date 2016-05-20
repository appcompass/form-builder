<?php

namespace P3in\Traits;

use P3in\Models\User;

trait IsProfileTrait
{

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
