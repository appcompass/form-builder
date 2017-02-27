<?php

namespace P3in\Models\Profiles;

use P3in\ModularBaseModel;
use P3in\Traits\IsProfileTrait;

class Facebook extends ModularBaseModel
{
    use IsProfileTrait;

    public function __construct($data)
    {
        $this->attributes = $data;
    }
}
