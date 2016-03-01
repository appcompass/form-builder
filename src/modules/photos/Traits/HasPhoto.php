<?php

namespace P3in\Traits;

use P3in\Models\Photo;

Trait HasPhoto {

    abstract function getBasePhotoPath();

    public function linkPhoto(Photo $photo)
    {
        $this->photo()->save($photo);
    }

    public function photo()
    {
        return $this->morphMany(Photo::class, 'photoable');
    }

    public function getPathAttribute()
    {
        return $this->getBasePhotoPath();
    }

}