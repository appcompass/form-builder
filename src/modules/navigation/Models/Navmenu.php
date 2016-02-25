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
        'req_perms',
        'parent_id',
        'website_id',
        'max_depth',
        'temp'
    ];

    protected $with = ['children.navitems', 'navitems'];

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
    public function addChildren(Navmenu $navmenu, $order = null, $overrides = [])
    {

        $this->children()->save($navmenu);

        $this->addItem($navmenu, $order, $overrides);

        return;
    }

    /**
     *  Unlink or delete a child nav
     *
     */
    public function removeChildren(Navmenu $navmenu, $delete = false)
    {
        if ($delete) {

            return $navmenu->delete();

        } else {

          $navmenu->parent_id = null;

          return $navmenu->save();

        }

    }

    /**
     *  Link navmenu to NavitemNavmenu items
     *
     *  NavitemNavmenu is the pivot table that links an instance of a NavigationItem to a specific Navmenu
     */
    public function navitems()
    {

        $user_perms = [];

        if (\Auth::check()) {

            $user_perms = \Auth::user()->allPermissions()->toArray();

        }

        return $this->hasMany(NavitemNavmenu::class)
            ->whereHas('navitem', function($q) use ($user_perms) {
                $q->whereNull('req_perms');
                $q->orWhereIn('req_perms', array_keys($user_perms));
        })->orderBy('order');
    }

    /**
     *  Clean
     *  Keep data consistent by cleaning up the navmenus structure
     *  @param boolean delete true = delete all children false = unlink the children
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

        $this->navitems()->delete();

        $this->load('navitems');

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
    public function hasChildren($id = null)
    {
        if (!is_null($id)) {

            return (bool) $this->children->find($id);

        }

        return (bool) $this->children->count();
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
    public function addItem($navItem, $order = null, $overrides = [])
    {

        if (method_exists($navItem, 'navItem')) {
            return $this->addItem($navItem->navItem($overrides)->first(), $order, $overrides);
        }

        if (! $navItem instanceof NavigationItem) {
            throw new Exception("Can't add item to {$this->name}.");
        }

        $navitem_navmenu = NavitemNavmenu::firstOrNew([
            'navmenu_id' => $this->id,
            'navigation_item_id' => $navItem->id,
            'label' => isset($overrides['label']) ? $overrides['label'] : $navItem['label'],
            'url' => isset($overrides['url']) ? $overrides['url'] : $navItem['url'],
            'new_tab' => isset($overrides['new_tab']) ? $overrides['new_tab'] : $navItem['new_tab']
        ]);

        if (!is_null($order)) {
            $navitem_navmenu->order = $order;
        }

        $navitem_navmenu->save();

        if (! $this->navitems->contains($navitem_navmenu)) {

            if (is_null($order)) {

                $order = intVal( DB::table('navigation_item_navmenu')
                    ->where('navmenu_id', '=', $this->id)
                    ->max('order') ) + 1;

                $navitem_navmenu->order = $order;

                $navitem_navmenu->save();
            }

        }

        return true;

    }

    public function addItems($items)
    {
        foreach ($items as $i => $item) {
            $this->addItem($item, $i);
        }
    }

    /**
     *  Get or create navigation menu by name
     *
     */
    public function scopeByName($query, $name, $label = null)
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

            $navmenu->load('navitems', 'children.navitems');

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
            "req_perms" => null,
            "props" => []
        ], $overrides);
    }
}
