<?php

namespace P3in\Traits;

use P3in\Models\User;
use P3in\Profiles\BaseProfile;

trait HasProfileTrait
{

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function profile()
    {
        return $this->morphOne(BaseProfile::class, 'profileable');
    }

    public function scopeIncludeUsers($query)
    {
        return $query->leftJoin('users', 'users.id', '=', $this->table.'.user_id');
    }

}