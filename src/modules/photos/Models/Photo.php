<?php

namespace P3in\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;
use Image;
use P3in\Interfaces\GalleryItemInterface;
use P3in\Models\User as User;
use P3in\ModularBaseModel;
use P3in\Traits\HasPermissions;
use P3in\Traits\NavigatableTrait;
use P3in\Traits\OptionableTrait;
use P3in\Traits\SettingsTrait;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class Photo extends ModularBaseModel implements GalleryItemInterface
{

    use OptionableTrait, SettingsTrait, NavigatableTrait, SoftDeletes, HasPermissions;

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
        'photoable_type',
        'photoable_id',
        'created_at',
        'updated_at',
        'options'
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

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    /**
     * Attributes appendend by default
     */
    protected $appends = ['dimensions', 'resolution'];

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
    * @param User $user Uploader
    * @param array attributes
    *    [file_path] specifies a sub path to add to the root pointed by the disk instance
    *    [name] probably an override, not sure
    * @param disk disk Disk Instance
    * @return \P3in\Models\Photo
    *
    * @TODO Refactor this big time
    */
    public static function store(UploadedFile $file, User $user, $attributes = [], $disk = null)
    {

        // TODO: this block below should not be here, needs to be abstracted out.
        // get image extension
        $ext = $file->getClientOriginalExtension();

        if (isset($attributes['file_path'])) {
            $file_path = $attributes['file_path'];
            unset($attributes['file_path']);
        } else {
            $file_path = '';
        }

        if (isset($attributes['name'])) {
            $name = $attributes['name'];
            unset($attributes['name']);
        } else {
            $name = date('m-y').'/'.time().'-'.str_slug(str_replace($ext, '', $file->getClientOriginalName()), '-');
        }

        $file_name = $file_path.$name.'.'.$ext;
        // END TODO
        if ($ext != 'svg') {
            // get intervention image object.
            $image = Image::make($file);
            // get exif data for images that have it.
            $exif = $image->exif();

            // the FileName here becomes the php temp file name so we rename it to the original file name before storage.
            if (!empty($exif['FileName'])) {
                $exif['FileName'] = $file->getClientOriginalName();
            }

            // we set it to attributes here because assigning it to create directly stores a malformed json string.
            $attributes['meta'] = $exif;

            // short cut since we have these values.
            $attributes['meta']['height'] = $image->height();
            $attributes['meta']['width'] = $image->width();

            // THis is because this object can (and seems to often) contain non UTF8 encoded characters resulting in a json_encode that fails.
            $encode_fix = function(&$item, $key)
            {
                $item = utf8_encode($item);
            };

            array_walk_recursive($attributes['meta'], $encode_fix);
        }


        if (is_null($disk)) {

            $disk = \Storage::disk(config('app.default_storage'));

        }

        $disk->put(
            $file_name,
            file_get_contents($file->getRealpath())
        );

        $photo = $user->photos()->create([
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
     * Destroy a photo
     */
    public function unlink()
    {

        if (in_array($this->storage, array_keys(config('filesystems.disks')))) {

            $disk = \Storage::disk($this->storage);

            if ( $disk->delete($this->getOriginal('path')) ) {

                return $this->delete();

            } else {

                throw new \Exception("Unable to unlink file.");

            }

        }

        // @TODO We don't treat the case where storage is different. For now at least.

        return false;
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

        return !empty($this->meta->height) ? $this->meta->height : null;
    }

    /**
    *
    *
    */
    public function getWidthAttribute()
    {
        return !empty($this->meta->width) ? $this->meta->width : null;
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

    public function getRawPathAttribute()
    {
        return $this->attributes['path'];
    }

    /**
    *
    *
    */
    public function getPathAttribute()
    {

        $schema = \Request::secure() ? 'https://' : 'http://';

        if (preg_match('/^[a-z0-9]+([._-][a-z0-9]+)+$/i', $this->storage, $matches)) {

            return $schema.$this->storage.'/' . $this->attributes['path'];

        } else if ($this->photoable instanceof Model) {

            if (method_exists($this->photoable, 'getBasePhotoPath')) {

                return $this->photoable->getBasePhotoPath($this) . $this->attributes['path'];

            }
        }

        return $this->attributes['path'];

    }

    public function getLocalPathAttribute()
    {
        $disk = Storage::disk($this->storage);
        if ($disk) {
            $base_path = $disk->getAdapter()->getPathPrefix();
            return $base_path.$this->photoable->getLocalPhotoPath().$this->attributes['path'];
        }

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
