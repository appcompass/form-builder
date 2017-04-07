<?php

namespace P3in\Models;

use Auth;
// use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;
use P3in\Interfaces\GalleryItemInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use P3in\Models\GalleryItem;
use P3in\Models\User;
use P3in\Models\Video;
use P3in\Models\Photo;

class Gallery extends Model
{
    protected $table = 'galleries';

    protected $fillable = [
        'name',
        'user_id'
    ];

    protected $dates = [];

    protected $appends = ['photoCount', 'videoCount'];

    /**
     *  Relationship with users
     *
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     *   Polymorphic relation
     *
     */
    public function galleryable()
    {
        return $this->morphTo();
    }

    /**
     *  Relation with galleryItems
     *
     */
    public function items()
    {
        return $this->hasMany(GalleryItem::class)
            ->orderBy('order', 'asc');
    }

    /**
     *  Relation with galleryItems
     *
     */
    public function photos()
    {
        return $this->hasMany(Photo::class)
            ->orderBy('order', 'asc');
    }

    /**
     *  Relation with galleryItems
     *
     */
    public function videos()
    {
        return $this->hasMany(Video::class)
            ->orderBy('order', 'asc');
    }

    /**
     * Gets the storage.
     *
     * @return     <type>  The storage.
     */
    public function getStorage()
    {
        return $this->galleryable->storage;
    }

    /**
     *  Get Photos Count
     *
     */
    public function getPhotoCountAttribute()
    {
        return $this->photos->count();
    }

    /**
     * Get Videos Count
     *
     */
    public function getVideoCountAttribute()
    {
        return $this->videos->count();
    }
}
