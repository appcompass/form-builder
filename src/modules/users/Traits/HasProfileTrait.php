<?php

namespace P3in\Traits;

use P3in\Models\User;
use P3in\Profiles\BaseProfile;

trait HasProfileTrait
{

    public function profile()
    {
        return $this->morphOne(BaseProfile::class, 'profileable');
    }

    public function scopeIncludeUsers($query)
    {
        return $query
            ->leftJoin('profiles', function($join){
                $join->on('profiles.profileable_id', '=', $this->table.'.id')
                    ->where('profiles.profileable_type', '=', get_class($this));
            })
            ->leftJoin('users', 'users.id', '=', 'profiles.user_id');
    }

}
