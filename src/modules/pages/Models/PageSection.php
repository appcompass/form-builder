<?php

namespace P3in\Models;

use BostonPads\Models\Photo;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Support\Facades\Config;
use P3in\ModularBaseModel;
use P3in\Models\Page;
use P3in\Models\Section;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class PageSection extends ModularBaseModel
{
    /**
     *
     */
    protected $table = 'page_section';

    protected $fillable = [
        'section_id',
        'page_id',
        'section',
        'content',
        'order',
        'type',
    ];

    public $timestamps = false;

    protected $casts = [
        'content' => 'object'
    ];

    /**
     *
     */
    public function page()
    {
        return $this->belongsTo(Page::class);
    }

    /**
     *
     */
    public function website()
    {
        return $this->page->website();
    }

    /**
     *
     */
    public function template()
    {
        return $this->belongsTo(Section::class, 'section_id');
    }

    /**
     *
     */
    public function photos()
    {
        return $this->morphMany(Photo::class, 'photoable');
    }

    /**
     *
     */
    public function addPhoto(UploadedFile $file, User $user)
    {

        $disk = $this->website->getDiskInstance();

        $photo = Photo::store($file, $user, [
            'status' => Photo::STATUSES_ACTIVE,
            'storage' => $this->website->site_url
        ], $disk);

        $this->website
            ->gallery
            ->addPhoto($photo);

        return $this->photos()->save($photo);

    }

    public function render()
    {
        return [
            'view' => '/sections'.$this->template->display_view,
            'data' => $this->content,
        ];
    }

}