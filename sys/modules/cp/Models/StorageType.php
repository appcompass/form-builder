<?php

namespace P3in\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Storage as LaravelStorage;
use P3in\Models\Form;

// @TODO: prob needs a better name, CmsStorage or something.
class StorageType extends Model
{
    protected $fillable = [
        'name',
    ];

    // @TODO: this is the wrong place for this.  we need a form per TYPE not per disk instance.
    public function form()
    {
        return $this->morphOne(Form::class, 'formable');
    }

    public static function getType($type)
    {
        return StorageType::where('name', $type)->firstOrFail();
    }
}
