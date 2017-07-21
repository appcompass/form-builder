<?php

namespace P3in\Traits;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use P3in\Models\Permission;
use P3in\Models\PermissionsRequired;
use P3in\Models\User;

trait HasPermission
{
    public function permission()
    {
        return $this->belongsTo(Permission::class, 'req_perm');
    }

    public function setPermission(string $name)
    {
        try {
            $permission = Permission::byName($name)->firstOrFail();
        } catch (ModelNotFoundException $e) {
            $label = ucwords(str_replace(['-', '_'],' ', $name));
            $permission = Permission::create([
                'name' => $name,
                'label' => $label,
                'description' => $label.' Permission',
            ]);
        }

        $this->permission()->associate($permission);

        return $this;
    }

    public function scopeByAllowed($query, User $user = null)
    {
        $query->whereNull('req_perm')
            ->orWhereHas('permission', function ($query) {
                $query->where('name', 'guest');
            });
        if (!$user && Auth::check()) {
            $user = Auth::user();
        }
        if ($user) {
            // the cache way
            $permIds = (array) Cache::tags('auth_permissions')->get($user->id);
            $query->orWhereIn('req_perm', $permIds);
            // the query way.
            // $query->orWhereHas('permission', function ($query) use ($user) {
            //     $query->whereHas('users', function($query) use ($user) {
            //         $query->where('user_id', $user->id);
            //     })->orWhereHas('roles', function($query) use ($user) {
            //         $query->orWhereHas('users', function($query) use ($user) {
            //             $query->where('user_id', $user->id);
            //         });
            //     });
            // });
        }
    }

}
