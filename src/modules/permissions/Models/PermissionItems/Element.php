<?php

namespace P3in\Models\PermissionsRequired\PermissionItems;

use Illuminate\Database\Eloquent\Builder;
use P3in\Interfaces\PermissionRequiredItemInterface;

class Element implements PermissionRequiredItemInterface {

    public function how(Builder $query)
    {
        return $query;
    }

}