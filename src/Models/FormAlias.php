<?php

namespace AppCompass\FormBuilder\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class FormAlias extends Model
{
    protected $fillable = [
        'form_id',
        'alias'
    ];

    protected $table = 'form_alias';

    /**
     *
     */
    public function form()
    {
        return $this->belongsTo(Form::class);
    }

    /**
     *
     */
    public function scopeByAlias(Builder $query, $view)
    {
        return $query->where('alias', $view);
    }
}
