<?php

namespace P3in\Models\PermissionsRequired\PermissionItems;

use Illuminate\Database\Eloquent\Builder;
use P3in\Interfaces\PermissionRequiredItemInterface;

class PermissionItem
{

    public function __construct($pointer)
    {



        $this->pointer = $pointer;
    }

}