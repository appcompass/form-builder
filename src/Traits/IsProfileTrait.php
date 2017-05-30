<?php

namespace P3in\Traits;

use App\User;

trait IsProfileTrait
{
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scopeIncludeUsers($query)
    {
        return $query->leftJoin('users', 'users.id', '=', $this->table.'.user_id');
    }
}
