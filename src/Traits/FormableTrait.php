<?php

namespace AppCompass\Traits;

use AppCompass\Models\Form;

trait FormableTrait
{
    private $settings = null;

    private $json = null;

    public function form()
    {
        return $this->morphOne(Form::class, 'formable');
    }
}
