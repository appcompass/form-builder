<?php

namespace P3in\Models;

use Illuminate\Filesystem\FilesystemAdapter;
use Illuminate\Http\UploadedFile;
use Intervention\Image\Facades\Image;
use P3in\Interfaces\GalleryItemInterface;
use P3in\Models\GalleryItem;
use P3in\Models\GalleryItemObserver;
use P3in\Models\GalleryItemScope;

class Photo extends GalleryItem implements GalleryItemInterface
{
    /**
     * Attributes appendend by default
     */
    protected $appends = ['dimensions', 'resolution'];

    public function getType()
    {
        return 'photo';
    }

    public function getDefaultStorage() {
        return $this->gallery->getStorage();
    }

    public function getBasePath() {
        return 'photos/'.date('m-y');
    }

    public function afterStorage()
    {
        $this->user()->associate(\Auth::user());
        $this->setMetaFromExif();
    }

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
    *
    *
    */
    public function getNameAttribute()
    {
        $res = $this->getMeta('FileName', $this->attributes['path']);
    }

    /**
    *
    *
    */
    public function getXResolutionAttribute()
    {
        $res = $this->getMeta('XResolution');
        return $this->formatResolution($res);
    }

    /**
    *
    *
    */
    public function getYResolutionAttribute()
    {
        $res = $this->getMeta('YResolution');
        return $this->formatResolution($res);
    }

    private function formatResolution($res)
    {
        if ($res) {
            $res = explode('/', $res);

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
        return $this->getMeta('height');
    }

    /**
    *
    *
    */
    public function getWidthAttribute()
    {
        return $this->getMeta('width');
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
