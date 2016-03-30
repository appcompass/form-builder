<?php

namespace P3in\Models;

use Auth;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use P3in\Interfaces\GalleryItemInterface;
use P3in\Models\GalleryItem;
use P3in\Models\User;
use P3in\Models\Video;
use P3in\Models\Photo;


class Gallery extends Model
{

    protected $table = 'galleries';

    protected $fillable = [
        'name',
        'description',
        'user_id',
        'galleryable_type',
        'galleryable_id'
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
     *  Get all the photos in the gallery
     *
     */
    public function photos()
    {

        return $this->hasManyThrough(Photo::class, GalleryItem::class, 'gallery_id', 'id')
            ->orderBy('order', 'asc');
    }

    /**
     *  Relation with videos
     *
     */
    public function videos()
    {
        return $this->hasManyThrough(Video::class, GalleryItem::class, 'gallery_id', 'id')
            ->orderBy('gallery_items.order', 'asc');
    }

    /**
     *  Get Photos Count
     *  @TODO This is weird but works fine and performs times better and doesn't braeak
     */
    public function getPhotoCountAttribute()
    {

        return $this->photos()->count();

        $items = $this->items()
            ->byType('P3in\Models\Photo')
            ->lists('itemable_id');

        return Photo::whereIn('id', $items)->count();

    }

    /**
     * Get Videos Count
     *  @TODO This is weird but works fine and performs times better and doesn't braeak
     */
    public function getVideoCountAttribute()
    {

        $items = $this->items()
            ->byType('P3in\Models\Video')
            ->lists('itemable_id');

        return Photo::whereIn('id', $items)->count();

    }


    /**
     *  Relation with galleryItems
     *
     */
    public function galleryItems()
    {

        return $this->hasMany(GalleryItem::class);

    }

    /**
     *  Return all the gallery items spawning model instances for each type
     *
     */
    public function items()
    {
        return $this->galleryItems()
            ->orderBy('order', 'asc');
    }

    /**
     *
     */
    public function addVideo(Video $video)
    {
      return $this->addItem($video);
    }

    /**
     *
     *
     */
    public function addPhoto(Photo $photo)
    {
        return $this->addItem($photo);
    }

    /**
     *
     *
     */
    private function addItem(GalleryItemInterface $item)
    {
        return GalleryItem::create([
            'gallery_id' => $this->id,
            'itemable_type' => get_class($item),
            'itemable_id' => $item->id
        ]);
    }

    public function scopeOf($query, $class_name)
    {
        return $query->where('galleryable_type', $class_name);
    }

    public function scopeFromRoute($query, $params)
    {
        if (!empty($params)) {
            return $params['galleries'];
        }

        return $query;
    }


}
