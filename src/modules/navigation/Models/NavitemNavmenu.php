<?php

namespace P3in\Models;

use Illuminate\Database\Eloquent\Model;
use P3in\Models\NavigationItem;
use P3in\Models\Navmenu;

class NavitemNavmenu extends Model
{

    protected $table = 'navigation_item_navmenu';

    protected $fillable = ['order', 'label', 'navmenu_id', 'navigation_item_id', 'url', 'new_tab'];

    protected $with = ['navitem'];

    protected $dates = [];

    public $timestamps = [];

    protected $appends = ['linked_id', 'linked_model', 'req_perms'];

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

    public function getReqPermsAttribute()
    {
        return $this->navitem->req_perms;
    }

}