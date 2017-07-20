<?php

namespace P3in\Traits;

use Illuminate\Support\Facades\Auth;
use P3in\Models\Permission;
use P3in\Models\PermissionsRequired;

trait HasPermission
{
    public function permission()
    {
        return $this->belongsTo(Permission::class, 'req_perm');
    }

    public function setPermission(string $type)
    {
        $permission = Permission::byName($type)->firstOrFail();
        $this->permission()->associate($permission);
        return $this;
    }

    public function scopeByAllowed($query)
    {
        $query->whereNull('req_perm');
        if (Auth::check()) {
            $query->orWhereHas('permission', function ($query) {
                $query->whereHas('roles', function ($query) {
                    $query->whereHas('users', function ($query) {
                        $query->where('id', Auth::user()->id);
                    });
                });
            });
        }
    }

}
