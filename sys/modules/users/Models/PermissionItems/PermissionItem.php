<?php

namespace P3in\Models\PermissionsRequired\PermissionItems;

use Illuminate\Database\Eloquent\Builder;
use P3in\Interfaces\PermissionRequiredItemInterface;
use P3in\Models\Website;

class PermissionItem
{
    public function __construct($pointer)
    {
        // @TODO find out what we're pointing at, now we rely on client code to be aware
        // @TODO this should be delegated to the specific class

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
        if (!Website::getCurrent()) {
            Website::setCurrent(Website::admin());
        }

        return $query
            ->where('website_id', '=', Website::getCurrent()->id)
            ->where('pointer', '=', $this->getPointer())
            ->where('type', '=', $this->getType())
            ->firstOrFail()
            ->permission;
    }
}
