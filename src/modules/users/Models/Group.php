<?php

namespace P3in\Models;

use Illuminate\Database\Eloquent\Model;
use P3in\Models\Permission;
use P3in\Models\User;
use P3in\Traits\AlertableTrait;

class Group extends Model
{

	use AlertableTrait;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'groups';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['name', 'label', 'description', 'active'];

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = ['password', 'remember_token'];

	/**
	*	Link groups and users
	*
	*
	*/
	public function users()
	{
		return $this->belongsToMany('P3in\Models\User')->withTimestamps();
	}

	/**
	  * Add a User to the Group
	  */
	public function addUser(User $user)
	{
	  	return $this->users()->attach($user);
	}

	/**
	 * remove a user from this group
	 */
	public function removeUser(User $user)
	{
	  	return $this->users()->detach($user);
	}
	/**
	*	Group permissions
	*
	*
	*/
	public function permissions()
	{
		return $this->belongsToMany('P3in\Models\Permission')->withTimestamps();
	}

	/**
	  *
	  */
	public function grantPermission(Permission $perm)
	{
	  	return $this->permissions()->attach($perm);
	}

	/**
	  *
	  */
	public function revokePermission(Permission $perm)
	{
	  	return $this->permissions()->detach($perm);
	}
}
