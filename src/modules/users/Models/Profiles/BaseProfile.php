<?php

namespace P3in\Profiles;

use P3in\Models\User;
use P3in\ModularBaseModel;

class BaseProfile extends ModularBaseModel
{

    public $table = 'profiles';

    public $fillable = [
        'profileable_id',
        'profileable_type'
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
