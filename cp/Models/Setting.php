<?php

namespace P3in\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = [
        'data'
    ];

    protected $casts = [
        'data' => 'object'
    ];

    public function settingable()
    {
        return $this->morphTo();
    }
}
