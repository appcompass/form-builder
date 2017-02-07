<?php

namespace P3in\Models;

use Illuminate\Database\Eloquent\Model;
use P3in\Interfaces\Linkable;
use P3in\Models\MenuItem;
use Validator;
use Exception;

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
     * Makes a menu item.
     *
     * @param      integer   $order  The order
     *
     * @return     MenuItem  ( description_of_the_return_value )
     */
    public function makeMenuItem($order = 0): MenuItem
    {
        $item = new MenuItem([
            'title' => $this->title,
            'alt' => $this->alt,
            'order' => $order,
            'new_tab' => $this->new_tab,
            'url' => $this->url,
            'clickable' => $this->clickable,
            'icon' => $this->icon
        ]);

        $item->navigatable()->associate($this);

        return $item;
    }

    public function getTypeAttribute()
    {
        return 'Link';
    }

    // backward compatibility
    public function getFullUrlAttribute()
    {
        return $this->url;
    }
}