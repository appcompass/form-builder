<?php

namespace P3in\Interfaces;

use P3in\Models\Form;

interface FormHandlerInterface
{
    public function __construct(Form $form);
    public function handle($content);
}