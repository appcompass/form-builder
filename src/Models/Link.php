<?php

namespace P3in\Models;

use Exception;
use Illuminate\Database\Eloquent\Model;
use P3in\Interfaces\Linkable;
use P3in\Models\MenuItem;
use P3in\Models\Website;
use Validator;

class Link extends Model implements Linkable
{
    protected $fillable = [
        'title',
        'url',
        'alt',
        'new_tab',
        'clickable',
        'icon',
        'content'
    ];

    private $rules = [
        'title' => 'required',
        'url' => 'required_if:clickable,true',
        'alt' => 'required',
        'new_tab' => 'required',
        // 'clickable' => ''
    ];

    public $appends = ['type'];

    /**
     * Website
     *
     * @return     BelongsTo    Website
     */
    public function website()
    {
        return $this->belongsTo(Website::class);
    }

    /**
     * Makes a menu item.
     *
     * @param      integer   $order  The order
     *
     * @return     MenuItem  ( description_of_the_return_value )
     */
    public function makeMenuItem($order = 0): MenuItem
    {
        $attributes = collect($this->getAttributes())
            ->only(['title','alt','order','new_tab','url','clickable','icon']);
        $item = new MenuItem($attributes->all());
        $item->order = $order;

        $item->navigatable()->associate($this);

        return $item;
    }

    public function getTypeAttribute()
    {
        return 'Link';
    }
}
