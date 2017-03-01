<?php

namespace P3in\Traits;

use Illuminate\Database\Eloquent\ModelNotFoundException;
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
