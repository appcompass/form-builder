<?php

namespace P3in\Models;

use Illuminate\Database\Eloquent\Model;
use P3in\Models\NavigationItem;
use P3in\Models\Navmenu;
use P3in\Models\Page;

class NavitemNavmenu extends Model
{

    protected $table = 'navigation_item_navmenu';

    protected $fillable = ['order', 'label', 'navmenu_id', 'navigation_item_id', 'url', 'new_tab', 'content', 'props'];

    protected $with = ['navitem'];

    protected $dates = [];

    public $timestamps = [];

    protected $appends = ['linked_id', 'linked_model', 'req_perms'];

    protected $casts = ['props' => 'array'];

    public function navitem()
    {
        return $this->belongsTo(NavigationItem::class, 'navigation_item_id');
    }

    public function navmenu()
    {
        return $this->belongsTo(Navmenu::class, 'navmenu_id');
    }

    public function getLabelAttribute()
    {
        return $this->attributes['label'] ?: $this->navitem->label;// : $this->label;
    }

    public function getLinkedIdAttribute()
    {
        return $this->navitem->navigatable_id;
    }

    public function getLinkedModelAttribute()
    {
        return $this->navitem->navigatable_type;
    }

    public function getLinkedNavigatableAttribute()
    {
        return $this->navitem->navigatable;
    }

    public function getReqPermsAttribute()
    {
        return $this->navitem->req_perms;
    }

    public function getUrlAttribute()
    {
        if ($this->linked_model == Page::class && $this->linked_navigatable) {
            // return $this->linked_navigatable->url; // This doesn't work as expected though it should.
            return $this->linked_navigatable->getUrl(); // this has greater overhead but it works for now till we replace this workflow.
        }
        return $this->attributes['url'];
    }

}
