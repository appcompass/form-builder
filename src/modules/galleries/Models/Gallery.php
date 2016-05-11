<?php

namespace P3in\Models;

use Auth;
// use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Collection;
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
            ->where('itemable_type', Photo::class)
            ->orderBy('order', 'asc');

    }

    /**
     *  Relation with videos
     *
     */
    public function videos()
    {

        return $this->hasManyThrough(Video::class, GalleryItem::class, 'gallery_id', 'id')
            ->where('itemable_type', Video::class)
            ->orderBy('gallery_items.order', 'asc');

        // return $this->hasMany(GalleryItem::class)
        //     ->where('itemable_type', Video::class)
        //     ->orderBy('order', 'asc');
    }

    /**
     *  Get Photos Count
     *
     */
    public function getPhotoCountAttribute()
    {

        return count($this->photos);

    }

    /**
     * Get Videos Count
     *
     */
    public function getVideoCountAttribute()
    {

        return count($this->videos);

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
     */
    public function sync(\Illuminate\Database\Eloquent\Collection $items, $type = null)
    {

        $syncMap = [
            Photo::class => 'syncPhotos',
            Video::class => 'syncVideos'
        ];

        if (!is_null($type)) {

            switch($type) {
                case 'videos':
                    $this->syncVideos($items);
                    break;
                case 'photos':
                    $this->syncPhotos($items);
                    break;
            }

        } else if ($items instanceof \Illuminate\Database\Eloquent\Collection) {

            $acc = [];

            foreach($items as $item) {

                $acc[get_class($item)][] = $item->id;

            }

            foreach($acc as $class => $items) {

                return call_user_func_array([$this, $syncMap[$class]], [collect($items)]);

            }

        }

    }

    public function syncPhotos(Collection $photos)
    {
        $owned = $this->photos->pluck('id');

        $keep = $owned->intersect($photos);

        $add = $photos->diff($owned);

        $delete = $owned->diff($keep);

        \DB::table('gallery_items')->where('gallery_id', $this->id)->whereIn('itemable_id', $delete->toArray())->delete();

        foreach(Photo::whereIn('id', $add)->get() as $photo) {

            $this->addPhoto($photo);

        }

    }

    public function syncVideos(Collection $videos)
    {
        // currently owned
        $owned = $this->videos->pluck('id');

        // the ones we keep
        $keep = $owned->intersect($videos);

        // the oned we add
        $add = $videos->diff($owned);

        // the oned we delete
        $delete = $owned->diff($keep);

        \DB::table('gallery_items')->where('gallery_id', $this->id)->whereIn('itemable_id', $delete->toArray())->delete();

        foreach(Video::whereIn('id', $add)->get() as $video) {

            $this->addVideo($video);

        }

    }


    /**
     *
     *
     */
    private function addItem(GalleryItemInterface $item)
    {
        return GalleryItem::firstOrCreate([
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
