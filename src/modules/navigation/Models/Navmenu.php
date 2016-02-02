<?php

namespace P3in\Models;

use DB;
use Exception;
use Illuminate\Database\Eloquent\Model;
use P3in\Models\NavigationItem;
use P3in\Traits\NavigatableTrait;

class Navmenu extends Model
{

    use NavigatableTrait;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'navmenus';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'label',
        'req_permission',
        'parent_id',
        'website_id',
        'max_depth',
        'temp'
    ];

    protected $with = ['children.items', 'items'];

    /**
     *  Get a navmenu by name
     *
     *
     */
    public function scopeName($query, $name)
    {
        return $query->where('name', $name);
    }

    /**
     *  Relation to self (parent)
     *
     */
    public function parent()
    {
      return $this->belongsTo(Navmenu::class, 'parent_id');
    }

    /**
     * Set a parent of this navmenu
     *
     */
    public function setParent(Navmenu $navmenu)
    {
      return $this->parent()->associate($navmenu);
    }

    /**
     *  Relation to self (children)
     *
     */
    public function children()
    {
        return $this->hasMany(Navmenu::class, 'parent_id');
    }

    /**
     *  Add a child nav
     *
     */
    public function addChildren(Navmenu $navmenu, $order = null, $overrides = [], $pretend = false)
    {

        if ($pretend) {

            $this->children->push($navmenu);

        } else {

            $this->children()->save($navmenu);

        }

        $this->addItem($navmenu, $order, $overrides, $pretend);

        return;
    }

    /**
     *  Unlink or delete a child nav
     *
     */
    public function removeChildren(Navmenu $navmenu, $delete = false)
    {
        if ($delete) {

            $navmenu->delete();

        } else {

          $navmenu->parent_id = null;

        }

      return $navmenu->save();
    }
  /**
   *
   *
   *
   */
    public function item()
    {
        return $this->item();
    }

    /**
     *  Link items to Navigation Items
     *
     */
    public function items()
    {

        return $this->belongsToMany(NavigationItem::class)
            ->withPivot('id', 'order', 'label', 'url', 'new_tab')
            ->orderBy('pivot_order');

    }

    /**
     *  Keep data consistent
     */
    public function clean($delete = false)
    {

        foreach($this->children as $child) {

            $child->clean(true);

            $this->removeChildren($child);

            if ($delete) {

                $child->delete();

            }

        }

        $this->items()->detach();

        $this->load('items');

        return $this;

    }

    /**
     *
     */
    public function hasParent()
    {
        return (bool) count($this->parent);
    }

    /**
     *
     */
    public function hasChildren()
    {
        return (bool) count($this->children);
    }

    /**
     *
     */
    public function getNextSubNav()
    {
        $prefix = $this->name.'_sub';

        $latest_name = static::whereRaw("name ~ '^{$this->name}_sub_([0-9]*)?$'")
            ->latest('id')
            ->pluck('name');

        if (is_null($latest_name)) {

            return $prefix.'_1';

        } else {

            $parts = explode('_', $latest_name);

            $number = end($parts);

            return $prefix.'_'.($number + 1);

        }
    }

    /**
     *  Try to link the instance passed to this navmenu
     *
     *  @param mixed $navItem either an instance of NavigationItem or an object which navItem's method returns an instance of NavigationItem
     */
    public function addItem($navItem, $order = null, $overrides = [], $pretend = false)
    {

        if (method_exists($navItem, 'navItem')) {

            return $this->addItem($navItem->navItem($overrides, $pretend)->first(), $order, $overrides, $pretend);

        }

        if (! $navItem instanceof NavigationItem) {

            throw new Exception("Can't add item to {$this->name}.");

        }

        if (! $this->items->contains($navItem)) {

            if (is_null($order)) {

                $order = intVal( DB::table('navigation_item_navmenu')
                    ->where('navmenu_id', '=', $this->id)
                    ->max('order') ) + 1;

            }

            if ($pretend) {

                $navItem['pivot'] = $overrides;

                $this->items->push($navItem);

            } else {

                // $navItem->save();

                $this->items()->attach($navItem, [
                    'order' => $order,
                    'label' => isset($overrides['label']) ? $overrides['label'] : $navItem['label'],
                    'url' => isset($overrides['url']) ? $overrides['url'] : $navItem['url'],
                    'new_tab' => isset($overrides['new_tab']) ? $overrides['new_tab'] : $navItem['new_tab']
                ]);

            }

        }

        return true;

    }

    /**
     *  Get or create navigation menu by name
     *
     */
    public function scopeByName($query, $name, $label = null, $pretend = false)
    {

        $navmenu = Navmenu::where('name', '=', $name)->first();

        if (is_null($navmenu)) {

            if (is_null($label)) {

                $label = ucfirst(str_replace('_', ' ', $name));

            }

            $navmenu = new Navmenu([
                'name' => $name,
                'label' => $label
            ]);

            if (!$pretend) {

                $navmenu->save();

            }

            $navmenu->load('items', 'children.items');

        }

        return $navmenu;

    }

    /**
     * Navmenu making routine
     *
     * TODO expand on overrides
     */
    public function make(array $attributes = [])
    {

      return Navmenu::create($attributes);

    }

    /**
     *  NavigatableTrait implementation
     *
     */
    public function makeLink($overrides = [])
    {
        return array_replace([
            "label" => $this->label,
            "url" => '',
            "has_content" => false,
            "req_perms" => null,
            "props" => []
        ], $overrides);
    }
}
