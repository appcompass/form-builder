<?php

namespace P3in\Models;

use Illuminate\Database\Eloquent\Builder;
use P3in\Models\Group;
use P3in\Models\User;
use P3in\ModularBaseModel;
use Illuminate\Database\Eloquent\Model;

class Permission extends ModularBaseModel
{
    protected $fillable = [
        'type',
        'label',
        'description',
        'locked',
    ];

    // @TODO observables allows to fireModelEvent, picked up by observer
    // we are not really using it in this case (doesn't work on pivots)
    // but it super cool so i wanna keep track of it
    protected $observables = ['granted', 'removed'];

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
    *   Get groups having this permission
    *
    */
    public function groups()
    {
        return $this->belongsToMany(Group::class);
    }

    /**
     * Assign Permission to entity
     *
     * @param      <type>  $owner  The owner
     */
    public function assignTo(Model $owner)
    {
        if (method_exists($owner, 'permissions')) {

            if (!$owner->permissions()->where('permissions.id', $this->id)->exists()) {

                return $owner->permissions()->attach($this->id);

            }

            $this->fireModelEvent('granted', $owner);

        } else {

            throw new \Exception('Model is not linked to permissions');

        }
    }

    /**
     * { function_description }
     */
    public function revokeFrom(Model $owner)
    {
        if ($owner->permissions()->where('permissions.id', $this->id)->exists()) {

            $owner->permissions()->detach($this->id);

            $this->fireModelEvent('revoked', $owner);

            return true;

        }

    }

    /**
     * Of Scope
     *
     * @param      \Illuminate\Database\Eloquent\Builder  $builder  The builder
     * @param      \P3in\Models\User                      $user     The user
     *
     * @return     <type>                                 ( description_of_the_return_value )
     */
    // @TODO remove me
    public function scopeOf(Builder $builder, User $user)
    {
        return $builder->where('user_id', $user->id);
    }

    /**
    *   Get permission by type
    *
    */
    // @TODO this should also go
    public function scopeByType($query, $type)
    {
        return $query->where('type', '=', $type);
    }

}
