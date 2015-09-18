<?php

namespace P3in\Models;

use Illuminate\Database\Eloquent\Model;
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
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'title',
		'message',
		'model',
		'props'
	];

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = [];

	/**
	*	Get Json Decoded Prop Attribute
	*
	*
	*/
	public function getPropsAttribute()
	{
		return json_decode($this->attributes['props']);
	}
}
