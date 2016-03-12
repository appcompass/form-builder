<?php

namespace P3in\Profiles;

use Illuminate\Database\Eloquent\Model;
use P3in\Models\User;

class BaseProfile extends Model
{

    public $table = 'profiles';

    public $fillable = [
    ];

    public function profileable()
    {
        return $this->morphTo();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
