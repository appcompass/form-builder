<?php

namespace P3in\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use P3in\Models\User;
use Illuminate\Database\Eloquent\Collection;

class Role extends Model
{
    protected $fillable = [
      'name',
      'label',
      'description',
      'active'
    ];

    /**
     * Get a role by name
     */
    public function scopeByName(Builder $query, $name)
    {
        return $query->where('name', str_replace(' ', '-', strtolower($name)));
    }

    /**
    *   Link roles and users
    *
    */
    public function users()
    {
        return $this->belongsToMany(User::class)->withTimestamps();
    }

    /**
      * Add a User to the Role
      */
    public function addUser(User $user)
    {
        if (!$this->users->contains($user->id)) {

            return $this->users()->attach($user);

        }

        return false;
    }

    /**
     * remove a user from this role
     */
    public function removeUser(User $user)
    {
        return $this->users()->detach($user);
    }

    /**
    *   Role permissions
    *
    */
    public function permissions()
    {
        return $this->belongsToMany(Permission::class)->withTimestamps();
    }

    /**
     * { function_description }
     *
     * @param      <type>  $perm   The permission
     *
     * @return     <type>  ( description_of_the_return_value )
     */
    public function grantPermission($perm)
    {
        return $this->grantPermissions($perm);
    }

    /**
      * Grant Permission(s)
      *
      * @param mixed $perm  (string) Permission Type | (Permission) Permission Instance | Collection eleoquent collection of perms to sync | (array)
      */
    public function grantPermissions($perm)
    {
        if (is_null($perm)) {

            return;

        } elseif ($perm instanceof \Illuminate\Database\Eloquent\Collection) {

            return $this->permissions()->sync($perm);

        } elseif (is_string($perm)) {

            return $this->grantPermissions(Permission::byType($perm)->firstOrFail());

        } elseif ($perm instanceof Permission) {

            if (!$this->permissions->contains($perm->id)) {

                return $this->permissions()->attach($perm);

            }

            return false;

        } elseif (is_array($perm)) {

            foreach ($perm as $single_permission) {

                $this->grantPermissions($single_permission);

            }

        }

    }

    /**
     *
     */
    public function hasUser(User $user)
    {
        return $this->users->contains($user->id);
    }

    /**
     *  Revoke all role's permissions
     */
    public function revokeAll()
    {
        return $this->revokePermissions($this->permissions->lists('type')->toArray());
    }

    /**
     *
     */
    public function revokePermission($perm)
    {
        return $this->revokePermissions($perm);
    }

    /**
      * Revoke permission(s)
      *
      * @param mixed $perm  (string) Permission Type | (Permission) Permission Instance | (array)
      */
    public function revokePermissions($perm)
    {
        if (is_null($perm)) {

            return;

        } elseif (is_string($perm)) {

            return $this->revokePermissions(Permission::byType($perm)->firstOrFail());

        } elseif ($perm instanceof Permission) {

            return $this->permissions()->detach($perm);

        } elseif (is_array($perm)) {

            foreach ($perm as $single_permission) {

                $this->revokePermissions($single_permission);

            }

        }

    }
}
