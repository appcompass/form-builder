<?php

namespace P3in\Models;

use P3in\Models\Photo;
use Illuminate\Database\Eloquent\Model;
use P3in\Traits\SettingsTrait;

class GalleryItem extends Model
{
    use SettingsTrait;

    /**
     * Table Name
     */
    protected $table = 'gallery_items';

    /**
     * Doesn't need timestamps
     */
    public $timestamps = false;

    /**
     *
     */
    // protected $appends = ['type'];

    /**
     * Always eager load itemable
     */
    protected $with= [];

    /**
     * Fillable Attributes
     */
    protected $fillable = [
        'gallery_id',
        'itemable_type',
        'itemable_id',
        'order',
    ];

    protected $primaryKey = "itemable_id";

    /**
     * Belongs to multiple Models through polymorphic
     */
    public function itemable()
    {
        return $this->morphTo('itemable');
    }

    public function gallery()
    {
        return $this->belongsTo(Gallery::class);
    }

    /**
     * Add type
     */
    public function getTypeAttribute()
    {
        return get_class($this->itemable);
    }

    /**
     *  Narrows the selection to a specific class type
     *
     *  @param Builder $query
     *  @param mixed $type class name or instance of the filter
     */
    public function scopeByType($query, $type)
    {
        if (is_object($type)) {
            $type = get_class($type);
        }

        return $query->where('itemable_type', '=', $type);
    }

    /**
     *  Fetch items on a gallery
     *
     *  @param QueryBuilder $query
     *  @param
     *  @param
     */
    public function scopeByGallery($query, Gallery $gallery, $item = null)
    {
        $query->where('gallery_id', $gallery->id);

        if (is_null($item)) {
            return $query;
        } else {
            return $query->where('itemable_type', $item);
        }
    }
}
