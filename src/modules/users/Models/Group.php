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
	 * Validation rules
	 */
	public static $rules = [
		'name' => 'required',
		'label' => 'required'
	];

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
	*/
	public function permissions()
	{
		return $this->belongsToMany('P3in\Models\Permission')->withTimestamps();
	}

	public function grantPermission($perm)
	{
	  	return $this->grantPermissions($perm);
	}

	/**
	  * Grant Permission(s)
	  *
	  *	@param mixed $perm  (string) Permission Type | (Permission) Permission Instance | (array)
	  */
	public function grantPermissions($perm)
	{
		if (is_null($perm)) {

			return;

		} else 	if ( is_string($perm)) {

			return $this->grantPermissions(Permission::byType($perm)->firstOrFail());

		} else if ($perm instanceof Permission) {

		  	return $this->permissions()->attach($perm);

		} else if (is_array($perm)) {

			foreach($perm as $single_permission) {

				$this->grantPermissions($single_permission);

			}

		}
	}

	/**
	 *  Revoke all group's permissions
	 */
	public function revokeAll()
	{
		return $this->revokePermissions($this->permissions->lists('type')->toArray());
	}

	/**
	 *
	 */
	public function revokePermission($perm)
	{
	  	return $this->revokePermissions($perm);
	}

	/**
	  * Revoke permission(s)
	  *
	  *	@param mixed $perm  (string) Permission Type | (Permission) Permission Instance | (array)
	  */
	public function revokePermissions($perm)
	{
		if (is_null($perm)) {

			return;

		} else if ( is_string($perm)) {

			return $this->revokePermissions(Permission::byType($perm)->firstOrFail());

		} else if ($perm instanceof Permission) {

		  	return $this->permissions()->detach($perm);

		}  else if (is_array($perm)) {

			foreach($perm as $single_permission) {

				$this->revokePermissions($single_permission);

			}

		}
	}
}
