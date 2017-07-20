<?php

namespace P3in\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notification;
use P3in\Traits\HasPermissions;
use P3in\Models\User;

class Role extends Model
{
    use HasPermissions;

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
     *
     */
    public function hasUser(User $user)
    {
        return $this->users->contains($user->id);
    }

    public function notify(Notification $notification)
    {
        return \Notification::send($this->users, $notification);
    }
}
