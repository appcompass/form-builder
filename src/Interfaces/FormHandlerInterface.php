<?php

namespace AppCompass\FormBuilder\Interfaces;

use AppCompass\FormBuilder\Models\Form;

interface FormHandlerInterface
{
    public function __construct(Form $form);
    public function handle($content);
}