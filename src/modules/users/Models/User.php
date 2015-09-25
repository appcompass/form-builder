<?php

namespace P3in\Models;

use BostonPads\Models\Gallery;
use BostonPads\Models\Photo;
use Exception;
use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Contracts\Container\Container;
use Illuminate\Database\Eloquent\Model;
use Modular;
use P3in\Models\Group;
use P3in\Models\Permission;
use P3in\Traits\AlertableTrait as Alertable;

class User extends Model implements AuthenticatableContract, CanResetPasswordContract
{
	use Authenticatable, CanResetPassword, Alertable, Authorizable;

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
		if (Modular::isDef('permissions')) {
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

		if (Modular::isDef('permissions')) {

			return $this->permissions()->where('type', $permission)->count();

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

			return $this->permissions()->whereIn('type', $permissions)->count();

		}

		return false;
	}

	/**
	*  Get all the groups this user belongs to
	*
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
		if (Modular::isDef()) {}
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

		if (!Modular::isDef('galleries')) {

			throw new Exception('Galleries module not loaded, unable to fetch relation.');

		}

		return $this->hasMany(Gallery::class);

	}

	/**
	*
	*
	*
	*
	*/
	public function photos()
	{

		if (! Modular::isDef('photos')) {

			throw new Exception('Photos module not loaded, unable to fetch relation.');

		}

		return $this->hasMany(Photo::class);

	}

	/**
	*
	*
	*
	*/
	public function avatar(Photo $photo = null)
	{

		if (! Modular::isDef('photos')) {

			$userEmail = \Auth::user()->email;
			return "http://www.gravatar.com/avatar/".md5($userEmail)."?s={$size}";

		}


		if (! is_null($photo)) {

			if (! is_null($this->avatar)) {

				$this->avatar()->first()->delete();

			}

			$this->avatar()->save($photo);

		}

		return $this->morphOne(Photo::class, 'photoable');

	}
}
