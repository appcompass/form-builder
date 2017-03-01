<?php

namespace P3in\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use P3in\Models\Permission;
use P3in\Models\User;
use Illuminate\Database\Eloquent\Collection;

class Group extends Model
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'groups';

    /**
     * Administrators Name
     */
    const ADMINISTRATORS_NAME = 'cp-admin';
    const MANAGERS_NAME = 'bostonpads-managers';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'label', 'description', 'active'];

    /**
     * Validation rules
     */
    public static $rules = [
        'name' => 'required',
        'label' => 'required'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];

    /**
     * Get a group by name
     */
    public function scopeByName(Builder $query, $name)
    {
        return $query->where('name', str_replace(' ', '-', strtolower($name)));
    }

    /**
     *
     */
    public function scopeAdministrators(Builder $query)
    {
        return $query->where('name', Group::ADMINISTRATORS_NAME)->first();
    }

    /**
     *
     */
    public function scopeManagers(Builder $query)
    {
        return $query->where('name', Group::MANAGERS_NAME)->first();
    }

    /**
    *   Link groups and users
    *
    */
    public function users()
    {
        return $this->belongsToMany(User::class)->withTimestamps();
    }

    /**
      * Add a User to the Group
      */
    public function addUser(User $user)
    {

        if (!$this->users->contains($user->id)) {

            return $this->users()->attach($user);

        }

        return false;
    }

    /**
     * remove a user from this group
     */
    public function removeUser(User $user)
    {
        return $this->users()->detach($user);
    }

    /**
    *   Group permissions
    *
    */
    public function permissions()
    {
        return $this->belongsToMany(Permission::class)->withTimestamps();
    }

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

        } else if ($perm instanceof \Illuminate\Database\Eloquent\Collection) {

            return $this->permissions()->sync($perm);

        } else if (is_string($perm)) {

            return $this->grantPermissions(Permission::byType($perm)->firstOrFail());

        } else if ($perm instanceof Permission) {

            if (!$this->permissions->contains($perm->id)) {

                return $this->permissions()->attach($perm);

            }

            return false;

        } else if (is_array($perm)) {

            foreach($perm as $single_permission) {

                $this->grantPermissions($single_permission);

            }

        }
    }

    /**
     *
     */
    public function hasUser(User $user)
    {
        return $this->users()->has($user->id);
    }

    /**
     *  Revoke all group's permissions
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

        } else if ( is_string($perm)) {

            return $this->revokePermissions(Permission::byType($perm)->firstOrFail());

        } else if ($perm instanceof Permission) {

            return $this->permissions()->detach($perm);

        }  else if (is_array($perm)) {

            foreach($perm as $single_permission) {

                $this->revokePermissions($single_permission);

            }

        }
    }
}
