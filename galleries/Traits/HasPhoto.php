<?php

namespace P3in\Traits;

use Photo;

Trait HasPhoto {

    abstract function getBasePhotoPath();

    public function linkPhoto(Photo $photo)
    {
        $this->photo()->save($photo);
    }

    public function photo()
    {
        return $this->photos;
    }

    public function photos()
    {
        return $this->morphMany(Photo::class, 'photoable');
    }

    public function getPathAttribute()
    {
        return $this->getBasePhotoPath();
    }

    public function getLocalPathAttribute()
    {
        return $this->getLocalPhotoPath();
    }
}
