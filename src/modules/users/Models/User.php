<?php

namespace P3in\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Container\Container;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use P3in\Models\Permission;
use P3in\Models\Group;
use P3in\Traits\AlertableTrait as Alertable;
use \Modules;
use \Exception;

class User extends Model implements AuthenticatableContract, CanResetPasswordContract
{
	use Authenticatable, CanResetPassword, Alertable;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'users';

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
		'active'
	];

	/**
	*	How Alert Prop field should be filtered for this query
	*	gets converted in props->>'<propname>' = Model Property value
	*	for example: $alertProps = ['id'] /// User->id = 5 /// whereRaw("props->'id' = value")
	*
	*/
	protected $alert_props = ['id'];

	/**
	 * 	The attributes excluded from the model's JSON form.
	 *
	 * 	@var array
	 */
	protected $hidden = ['password', 'remember_token'];

	/**
	*	Get all the permissions the user has
	*
	*
	*/
	public function permissions()
	{
		if (\Modules::isDef('permissions')) {
			return $this->belongsToMany('P3in\Models\Permission')->withTimestamps();
		}

		throw new Exception("Permissions module is not loaded. Please load it before calling this method");
	}

	/**
	*	Check if user has a single permission
	*
	*
	*/
	public function hasPermission($permission)
	{

		if (\Modules::isDef('permissions')) {

			return $this->permissions()->where('name', $permission)->count();

		}

		throw new Exception("Permissions module is not loaded. Please load it before calling this method");
	}

	/**
	*	Check if use has a group of permissions
	*
	*	@param array permissions
	*/
	public function hasPermissions($permissions) {

		if (is_array($permissions)) {

			return $this->permissions()->whereIn('name', $permissions)->count();

		}

		return false;
	}

	/**
	*  Get all the groups this user belongs to
	*		we can do this because Groups and Uses are wrapped in the same module
	*/
	public function groups()
	{
		return $this->belongsToMany('P3in\Models\Group')->withTimestamps();
	}

	/**
	*	Get user's full name
	*
	*
	*
	*/
	public function getFullNameAttribute()
	{
		return sprintf("%s %s", $this->first_name, $this->last_name);
	}

	/**
	*	Get agent's status
	*
	*
	*
	*/
	public function getAgentStatusAttribute()
	{

		$statuses = [
			'FC',
			'PC',
			'ST',
		];

		$k = array_rand($statuses);

		return $statuses[$k];
	}

	public function getClassProgressAttribute()
	{
		$emailLength = strlen($this->email)*2;
		if ($emailLength == 50) {
			return 100;
		}elseif($emailLength < 50 && $emailLength >= 34){
			return $emailLength*2;
		}elseif($emailLength < 34){
			return $emailLength;
		}
	}

	public function getClassProgressStatusAttribute()
	{
		if ($this->class_progress == 100) {
			return 'success';
		}elseif($this->class_progress < 100 && $this->class_progress >= 50){
			return 'warning';
		}elseif($this->class_progress < 34){
			return 'danger';
		}
	}

	public function getSiteRegisteredOnAttribute()
	{
		$sites = [
			'bostonpads.com',
			'allstonpads.com',
			'cambridgepads.com',
		];
		$k = array_rand($sites);
		return $sites[$k];
	}

	/**
	*		get users' saved properties
	*
	*
	*
	*/
	public function getSavedPropertiesAttribute()
	{
		if (Modules::isDef()) {}
		return rand(0,100);
	}

	/**
	*		If Gallery module is loaded we get all the medias linked to the users
	*
	*
	*
	*/
	public function galleries()
	{

		if (!Modules::isDef('galleries')) {

			throw new Exception('Galleries module not loaded, unable to fetch relationship.');

		}

			return $this->hasMany('P3in\Models\Gallery');

	}

	/**
	*
	*
	*
	*
	*/
	public function photos()
	{

		if (!Modules::isDef('photos')) {

			throw new Exception('Photos module not loaded, unable to fetch relationship.');

		}

	  return $this->hasMany('P3in\Models\Photo');

	}


	/**
	*
	*
	*
	*/
	public static function avatar($size = 29)
	{
		$userEmail = \Auth::user()->email;
		return "http://www.gravatar.com/avatar/".md5($userEmail)."?s={$size}";
	}
}
