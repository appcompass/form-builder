<?php

namespace P3in\Traits;

use P3in\Models\Photo;

trait HasPhotos
{
    abstract public function getBasePhotoPath();

    public function linkPhoto(Photo $photo)
    {
        $this->photos()->save($photo);
    }

    public function photos()
    {
        return $this->morphMany(Photo::class, 'photoable');
    }
}
