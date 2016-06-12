<?php

namespace P3in\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class AlertUser extends Model
{
    /**
     *  Mass assignable fields
     */
    protected $fillable = [
        'read',
        'user_id',
        'alert_id'
    ];

    /**
     *  User
     *
     */
    public function user()
    {
        return $this->belongsTo(\P3in\Models\User::class);
    }

    /**
     *  Alert
     *
     */
    public function alert()
    {
        return $this->belongsTo(\P3in\Models\Alert::class);
    }

    /**
     *  scopeFrom
     *
     */
    public function scopeFrom(Builder $query, \Carbon\Carbon $from)
    {
        return $query->where('user_id', \Auth::user()->id)
            ->where('updated_at', '>=', $from);
    }

    /**
     *  userCanSee
     *
     */
    public static function userCanSee($alert_id)
    {
        if (!\Auth::check()) {

            throw new \Exception('Must be logged.');

        }

        return static::where('user_id', \Auth::user()->id)
            ->where('alert_id', $alert_id)
            ->exists();
    }

}