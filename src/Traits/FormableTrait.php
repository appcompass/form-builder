<?php

namespace P3in\Traits;

use P3in\Models\Form;

trait FormableTrait
{
    private $settings = null;

    private $json = null;

    public function form()
    {
        return $this->morphOne(Form::class, 'formable');
    }
}
