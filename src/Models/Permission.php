<?php

namespace P3in\Models;

use Illuminate\Database\Eloquent\Builder;
use P3in\Models\Role;
use P3in\Models\User;
use P3in\ModularBaseModel;

class Permission extends ModularBaseModel
{
    protected $table = 'permissions';

    protected $fillable = [
        'type',
        'label',
        'description',
        'locked',
    ];

    /**
     *  Model Rules
     *
     */
    public static $rules = [
        'label' => 'required',
        'type' => 'required'
    ];

    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    /**
    *   Get roles having this permission
    *
    */
    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    /**
     *
     *
     * @param      \Illuminate\Database\Eloquent\Builder  $builder  The builder
     * @param      \P3in\Models\User                      $user     The user
     *
     * @return     <type>                                 ( description_of_the_return_value )
     */
    // public function scopeOf(Builder $builder, User $user)
    // {
    //     return $builder->where('user_id', $user->id);
    // }

    /**
    *   Get permission by type
    *
    */
    public function scopeByType($query, $type)
    {
        return $query->where('type', '=', $type);
    }
}
