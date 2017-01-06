<?php

namespace P3in\Models;

use Illuminate\Database\Eloquent\Model;
use Validator;
use Exception;

class Link extends Model
{

    protected $fillable = [
        'label',
        'url',
        'alt',
        'new_tab',
        'clickable',
        'icon'
    ];

    private $rules = [
        'label' => 'required',
        'url' => 'required_if:clickable,true',
        'alt' => 'required',
        'new_tab' => 'required',
        // 'clickable' => ''
    ];

    // protected $attributes;

    // public function __construct($attributes)
    // {
        // $validator = Validator::make($attributes, $this->rules);

        // if (!$validator->passes()) {

            // throw new Exception($validator->errors());

        // }

        // $this->attributes = $attributes;

    // }

    // public function __get($attribute)
    // {
    //     if (isset($this->attributes[$attribute])) {

    //         return $this->attributes[$attribute];

    //     }

    //     return NULL;
    // }

}