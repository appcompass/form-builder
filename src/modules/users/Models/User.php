<?php

namespace P3in\Models;

use BostonPads\Models\Gallery;
use BostonPads\Models\Photo;
use Exception;
use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Contracts\Container\Container;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Modular;
use P3in\Models\Group;
use P3in\Models\Permission;
use P3in\Profiles\BaseProfile;
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

		if (!Modular::isDef('permissions')) {

			throw new Exception("Permissions module is not loaded. Please load it before calling this method");

		}

		return $this->belongsToMany(Permission::class)->withTimestamps();

	}

	/**
	 *	Check if user has a single permission
	 *
	 *	@param string $permission Permission type.
	 *	@return bool
	 */
	public function hasPermission($permission)
	{

		if (! Modular::isDef('permissions')) {

			throw new Exception("Permissions module is not loaded. Please load it before calling this method");

		}

		return $this->permissions()
			->where('type', $permission)
			->count();
	}

	/**
	 *	Check if user has a group of permissions
	 *
	 *	@param array permissions
	 */
	public function hasPermissions(array $permissions) {

		return $this->permissions()
			->whereIn('type', $permissions)
			->count();

	}

	/**
	 *  Get all the groups this user belongs to
	 *
	 */
	public function groups()
	{

		return $this->belongsToMany(Group::class);

	}

	/**
	 *
	 *
	 *
	 *
	 */
	public function profiles($type = null)
	{

	  $relation = $this->hasMany(BaseProfile::class);

	  if (! is_null($type)) {

	  	$profile_class = $relation->where('model', $type)->firstOrFail();

	  	return new $profile_class->model($profile_class->toArray());

	  }

	  return $relation;

	}

	/**
	 *	Get user's full name
	 *
	 */
	public function getFullNameAttribute()
	{

		return sprintf("%s %s", $this->first_name, $this->last_name);

	}

	/**
	 *		Get galleries owned by the user
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
	 *	Get photos owned by the user
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
	 *	Get/Set user's Avatar
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

				$this->avatar()
					->first()
					->unlink();

			}

			$this->avatar()->save($photo);

		}

		return $this->morphOne(Photo::class, 'photoable');

	}

	/**
 	 *	Get agent's status
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
}
