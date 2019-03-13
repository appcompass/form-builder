<?php

namespace AppCompass\Interfaces;

use AppCompass\Models\Form;

interface FormHandlerInterface
{
    public function __construct(Form $form);
    public function handle($content);
}