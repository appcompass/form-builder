<?php

namespace P3in\Models;

use Illuminate\Database\Eloquent\Builder;
use P3in\ModularBaseModel;

class Permission extends ModularBaseModel
{
    protected $table = 'permissions';

    protected $fillable = [
        'name',
        'label',
        'description',
        'system',
    ];

    /**
     *  Model Rules
     *
     */
    public static $rules = [
        'name' => 'required',
        'label' => 'required',
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
     * @param      \Illuminate\Database\Eloquent\Builder $builder The builder
     * @param      \App\User                             $user    The user
     *
     * @return     <type>                                 ( description_of_the_return_value )
     */
    // public function scopeOf(Builder $builder, User $user)
    // {
    //     return $builder->where('user_id', $user->id);
    // }

    /**
     *   Get permission by name
     *
     */
    public function scopeByName($query, $name)
    {
        return $query->where('name', $name);
    }
}
