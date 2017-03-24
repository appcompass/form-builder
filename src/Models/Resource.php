<?php

namespace P3in\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use P3in\Traits\HasRole;

class Resource extends Model
{

    use HasRole;

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
