<?php

namespace P3in\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use P3in\Models\Gallery;
use P3in\Models\Scopes\GalleryItemScope;
use P3in\Models\User;
use P3in\Traits\HasCardView;
use P3in\Traits\HasPermissions;

abstract class GalleryItem extends Model
{
    use SoftDeletes, HasPermissions, HasCardView;

    /**
     * Table Name
     */
    protected $table = 'gallery_items';

    /**
     * Fillable Attributes
     */
    protected $fillable = [
        'path',
        'type',
        'meta',
        'order',
    ];

    /**
    * Hidden properties
    */
    protected $hidden = [];

    /**
    * With
    */
    protected $with = [];

    protected $casts = [
        'meta' => 'object'
    ];

    protected static function boot()
    {
        static::addGlobalScope(new GalleryItemScope);
        parent::boot();
    }

    /**
     *
     */
    // protected $appends = ['type'];

    public function gallery()
    {
        return $this->belongsTo(Gallery::class);
    }

    /**
    *
    */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Sets the meta.
     *
     * @param      <type>  $key    The key
     * @param      <type>  $val    The value
     *
     * @return     <type>  ( description_of_the_return_value )
     */
    public function setMeta($key, $val)
    {
        $this->update(['meta->'.$key => $val]);

        return $this;
    }

    /**
     * Gets the meta.
     *
     * @param      <type>  $key    The key
     *
     * @return     <type>  The meta.
     */
    public function getMeta($key)
    {
        // array_get is what we need but only works with arrays.
        $conf = json_decode(json_encode($this->meta ?: []), true);
        return array_get($conf, $key, null);
    }
}
