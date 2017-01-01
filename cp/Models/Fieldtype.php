<?php

namespace P3in\Models;

use Illuminate\Database\Eloquent\Model;

class Fieldtype extends Model
{
    public $fillable = [
        'type',
        'label'
    ];

    public $primaryKey = 'type';

    public $timestamps = false;

    public function fields()
    {
        return $this->hasMany(Field::class);
    }
}
