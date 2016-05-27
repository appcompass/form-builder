<?php

namespace P3in\Models;

use P3in\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;
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
		'req_perm',
		'props'
	];

	/**
	 *	Ploymorphic
	 *
	 *	we need to keep track of the object that's emitting the event
	 */
	public function alertable()
	{
	  	return $this->morphTo();
	}

	/**
	 * 	Distribute the alert to the appropriate users
	 *
	 */
	public static function distribute(Alert $alert, Collection $users)
	{
	    foreach($users as $user) {

	        \DB::table('alert_user')->insert([
	            'user_id' => $user->id,
	            'alert_id' => $alert->id
	        ]);

	    }

	    return true;
	}

	/**
	 *	Match Alert's permissions with user's
	 *
	 * 	@DEPRECATE will be removed
	 */
	public function matchPerms(User $user = null)
	{

		// if (is_null($this->req_perms)) {

		// 	return $this;

		// } else if (is_null($user)) {

		// 	return null;

		// } else  {

		// 	if ( $user->hasPermission($this->req_perms) ) {

		// 		return $this;

		// 	}

		// }

		return false;
	}


}
