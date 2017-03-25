<?php

namespace P3in\Models;

use Illuminate\Filesystem\FilesystemAdapter;
use Illuminate\Http\UploadedFile;
use Intervention\Image\Facades\Image;
use P3in\Interfaces\GalleryItemInterface;
use P3in\Models\GalleryItem;
use P3in\Models\User;

class Photo extends GalleryItem implements GalleryItemInterface
{
    protected $fillable = [
        'user_id',
        'name',
        'path',
        'order'
    ];

    /**
     * Attributes appendend by default
     */
    protected $appends = ['dimensions', 'resolution', 'url'];

    /**
     * Gets the type.
     *
     * @return     <type>  The type.
     */
    public function getType()
    {
        return 'photo';
    }

    /**
     * { function_description }
     *
     * @return     <type>  ( description_of_the_return_value )
     */
    public function apendStoragePath() {
        return date('m-y');
    }

    /**
     * Gets the url attribute.
     *
     * @return     <type>  The url attribute.
     */
     // @NOTE: We must ALWAYS get Photo::with('storage') to avoid 1 query per record.  meaning, this is a @TODO: refactor.
    public function getUrlAttribute()
    {
        return $this->getDisk()->url($this->path);
    }

    public function getCardPhotoUrl()
    {
        return $this->url;
    }

    /**
     * { function_description }
     */
    public function afterStorage()
    {
        if (\Auth::check()) {
            $this->user()->associate(\Auth::user());
        }
        $this->setMetaFromExif();
    }

    /**
     * Sets the meta from exif.
     */
    public function setMetaFromExif()
    {
        $meta = [];

        $file = $this->getDisk()->get($this->path);
        // get intervention image object.
        $image = Image::make($file);
        // get exif data for images that have it.
        $exif = $image->exif();

        // the FileName here becomes the php temp file name so we rename it to the original file name before storage.
        if (!empty($exif['FileName'])) {
            $exif['FileName'] = $file->getClientOriginalName();
        }

        // we set it to attributes here because assigning it to create directly stores a malformed json string.
        $meta = $exif;

        // short cut since we have these values.
        $meta['height'] = $image->height();
        $meta['width'] = $image->width();

        // This is because $exif can (and seems to often) contain non UTF8 encoded characters resulting in a json_encode that fails.
        array_walk_recursive($meta, function (&$item, $key) {
            $item = utf8_encode($item);
        });

        $this->meta = $meta;
    }

    /**
     * Gets the name attribute.
     */
    public function getNameAttribute()
    {
        $res = $this->getMeta('FileName', $this->attributes['path']);
    }

    /**
     * Gets the x resolution attribute.
     *
     * @return     <type>  The x resolution attribute.
     */
    public function getXResolutionAttribute()
    {
        $res = $this->getMeta('XResolution');
        return $this->formatResolution($res);
    }

    /**
     * Gets the y resolution attribute.
     *
     * @return     <type>  The y resolution attribute.
     */
    public function getYResolutionAttribute()
    {
        $res = $this->getMeta('YResolution');
        return $this->formatResolution($res);
    }

    /**
     * { function_description }
     *
     * @param      integer  $res    The resource
     *
     * @return     <type>   ( description_of_the_return_value )
     */
    private function formatResolution($res)
    {
        if ($res) {
            $res = explode('/', $res);

            return count($res) == 2 ? $res[0]/$res[1] : null;
        }

        return null;
    }

    /**
     * Gets the resolution attribute.
     *
     * @return     <type>  The resolution attribute.
     */
    public function getResolutionAttribute()
    {
        return $this->x_resolution && $this->y_resolution ? $this->x_resolution.'x'.$this->y_resolution : null;
    }

    /**
     * Gets the height attribute.
     *
     * @return     <type>  The height attribute.
     */
    public function getHeightAttribute()
    {
        return $this->getMeta('height');
    }

    /**
     * Gets the width attribute.
     *
     * @return     <type>  The width attribute.
     */
    public function getWidthAttribute()
    {
        return $this->getMeta('width');
    }

    /**
     * Gets the dimensions attribute.
     *
     * @return     <type>  The dimensions attribute.
     */
    public function getDimensionsAttribute()
    {
        return $this->width && $this->height ? $this->width.'x'.$this->height : null;
    }
    /**
     * Gets the mime type attribute.
     *
     * @return     <type>  The mime type attribute.
     */
    public function getMimeTypeAttribute()
    {
        return $this->getMeta('MimeType');
    }

    /**
     * Gets the meta.
     *
     * @param      <type>  $key    The key
     *
     * @return     <type>  The meta.
     */
    public function getMeta($key, $default = null)
    {
        return isset($this->meta->{$key}) ? $this->meta->{$key} : $default;
    }
}
