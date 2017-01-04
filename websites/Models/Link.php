<?php

namespace P3in\Models;

use Validator;
use Exception;

class Link
{

    private $rules = [
        'label' => 'required',
        'url' => 'required',
        'alt' => 'required',
        'new_tab' => 'required'
    ];

    private $attributes;

    public function __construct($attributes)
    {
        $validator = Validator::make($attributes, $this->rules);

        if (!$validator->passes()) {

            throw new Exception($validator->errors());

        }

        $this->attributes = $attributes;

    }

    public function __get($attribute)
    {
        if (isset($this->attributes[$attribute])) {

            return $this->attributes[$attribute];

        }

        return NULL;
    }

}