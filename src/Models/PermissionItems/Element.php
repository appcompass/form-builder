<?php

namespace P3in\Models\PermissionsRequired\PermissionItems;

use Illuminate\Database\Eloquent\Builder;
use P3in\Interfaces\PermissionRequiredItemInterface;
use P3in\Models\PermissionsRequired\PermissionItems\PermissionItem;
use P3in\Models\Website;

class Element extends PermissionItem implements PermissionRequiredItemInterface
{

    // Name of the item we're
    protected $pointer;

    protected $type = 'element';
}
