<?php

namespace P3in\Models;

use Cache;
use Exception;
use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Collection;
use Modular;
use P3in\Models\Gallery;
use P3in\Models\Permission;
use P3in\Models\Photo;
use P3in\Models\Role;
use P3in\ModularBaseModel;
use P3in\Traits\HasPermissions;
use P3in\Traits\HasProfileTrait;
use Tymon\JWTAuth\Contracts\JWTSubject as AuthenticatableUserContract;

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
        // 'system_user',
    ];

    /**
     *  The attributes excluded from the model's JSON form.
     *
     *  @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        // 'system',
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
     *  Get all the roles this user belongs to
     *
     *
     */
    public function roles()
    {
        return $this->belongsToMany(Role::class)->withTimestamps();
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
     * Sets the password attribute.
     *
     * @param      <type>  $value  The value
     */
    // @TODO doesn't laravel do this automagically? investigate
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

    /**
     * Get users having a specific rol e
     *
     * @param      <type>  $query  The query
     * @param      <type>  $role   The role
     *
     * @return     <type>  ( description_of_the_return_value )
     */
    public static function scopeHavingRole($query, $role)
    {
        return Role::whereName($role)->firstOrFail()->users();
    }

    /**
      * Add current user to a group
      *
      * @param      mixed $role  The role
      *
      * @return     <type>  ( description_of_the_return_value )
      */
    public function assignRole($role)
    {
        if (is_int($role)) {

            $role = Role::findOrFail($role);

        } elseif (is_string($role)) {

            $role = Role::whereName($role)->firstOrFail();

        }

        return $role->addUser($this);
    }

    /**
      *  Remove current user from a group
      */
    public function revokeRole(Role $role)
    {
        return $role->removeUser($this);
    }

    /**
     * Determines if it has role.
     *
     * @param      <type>   $role  The role
     *
     * @return     boolean  True if has role, False otherwise.
     */
    public function hasRole($role)
    {
        try {

            if (is_string($role)) {

                $role = Role::whereName($role)->firstOrFail();

            }

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {

            return false;

        }

        return $role->hasUser($this);

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

            return $this->hasRole(lcfirst(substr($method, 2)));

        }

        return parent::__call($method, $args);

    }

    /**
     * keep this to avoid breaking the api. consider removal. maybe. i'm def in a remove-it-all mood
     *
     * @return     <type>  ( description_of_the_return_value )
     */
    public function allPermissions()
    {
        $this->load('roles.permissions');

        $roles_permissions = [];

        foreach($this->roles as $role) {

            $role_permissions = $role->permissions()
                ->allRelatedIds()
                ->toArray();

            $roles_permissions = array_merge($roles_permissions, $role_permissions);

        }

        return array_unique($roles_permissions);
    }

    /**
     *  Get either all or a specific profile type of a user
     *
     *
     *  TODO: this needs to be refactored a little
     *   -- in pause until we get there
     */
    // public function linkProfile(Model $model)
    // {
    //     $profile = $this->profiles()->firstOrNew([
    //         'profileable_id' => $model->getKey(),
    //         'profileable_type' => get_class($model),
    //     ]);
    //     $profile->save();
    // }

    /**
     * { function_description }
     *
     * @param      <type>  $model_name  The model name
     *
     * @return     <type>  ( description_of_the_return_value )
     */
    // @TODO on a break until we get there
    // public function profile($model_name)
    // {
    //     $base_profile = $this->profiles()->where('profileable_type', $model_name)->first();

    //     return $base_profile ? $base_profile->profileable : null;
    // }

    /**
     * { function_description }
     *
     * @param      <type>  $field_name  The field name
     *
     * @return     array   ( description_of_the_return_value )
     */
    // @TODO this is not being called from codebase
    // public function populateField($field_name)
    // {
    //     switch ($field_name) {
    //         case 'users_list':
    //             $users = User::select(\DB::raw("concat(first_name,' ',last_name) as name"), 'id')->get();

    //             return $users->pluck('name', 'id');
    //             break;
    //         default:
    //             return [];
    //             break;
    //     }
    // }

}
