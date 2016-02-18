<?php

namespace P3in\Models\PermissionsRequired\PermissionItems;

use Illuminate\Database\Eloquent\Builder;
use P3in\Interfaces\PermissionRequiredItemInterface;
use P3in\Models\PermissionsRequired\PermissionItems\PermissionItem;

class Element extends PermissionItem implements PermissionRequiredItemInterface {

    public function how(Builder $query)
    {
        return $query;
    }

}