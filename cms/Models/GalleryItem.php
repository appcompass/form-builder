<?php

namespace P3in\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use P3in\Models\Gallery;
use P3in\Models\Oberservers\GalleryItemObserver;
use P3in\Models\Scopes\GalleryItemScope;
use P3in\Models\User;
use P3in\Traits\HasPermissions;
use P3in\Traits\HasStorage;

abstract class GalleryItem extends Model
{
    use HasStorage, SoftDeletes, HasPermissions;

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
        static::observe(new GalleryItemObserver);
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
}
