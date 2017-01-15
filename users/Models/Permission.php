<?php

namespace P3in\Models;

use Illuminate\Database\Eloquent\Builder;
use P3in\Models\Group;
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
    *   Get groups having this permission
    *
    */
    public function groups()
    {
        return $this->belongsToMany(Group::class);
    }
    // public function assign(PermissableInterface $owner)
    // {

    // }

    public function scopeOf(Builder $builder, User $user)
    {
        return $builder->where('user_id', $user->id);
    }

    /**
    *   Get permission by type
    *
    */
    public function scopeByType($query, $type)
    {
        return $query->where('type', '=', $type);
    }

    /**
     *  Create CpRoutePerm
     *
     */
    public static function createCpRoutePerm($type, $label = null)
    {
        $perm = static::firstOrNew([
            'type' => $type,
        ]);
        $perm->label = $label ?: ucwords(str_replace(['.','-'], ' ', $type));
        $perm->description = 'Permission for the route: '.$type;
        $perm->locked = true;

        $perm->save();

        return $perm->type;
    }
}
