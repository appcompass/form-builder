<?php

namespace AppCompass\FormBuilder\Traits;

use AppCompass\FormBuilder\Models\Form;

trait FormableTrait
{
    private $settings = null;

    private $json = null;

    public function form()
    {
        return $this->morphOne(Form::class, 'formable');
    }
}
