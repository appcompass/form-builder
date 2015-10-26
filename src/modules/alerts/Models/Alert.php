<?php

namespace P3in\Models;

use Illuminate\Database\Eloquent\Model;
use P3in\Models\User;
use P3in\Traits\JsonPropScopesTrait as JsonPropScopes;

class Alert extends Model
{

	use JsonPropScopes;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'alerts';

	/**
	 * Casts array
	 *
	 */
	protected $casts = [
		'props' => 'object'
	];

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'title',
		'message',
		'hash',
		'req_perms',
		'props'
	];

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = ['id'];

	/**
	 *
	 *
	 */
	public function alertable()
	{

	  return $this->morphTo();

	}

	/**
	 *
	 *
	 *
	 */
	public function scopeByHash($query, $hash)
	{
	  return $query->where('hash', '=', $hash);
	}

	/**
	 *	Match Alert's permissions with user's
	 *
	 */
	public function matchPerms(User $user = null)
	{

		if (is_null($this->req_perms)) {

			return $this;

		} else if (is_null($user)) {

			return null;

		} else  {

			if ( $user->hasPermissions($this->req_perms) ) {

				return $this;

			}

		}
	}

}
