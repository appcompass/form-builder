<?php

namespace P3in\Models;

use Exception;
use Illuminate\Database\Eloquent\Model;
use P3in\Models\Menu;
use P3in\Models\Page;
use P3in\Models\Link;

class MenuItem extends Model
{
    protected $fillable = [
        'title',
        'alt',
        'new_tab',
        'order'
    ];

    protected $hidden = [
        'navigatable'
    ];

    public $appends = [
        'content', // get content through the Link if available
        'url',  // make sure we fetch the url from the linked element
        'type' // [Page|Link] for now, but the type in general
    ];

    /**
     * polymorphic
     *
     * @return     MorphTo
     */
    public function navigatable()
    {
        return $this->morphTo();
    }

    /**
     * parent
     *
     * @return     BelongsTo
     */
    public function menu()
    {
        return $this->belongsTo(Menu::class);
    }

    /**
     * parent
     *
     * @return     BelongsTo
     */
    public function parent()
    {
        return $this->belongsTo(MenuItem::class, 'parent_id');
    }

    /**
     * children
     *
     * @return     HasMany
     */
    public function children()
    {
        return $this->hasMany(MenuItem::class, 'parent_id');
    }


    /**
     * Gets the url attribute.
     *
     * @return     <type>  The url attribute.
     */
    public function getUrlAttribute()
    {
        if (is_null($this->navigatable)) {

            return null;

        }

        return $this->navigatable->url;
    }

    /**
     * Gets the content attribute.
     *
     * @return     <type>  The content attribute.
     */
    public function getContentAttribute()
    {
        if (get_class($this->navigatable) === Link::class) {

            return $this->navigatable->content;

        }

        return null;
    }

    /**
     * Gets the type attribute.
     */
    public function getTypeAttribute()
    {
        switch ($this->navigatable_type) {
            case 'P3in\Models\Link':
                return 'Link';
                break;
            case 'P3in\Models\Page':
                return 'Page';
                break;
        }
    }

    /**
     * MenuItems factory
     *
     * @param      <type>     $model  The model
     *
     * @throws     Exception  Model not allowed
     *
     * @return     <type>     MenuItem generator
     */
    public static function fromModel($model)
    {
        return $model->makeMenuItem();
    }

    /**
     * Sets the parent.
     *
     * @param      MenuItem  $item   The item
     *
     * @return     <type>   ( description_of_the_return_value )
     */
    public function setParent(MenuItem $item = null)
    {
        if (is_null($item)) {
            $this->parent()->dissociate();
        } else {
            $this->parent()->associate($item);
        }

        $this->save();

        return $this;
    }

    public function addChild(MenuItem $item)
    {
        $this->children()->save($item);
        return $this;
    }
    /**
     * Makes a MenuItem unclickable
     *
     * clickable defaults to true, so we revert it with this method
     *
     * @param      boolean  $clickable  The clickable
     */
    public function unclickable($clickable = false)
    {
        $this->clickable = $clickable;

        if ($this->save()) {
            return $this;
        } else {
            throw new \Exception('Unable to set clickable on MenuItem');
        }
    }

    /**
     * Icon
     *
     * @param      <type>  $name   The font-awesome name
     */
    public function icon($name)
    {
        $this->icon = $name;

        if ($this->save()) {
            return $this;
        } else {
            throw new \Exception('Unable to set icon');
        }
    }
}
