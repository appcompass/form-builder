<?php

/**
 *  HasGallery
 *
 *  provides hooks to link galleries to the model without hardcoding a dependency
 *
 *  Client code must implement getGalleryName()
 */

namespace P3in\Traits;

use Auth;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use P3in\Models\Gallery;
use P3in\Models\User;

trait HasGallery
{

    /**
     * Client code provides means for storing the gallery name
     */
    abstract public function getGalleryName();

    /**
     *  galleries
     *
     */
    public function gallery()
    {
        return $this->morphOne(Gallery::class, 'galleryable');
    }

}
