<?php

namespace P3in\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Resource extends Model
{
    protected $fillable = [
        'form_id',
        'resource',
        'req_role'
    ];

    /**
     * { function_description }
     *
     * @return     <type>  ( description_of_the_return_value )
     */
    public function form()
    {
        return $this->belongsTo(Form::class);
    }

    public function role()
    {
        return $this->belongsTo(Role::class, 'req_role');
    }

    /**
     * Sets the form.
     *
     * @param      Form    $form   The form
     *
     * @return     <type>  ( description_of_the_return_value )
     */
    public function setForm(Form $form)
    {
        return $this->associate($form);
    }

    public static function resolve($name)
    {
        return static::whereResource($name)->firstOrFail();
    }
}
