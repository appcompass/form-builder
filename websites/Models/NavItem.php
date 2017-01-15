<?php

namespace P3in\Models;

use Exception;
use Illuminate\Database\Eloquent\Model;
use P3in\Models\Menu;
use P3in\Models\Page;

class NavItem extends Model
{
    protected $fillable = [
        'title',
        'alt',
        'new_tab',
        'sort'
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
        return $this->belongsTo(NavItem::class, 'parent_id');
    }

    /**
     * children
     *
     * @return     HasMany
     */
    public function children()
    {
        return $this->hasMany(NavItem::class, 'parent_id');
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
     * NavItems factory
     *
     * @param      <type>     $model  The model
     *
     * @throws     Exception  Model not allowed
     *
     * @return     <type>     NavItem generator
     */
    public static function fromModel($model, array $attributes = null)
    {
        $allowedModels = ['P3in\Models\Page', 'P3in\Models\Link'];

        $model_class = get_class($model);

        if (! in_array($model_class, $allowedModels)) {
            throw new Exception("Model not allowed: {$model_class}");
        }

        switch ($model_class) {
            case "P3in\Models\Page":
                return static::fromPage($model, $attributes);
                break;
            case "P3in\Models\Link":
                return static::fromLink($model, $attributes);
                break;
        }
    }

    /**
     * fromPage
     *
     * @param      \App\Page  $page   The page
     *
     * @return     NavItem
     */
    private static function fromPage(Page $page, array $attributes = null)
    {
        return NavItem::create([
            'navigatable_id' => $page->id,
            'navigatable_type' => get_class($page),
            'title' => isset($attributes['title']) ? $attributes['title'] : $page->title,
            'alt' => isset($attributes['description']) ? $attributes['description']: 'Alt Link Text Placeholder',
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
    private static function fromLink(Link $link)
    {
        return NavItem::create([
            'navigatable_id' => $link->id,
            'navigatable_type' => get_class($link),
            'title' => $link->title,
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
    public function setParent(NavItem $item = null)
    {
        if (is_null($item)) {
            $this->parent_id = null;
        } else {
            $this->parent_id = $item->id;
        }

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
