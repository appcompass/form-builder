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

    const GUEST_PERMISSION = null;

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
     * Rules
     */
    public static $rules = [
        'label' => 'required',
        'type' => 'required'
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

    public static function createCpRoutePerm($type, $label = null)
    {
        $perm = static::firstOrNew([
            'type' => $type,
        ]);
        $perm->label = $label ?: ucwords(str_replace(['.','-'], ' ', $type));
        $perm->description = 'Permission for the route: '.$type;
        $perm->locked = true;

        $perm->save();

        return $perm->type;
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
