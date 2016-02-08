<?php

namespace P3in\Models;

use Image;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
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

    use OptionableTrait, SettingsTrait, AlertableTrait, NavigatableTrait, SoftDeletes;

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
        'meta',
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

    protected $casts = [
        'meta' => 'object'
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

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

        // TODO: this block below should not be here, needs to be abstracted out.
        // get image extension
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
        // END TODO

        // get image exif data.
        $exif = Image::make($file)->exif();

        // the FileName here becomes the php temp file name so we rename it to the original file name before storage.
        if (!empty($exif['FileName'])) {
            $exif['FileName'] = $file->getClientOriginalName();
        }

        // we set it to attributes here because assigning it to create directly stores a malformed json string.
        $attributes['meta'] = $exif;

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
        return !empty($this->meta->FileName) ? $this->meta->FileName : $this->attributes['path'];
    }

    /**
    *
    *
    */
    public function getXResolutionAttribute()
    {
        if (!empty($this->meta->XResolution)) {
            $res = explode('/', $this->meta->XResolution);
            return count($res) == 2 ? $res[0]/$res[1] : null;
        }
        return null;
    }

    /**
    *
    *
    */
    public function getYResolutionAttribute()
    {
        if (!empty($this->meta->YResolution)) {
            $res = explode('/', $this->meta->YResolution);
            return count($res) == 2 ? $res[0]/$res[1] : null;
        }
        return null;
    }


    /**
    *
    *
    */
    public function getResolutionAttribute()
    {
        return $this->x_resolution && $this->y_resolution ? $this->x_resolution.'x'.$this->y_resolution : null;
    }

    /**
    *
    *
    */
    public function getHeightAttribute()
    {

        return !empty($this->meta->COMPUTED->Height) ? $this->meta->COMPUTED->Height : null;
    }

    /**
    *
    *
    */
    public function getWidthAttribute()
    {
        return !empty($this->meta->COMPUTED->Width) ? $this->meta->COMPUTED->Width : null;
    }

    public function getDimensionsAttribute()
    {
        return $this->width && $this->height ? $this->width.'x'.$this->height : null;
    }
    /**
    *
    *
    */
    public function getMimeTypeAttribute()
    {
        return !empty($this->meta->MimeType) ? $this->meta->MimeType : null;
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
