<?php

namespace P3in\Models\PermissionsRequired\PermissionItems;

use Illuminate\Database\Eloquent\Builder;
use P3in\Interfaces\PermissionRequiredItemInterface;
use P3in\Models\Website;

class Controller implements PermissionRequiredItemInterface
{
    // Name of the item we're instantiating
    protected $pointer;

    protected $type = 'controller';

    public function __construct($pointer)
    {
        $this->pointer = $pointer;
    }

    /**
     *  Return the class pointer
     */
    public function pointer()
    {
        return $this->pointer;
    }

    /**
     *  Return permission type
     */
    public function type()
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
            ->where('pointer', '=', $this->pointer())
            ->where('type', '=', $this->type())
            ->firstOrFail()
            ->permission;
    }

}