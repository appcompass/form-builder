<?php

namespace P3in\Models\PermissionsRequired\PermissionItems;

use Illuminate\Database\Eloquent\Builder;
use P3in\Interfaces\PermissionRequiredItemInterface;
use P3in\Models\Website;

class PermissionItem
{

    public function __construct($pointer)
    {
        // find out what we're pointing at

        $this->pointer = $pointer;

    }

    public function getPointer()
    {
        return $this->pointer;
    }

    public function getType()
    {
        return $this->type;
    }

    /**
     *  Provides means to fetch target
     */
    public function how(Builder $query)
    {
        return $query
            ->where('website_id', '=', Website::getCurrent()->id)
            ->where('pointer', '=', $this->getPointer())
            ->where('type', '=', $this->getType())
            ->firstOrFail()
            ->permission;
    }

}