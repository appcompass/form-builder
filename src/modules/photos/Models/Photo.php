<?php

namespace P3in\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use OpenCloud\Rackspace;
use P3in\Interfaces\GalleryItemInterface;
use P3in\Models\User as User;
use P3in\Traits\AlertableTrait;
use P3in\Traits\NavigatableTrait;
use P3in\Traits\OptionableTrait;
use P3in\Traits\SettingsTrait;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class Photo extends Model implements GalleryItemInterface
{

  use OptionableTrait, SettingsTrait, AlertableTrait, NavigatableTrait;

  const DEFAULT_STATUS = Photo::STATUSES_PENDING;
  const TYPE_ATTRIBUTE_NAME = 'photo_of';

  const STATUSES_PENDING = 'pending';
  const STATUSES_APPROVED = 'approved';
  const STATUSES_DELETED = 'deleted';
  const STATUSES_ACTIVE = 'active';
  const STATUSES_HIDDEN = 'hidden';

  /**
   * Table Name
   */
  protected $table = 'photos';

  /**
   * Fillable Attributes
   */
  protected $fillable = [
    'path',
    'name',
    'user_id',
    'status',
    'storage',
    'options'
  ];

  /**
   * Hidden properties
   */
  protected $hidden = [];

  /**
   * With
   */
  protected $with = ['options'];

  /**
   *   Allow multiple owners through polymorphic
   *
   */
  public function photoable()
  {
    return $this->morphTo();
  }

  /**
   *
   */
  public function user()
  {
    return $this->belongsTo(User::class);
  }

  /**
   *  Get all the photos in the gallery
   *
   */
  public function galleryItem()
  {
      return $this->morphOne(GalleryItem::class, 'itemable');
  }

  /**
    * Galleries
    *
    */
  public function galleries()
  {
      return $this->hasManyThrough(Gallery::class, GalleryItem::class, 'itemable_id', 'id');
  }

  /**
   *  Navigatable Trait
   *
   */
    public function makeLink($overrides = [])
    {
        return array_replaces([
            "label" => $this->label,
            "url" => $this->path,
            "req_perms" => null,
            "props" => json_encode([
              "icon" => "camera",
              "link" => [
                'href' => "",
                "data-target" => ""
              ],
           ]),
        ], $overrides);
    }

  /**
   * Store a new image
   *
   * @param UploadedFile $file File instance
   * @param string storage instance
   * @return \P3in\Models\Photo
   */
  public static function store(UploadedFile $file, User $user, $attributes = [], $disk = null)
  {

    $ext = $file->getClientOriginalExtension();

    if (isset($attributes['file_path'])) {
        $file_path = $attributes['file_path'];
        unset($attributes['file_path']);
    }else{
        $file_path = '';
    }

    if (isset($attributes['name'])) {
        $name = $attributes['name'];
        unset($attributes['name']);
    }else{
        $name = date('m-y').'/'.time().'-'.str_slug(str_replace($ext, '', $file->getClientOriginalName()), '-');
    }

    $file_name = $file_path.$name.'.'.$ext;

    if (is_null($disk)) {

      $disk = \Storage::disk(config('app.default_storage'));

    }

    $disk->put(
      $file_name,
      file_get_contents($file->getRealpath())
    );

    $photo = $user->photos()
        ->create([
            'path' => isset($attributes['prefix']) ? $attributes[$prefix].$file_name : $file_name,
            'label' => $file->getClientOriginalName(),
            'storage' => config('app.default_storage'),
            'status' => Photo::DEFAULT_STATUS
        ]);

      $photo->fill(array_replace($photo->attributes, $attributes));

      $photo->save();

    return $photo;
  }

  /**
   *
   *
   */
  public function getNameAttribute()
  {
    return $this->attributes['path'];
  }

  /**
    *
    *
    */
  public function getPathAttribute()
  {

    if (preg_match('/^[a-z0-9]+([._-][a-z0-9]+)+$/i', $this->storage, $matches)) {

      $schema = \Request::secure() ? 'https://' : 'http://';

      return $schema.$this->storage.'/' . $this->attributes['path'];

    }

    return $this->attributes['path'];

  }

  /**
    * Access to options
    */
  public function setOptionsAttribute($option)
  {
    $this->setOption(key($option), $option[key($option)]);
  }

  /**
   * All the photos posted in between 2 dates
   *
   *
   */
  public function scopePostedBetween($query, Carbon $start, Carbon $end)
  {
    // return $query->where('')
  }
}