<?php

namespace P3in\Interfaces;

use Illuminate\Database\Eloquent\Builder;

interface PermissionRequiredItemInterface
{

    /**
     * How
     */
    public function how(Builder $query);
}
