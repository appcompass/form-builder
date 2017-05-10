<?php
namespace P3in\Traits;

use Auth;
use P3in\Models\Role;

trait HasRole
{
    public function role()
    {
        return $this->belongsTo(Role::class, 'req_role');
    }

    public function setRole(string $name)
    {
        $role = Role::byName($name)->firstOrFail();
        $this->role()->associate($role);
        return $this;
    }

    public function scopeByAllowedRole($query)
    {
        $query->whereNull('req_role');
        if (Auth::check()) {
            $query->orWhereHas('role', function ($query) {
                $query->whereHas('users', function ($query) {
                    $query->where('id', Auth::user()->id);
                });
            });
        }
    }
}
