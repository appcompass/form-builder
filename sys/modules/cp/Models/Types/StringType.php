<?php

namespace P3in\Models\Types;

class StringType extends BaseField
{
    protected $template = 'String';

    public function __construct(array $attributes)
    {
        parent::__construct($attributes);
    }
}