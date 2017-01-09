<?php

namespace P3in\Models;

use Illuminate\Database\Eloquent\Model;
use P3in\Models\Page;
use P3in\Models\Section;

class PageContent extends Model
{
    protected $table = 'page_section';

    protected $fillable = [
        'content',
        'order',
    ];

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
    public function section()
    {
        return $this->belongsTo(Section::class);
    }

    // /**
    //  *
    //  */
    // public function photos()
    // {
    //     return $this->morphMany(Photo::class, 'photoable');
    // }


}
