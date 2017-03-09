<?php

namespace P3in\Models;

use Cache;
use Exception;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Tymon\JWTAuth\Contracts\JWTSubject as AuthenticatableUserContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Auth\Authenticatable;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;
use Modular;
use P3in\Models\Gallery;
use P3in\Models\Group;
use P3in\Models\Permission;
use P3in\Models\Photo;
use P3in\ModularBaseModel;
use P3in\Traits\HasPermissions;
use P3in\Traits\HasProfileTrait;

class User extends ModularBaseModel implements
    AuthenticatableContract,
    AuthenticatableUserContract,
    AuthorizableContract,
    CanResetPasswordContract
{
    use
        Authenticatable,
        Authorizable,
        CanResetPassword,
        Notifiable
        // HasPermissions
        // HasProfileTrait
        ;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * Specifiy the connectin for good measure
     */
    protected $connection = 'pgsql';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'phone',
        'email',
        'password',
        'active',
        'system_user',
    ];

    /**
     *  The attributes excluded from the model's JSON form.
     *
     *  @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'system',
        'activated_at',
        'activation_code'
    ];

    /**
     * Stuff to append to each request
     *
     *
     */
    protected $appends = ['full_name', 'gravatar_url'];

    public static $rules = [
        'first_name' => 'required|max:255',
        'last_name' => 'required|max:255',
        'phone' => 'required|max:255',
        'email' => 'required|email|unique:users|max:255',
        'password' => 'required|min:2|max:255',
    ];

    /**
     *  Get all the groups this user belongs to
     *
     *
     */
    public function groups()
    {
        return $this->belongsToMany(Group::class)->withTimestamps();
    }

    /**
     * Permissions
     *
     * @return     <type>  ( description_of_the_return_value )
     */
    public function permissions()
    {
        return $this->belongsToMany(Permission::class)->withTimestamps();
    }

    /**
     * Photos
     *
     * @return     <type>  ( description_of_the_return_value )
     */
    public function photos()
    {
        return $this->hasMany(Photo::class);
    }

    /**
     * Galleries
     *
     * @return     <type>  ( description_of_the_return_value )
     */
    public function galleries()
    {
        return $this->hasMany(Gallery::class);
    }

    /**
     *  Get either all or a specific profile type of a user
     *
     *
     *  TODO: this needs to be refactored a little
     */
    public function linkProfile(Model $model)
    {
        $profile = $this->profiles()->firstOrNew([
            'profileable_id' => $model->getKey(),
            'profileable_type' => get_class($model),
        ]);
        $profile->save();
    }

    /**
     * { function_description }
     *
     * @param      <type>  $model_name  The model name
     *
     * @return     <type>  ( description_of_the_return_value )
     */
    public function profile($model_name)
    {
        $base_profile = $this->profiles()->where('profileable_type', $model_name)->first();

        return $base_profile ? $base_profile->profileable : null;
    }

    /**
     * { function_description }
     *
     * @param      <type>  $field_name  The field name
     *
     * @return     array   ( description_of_the_return_value )
     */
    public function populateField($field_name)
    {
        switch ($field_name) {
            case 'users_list':
                $users = User::select(\DB::raw("concat(first_name,' ',last_name) as name"), 'id')->get();

                return $users->pluck('name', 'id');
                break;
            default:
                return [];
                break;
        }
    }

    /**
     * Sets the password attribute.
     *
     * @param      <type>  $value  The value
     */
    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = bcrypt($value);
    }

    /**
     *  Get user's full name
     *
     */
    public function getFullNameAttribute()
    {
        return sprintf("%s %s", $this->first_name, $this->last_name);
    }

    /**
     *  Get user's full name
     *
     */
    public function getGravatarUrlAttribute()
    {
        return "https://www.gravatar.com/avatar/" . md5($this->email) . '?d=identicon';
    }

    /**
     * Gets the jwt identifier.
     *
     * @return     <type>  The jwt identifier.
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Gets the jwt custom claims.
     *
     * @return     array  The jwt custom claims.
     */
    public function getJWTCustomClaims()
    {
        return [
             'user' => [
                'id' => $this->id,
                'name' => $this->full_name,
             ]
        ];
    }

    public static function scopeSystemUsers($query)
    {
        return $query->where('system', true)->orderBy('id', 'asc');
    }

    /**
      * Add current user to a group
      *
      * @param      mixed $group  The group
      *
      * @return     <type>  ( description_of_the_return_value )
      */
    public function addToGroup($group)
    {
        if (is_int($group)) {

            $group = Group::findOrFail($group);

        } elseif (is_string($group)) {

            $group = Group::whereName($group)->firstOrFail();

        }

        return $group->addUser($this);
    }

    /**
      *  Remove current user from a group
      */
    public function removeFromGroup(Group $group)
    {
        return $group->removeUser($this);
    }

    /**
     * Adds a permission to the user
     */
    // @TODO static methods on permission to avoid lookup here
    public function grant($permission)
    {
        if (is_array($permission)) {

            foreach($permission as $single_permission) {

                $this->grant($single_permission);

            }

            return true;

        } elseif (is_string($permission)) {

            $permission = Permission::whereType($permission)->firstOrFail();

        } elseif (is_int($permission)) {

            $permission = Permission::findOrFail($permission);

        }

        return $permission->assignTo($this);
    }

    /**
     * Revokes a user's permission
     */
    // @TODO static methods on permission to avoid lookup here
    public function revoke($permission)
    {
        if (is_array($permission)) {

            foreach($permission as $single_permission) {

                $this->revoke($single_permission);

            }

            return true;

        } elseif (is_string($permission)) {

            $permission = Permission::whereType($permission)->firstOrFail();

        } elseif (is_int($permission)) {

            $permission = Permission::findOrFail($permission);

        }

        return $permission->revokeFrom($this);
        // return $this->permissions()->detach($perm);
    }

    /**
     * Determines if it has group.
     *
     * @param      <type>   $group  The group
     *
     * @return     boolean  True if has group, False otherwise.
     */
    public function hasGroup($group)
    {
        try {

            if ($group instanceof Group) {

                $group = $group->name;

            } elseif (is_string($group)) {

                $group = Group::whereName($group)->firstOrFail();

            }

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {

            return false;

        }

        return $group->hasUser($this);

    }

    /**
     * Allows for role/group matching using  is[name] pattern
     *
     * @param      <type>  $method  The method
     * @param      <type>  $args    The arguments
     *
     * @return     <type>  ( description_of_the_return_value )
     */
    public function __call($method, $args)
    {

        if (preg_match('/^is/', $method)) {


            return $this->hasGroup(lcfirst(substr($method, 2)));

        }

        return parent::__call($method, $args);

    }

    /**
     * Return all the permissions of the user
     *
     * @return array permission owned by the user
     */
    public function allPermissions()
    {
        // @TODO  add getCacheKey or something, the id is overly non-specific. should return class_name . id . updated_at_timestamp

        return Cache::tags('user_permissions')->remember('user_'.$this->id.'_'.$this->updated_at, 1, function() {
        // return Cache::remember('user_'.$this->id.'_'.$this->updated_at, 1, function() {

            $directly_owned = $this->permissions->pluck('id')->toArray();

            // $all_permissions = array_unique(array_merge($this->getGroupsPermissions(), $directly_owned));

            return array_unique(array_merge($this->getGroupsPermissions(), $directly_owned));

            // return Permission::whereIn('id', $all_permissions)->get()->toArray();

        });
    }

    /**
     * Gets the groups permissions.
     */
    public function getGroupsPermissions()
    {
        // $this->load('groups.permissions');

        $groups_permissions = [];

        foreach($this->groups as $group) {

            $group_permissions = $group->permissions()
                ->allRelatedIds()
                ->toArray();

            $groups_permissions = array_merge($groups_permissions, $group_permissions);

        }

        return array_unique($groups_permissions);
    }

    /**
     *  Check if user has a single permission
     *
     *  @param string $permission Permission type.
     *  @return bool
     */
    // public function hasPermission($permission)
    // {

    //     if (is_array($permission)) {

    //         return $this->hasPermissions($permission);

    //     }

    //     return in_array($permission, $this->allPermissions()->toArray());

    // }

    /**
     *  Check if user has a group of permissions
     *
     *  @param array permissions
     *  @return bool
     */
    // public function hasPermissions($permissions)
    // {
    //     if (is_string($permissions)) {
    //         $permissions = explode(",", $permissions);
    //     }

    //     if (count($permissions) == 0) {
    //         return true;
    //     }

    //     return (bool)count(array_intersect($this->allPermissions()->toArray(), $permissions)) == count($permissions);

    // }

}
