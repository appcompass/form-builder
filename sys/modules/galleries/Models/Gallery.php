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
            ->orderBy('order', 'asc')
            ->orderBy('created_at', 'desc');

    }

    /**
     *  Relation with videos
     *
     */
    public function videos()
    {

        return $this->hasManyThrough(Video::class, GalleryItem::class, 'gallery_id', 'id')
            ->where('itemable_type', Video::class)
            ->orderBy('gallery_items.order', 'asc')
            ->orderBy('created_at', 'desc');

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

        return $this->hasMany(GalleryItem::class)
          ->orderBy('order', 'desc');

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
    public function addVideo(Video $video, $order = null)
    {
      return $this->addItem($video, $order);
    }

    /**
     *
     *
     */
    public function addPhoto(Photo $photo, $order = null)
    {
        return $this->addItem($photo, $order);
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

              try {

                $start = GalleryItem::whereItemableType(get_class($item))
                  ->whereGalleryId($this->id)
                  ->orderBy('order', 'desc')
                  ->firstOrFail()
                  ->order + 1;

              } catch (ModelNotFoundException $e) {

                $start = 1;

              }

              $acc[get_class($item)][] = $item->id;

            }

            foreach($acc as $class => $items) {

                return call_user_func_array([$this, $syncMap[$class]], [collect($items), $start]);

            }

        }

    }

    public function syncPhotos(Collection $photos, $start = null)
    {
        $owned = $this->photos->pluck('id');

        $keep = $owned->intersect($photos);

        $add = $photos->diff($owned);

        $delete = $owned->diff($keep);

        \DB::table('gallery_items')->where('gallery_id', $this->id)->whereIn('itemable_id', $delete->toArray())->delete();

        foreach(Photo::whereIn('id', $add)->get() as $photo) {

            $this->addPhoto($photo, $start++);

        }

    }

    public function syncVideos(Collection $videos, $start = null)
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

            $this->addVideo($video, $start);

        }

    }


    /**
     *  addItem
     *
     *  Adds an item to this gallery
     */
    private function addItem(GalleryItemInterface $item, $order = 1)
    {

      return GalleryItem::firstOrCreate([
          'gallery_id' => $this->id,
          'itemable_type' => get_class($item),
          'itemable_id' => $item->id,
          'order' => $order
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

    // temp for demo/test purpose
    public function latestActivity($count)
    {
        return Gallery::take($count)
            ->orderBy('updated_at','desc')
            ->get()
            ->makeHidden('id')
            ->makeHidden('user_id');
    }

    public function mostUploads($count)
    {
        return Gallery::take($count)
            ->get()
            ->makeHidden('id')
            ->makeHidden('user_id');
    }
}