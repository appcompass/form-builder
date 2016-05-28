<?php

namespace P3in\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;

class Alert extends Model
{

	/**
	 * 	The database table used by the model.
	 *
	 * 	@var string
	 */
	protected $table = 'alerts';

	/**
	 * 	Casts array
	 *
	 */
	protected $casts = [
		'props' => 'object'
	];

	/**
	 * 	The attributes that are mass assignable.
	 *
	 * 	@var array
	 */
	protected $fillable = [
		'title',
		'message',
		'req_perm',
		'emitted_by',
		'props'
	];

	/**
	 *	Alertable
	 *
	 *	track the model emitting the event
	 */
	public function alertable()
	{
	  	return $this->morphTo();
	}

	/**
	 * 	Return all the notifications sent out by the alert
	 *
	 */
	public function notifications()
	{
	  	return $this->hasMany(\P3in\Models\AlertUser::class);
	}

	/**
	 * 	Distribute the alert to the appropriate users
	 *
	 * @param \P3in\Models\Alert
	 * @param \Illuminate\Database\Eloquent\Collection
	 * @param bool excludeEmittingUser
	 */
	public static function distribute(Alert $alert, Collection $users, $excludeEmittingUser = true)
	{
	    foreach($users as $user) {

	    	if ($excludeEmittingUser && $alert->emitted_by === $user->id) {

	    		continue;

	    	}

	    	$notification = AlertUser::create([
	    		'read' => false,
	            'user_id' => $user->id,
	            'alert_id' => $alert->id,
    		]);

	    }

	    return true;
	}

}
