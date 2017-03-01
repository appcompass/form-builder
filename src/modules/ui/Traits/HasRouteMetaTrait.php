<?php

namespace P3in\Traits;

use P3in\Models\RouteMeta;

trait HasRouteMetaTrait
{
    // keep it simple for now, instead of using an interface
    // we're simply using the RouteMeta model directly.
    public function getMeta($key)
    {
        $rslt = RouteMeta::byName($key)->first();
        return $rslt ? $rslt->combined : new \stdClass();
    }

    public function setMeta($array)
    {

    }
}
