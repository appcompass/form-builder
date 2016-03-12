<?php

namespace P3in\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OpenCloud\Rackspace;
use P3in\Interfaces\GalleryItemInterface;
use GuzzleHttp\Client as GuzzleClient;
use P3in\Models\User as User;
use P3in\Traits\AlertableTrait;
use P3in\Traits\NavigatableTrait;
use P3in\Traits\OptionableTrait;
use P3in\Traits\SettingsTrait;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class Video extends Model implements GalleryItemInterface
{

    use OptionableTrait, SettingsTrait, AlertableTrait, NavigatableTrait, SoftDeletes;

    /**
    * Table Name
    */
    protected $table = 'videos';

    /**
    * Fillable Attributes
    */
    protected $fillable = [
        'name',
        'meta',
        'storage'
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
    *   Allow multiple owners through polymorphic
    *
    */
    public function videoable()
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
    *    [name] an override, say for example when we are storing a logo
    * @param disk disk Disk Instance
    * @return \P3in\Models\Video
    *
    * @TODO Refactor this big time
    */
    public static function store(UploadedFile $file, User $user, $attributes = [], $disk = null)
    {

        // TODO: We need to create a wistia disk instance as well as an ffmpeg processing disk image.
        // for now, we just use the wistia API directly from here.

        $ext = $file->getClientOriginalExtension();
        $name = $file->getClientOriginalName();

        $client = new GuzzleClient();

        try {
            $response = $client->request('POST', env('WISTIA_UPLOAD_URL'), [
                'multipart' => [
                    [
                        'name'     => 'api_password',
                        'contents' => env('WISTIA_API_PASSWORD')
                    ],[
                        'name'     => 'project_id',
                        'contents' => env('WISTIA_PROJECT_ID')
                    ],[
                        'name'     => 'name',
                        'contents' => $name
                    ],[
                        'name'     => 'file',
                        'contents' => fopen($file->getRealpath(), 'r')
                    ]
                ]
            ]);

            $rtn = json_decode((string) $response->getBody());

            $video = new Video([
                'name' => $rtn->name,
                'storage' => 'wistia'
            ]);

            $video->meta = [
                'thumbnail' => $rtn->thumbnail->url,
                'id' => $rtn->id,
                'hashed_id' => $rtn->hashed_id,
                'duration' => $rtn->duration,
            ];

            $video->user()->associate($user);

            $video->save();

            return $video;

        } catch (RequestException $e) {

            dd($e);

        }
    }

}
