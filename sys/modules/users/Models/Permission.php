<?php

namespace P3in\Models;

use P3in\ModularBaseModel;
use Illuminate\Database\Eloquent\Builder;

class Permission extends ModularBaseModel
{

    protected $table = 'permissions';

    protected $fillable = [
        'name'
    ];

    public function users()
    {
        return $this->belongsToMany(\P3in\Models\User::class);
    }

    // public function assign(PermissableInterface $owner)
    // {

    // }

    public function scopeOf(Builder $builder, \P3in\Models\User $user)
    {
        return $builder->where('user_id', $user->id);
    }

}