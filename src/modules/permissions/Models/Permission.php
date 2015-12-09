<?php

namespace P3in\Models;

use Illuminate\Database\Eloquent\Model;
use P3in\Models\User;
use P3in\Models\Group;

class Permission extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'permissions';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'type',
        'label',
        'description'
    ];

    /**
    *	  Get permission by name
    *
    *
    */
    public function scopeByType($query, $type)
    {
    	return $query->where('type', '=', $type);
    }

    /**
    *	 Get groups having this permission
    *
    *
    */
    public function groups()
    {
    	return $this->belongsToMany('P3in\Models\Group');
    }
}
