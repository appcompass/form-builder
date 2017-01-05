<?php

namespace P3in\Models;

use Illuminate\Database\Eloquent\Model;
use P3in\Models\Page;

class NavItem extends Model
{

    protected $fillable = [
        'url',
        'label',
        'navigatable_id',
        'navigatable_type',
        'alt',
        'new_tab'
    ];

    protected $hidden = [
        'navigatable'
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
     * Gets the url attribute.
     *
     * @return     <type>  The url attribute.
     */
    public function getUrlAttribute()
    {
        return isset($this->navigatable_id) ? $this->navigatable->url : $this->attributes['url'];
    }

    /**
     * fromPage
     *
     * @param      \App\Page  $page   The page
     *
     * @return     NavItem
     */
    public static function fromPage(Page $page)
    {
        return NavItem::create([
            'navigatable_id' => $page->id,
            'navigatable_type' => get_class($page),
            'label' => $page->title,
            'alt' => $page->description ?: 'Alt Link Text Placeholder',
            'new_tab' => false,
            'clickable' => true
        ]);
    }

    /**
     * fromLink
     *
     * @param      Link    $link   The link
     *
     * @return     NavItem
     */
    public static function fromLink(Link $link)
    {
        return NavItem::create([
            'url' => $link->url,
            'label' => $link->label,
            'alt' => $link->alt,
            'new_tab' => $link->new_tab,
            'clickable' => $link->clickable ?: true
        ]);
    }

    /**
     * Sets the parent.
     *
     * @param      NavItem  $item   The item
     *
     * @return     <type>   ( description_of_the_return_value )
     */
    public function setParent(NavItem $item)
    {
        $this->parent_id = $item->id;

        if ($this->save()) {

            return $this;

        } else {

            throw new \Exception('Unable to set Parent');

        }
    }

    /**
     * Makes a NavItem unclickable
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

            throw new \Exception('Unable to set clickable on NavItem');

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