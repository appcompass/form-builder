<?php

namespace P3in\Models;

// use P3in\Models\Website;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use P3in\Interfaces\PermissionRequiredItemInterface as PermissionItemContract;

class PermissionsRequired extends Model
{

    protected $table = 'permissions_required';

    /**
     *  A specific permission_required belongs to a website
     */
    public function website()
    {
        return $this->belongsTo(Website::class);
    }

    /**
     *  Permission_required references a single Permission
     */
    public function permission()
    {
        return $this->belongsTo(Permission::class);
    }

    /**
     *
     *  @param mixed owner [route/controller@method@]
     */
    public static function requirePermission(PermissionItemContract $owner, Permission $requires)
    {
        $instance = new static();

        $instance->pointer = $owner;

        $instance->permission()->save($permission);

        $instance->website()->save(Website::current());

        $instance->save();
    }

    /**
     *  Returns a call to the `how` method on the PermissionItem
     */
    public function scopeRetrieve(Builder $query, PermissionItemContract $perm)
    {

        try {

            $requires = $perm->how($query);

            return $requires;

        } catch (ModelNotFoundException $e) {

            return null;

        }

    }
}
