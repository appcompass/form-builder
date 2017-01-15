<?php

namespace P3in\Builders;

use Closure;
use P3in\Builders\PageBuilder;
use P3in\Models\Link;
use P3in\Models\Menu;
use P3in\Models\NavItem;
use P3in\Models\Page;
use P3in\Models\Website;

class MenuBuilder
{

    /**
     * Menu instance
     */
    private $menu;
    private $parent_item;

    private $allowedModels = [Page::class, Link::class];

    // we only set the NavItem second param when we are looking to add child items to a parent item
    // not sure how I feel about this aproach here though.
    public function __construct(Menu $menu = null, NavItem $parent_item = null)
    {
        if (!is_null($menu)) {
            $this->menu = $menu;
        }
        if (!is_null($parent_item)) {
            $this->parent_item = $parent_item;
        }

        return $this;
    }

    /**
     * new
     *
     * @param      Menu  $menu   The menu
     *
     * @return     <type>   ( description_of_the_return_value )
     */
    public static function new($name, Website $website, Closure $closure = null)
    {
        $instance = new static();

        $menu = new Menu([
            'name' => $name,
        ]);

        $menu->website()->associate($website);

        $menu->save();

        $instance->menu = $menu;

        if ($closure) {
            $closure($instance);
        }

        return $instance;
    }

    public function addItem($item, $order = 1, $attributes = [], Closure $closure = null)
    {
        if (!$this->menu) {
            throw new \Exception('Menu not selected.');
        }

        if (is_array($item)) {
            $item = Link::create($item);
        }

        if ($item instanceof PageBuilder) {
            $item = $item->getPage();
        }

        if (!in_array(get_class($item), $this->allowedModels)) {
            throw new \Exception("Model " . get_class($item) ." is not allowed");
        }

        $nav_item = NavItem::create([
            'title' => isset($attributes['title']) ? $attributes['title'] : $item->title,
            'alt' => isset($attributes['alt']) ? $attributes['alt'] : $item->alt,
            'new_tab' => isset($attributes['new_tab']) ? $attributes['new_tab'] : $item->new_tab,
            'sort' => $order,
            'clickable' => isset($attributes['clickable']) ? $attributes['clickable'] : true
        ]);

        $nav_item->menu()->associate($this->menu);
        $nav_item->navigatable()->associate($item);

        if ($this->parent_item) {
            $nav_item->parent()->associate($this->parent_item);
        }

        $nav_item->save();

        if ($closure) {
            $instance = new static($this->menu, $nav_item);

            $closure($instance);
        }

        return $this;
    }

    /**
     * edit
     *
     * @param      <type>       $menu  The menu being edited
     *
     * @throws     \Exception   Menu must be set
     *
     * @return     MenuBuilder  MenuBuilder instance
     */
    public static function edit($menu)
    {
        if (!$menu instanceof Menu && !is_int($menu)) {
            throw new \Exception('Must pass id or menu instance');
        }

        if (is_int($menu)) {
            $menu = Menu::findOrFail($menu);
        }

        return new static($menu);
    }

    /**
     * add factory
     *
     * @param      $item        Mixed
     *
     * @throws     \Exception   (description)
     *
     * @return     NavItem      NavItem instance
     */
    public function add($item)
    {
        if (!$this->menu) {
            throw new \Exception('Menu not selected.');
        }

        if (is_array($item)) {
            $item = Link::create($item);
        }

        if (!in_array(get_class($item), $this->allowedModels)) {
            throw new \Exception("Model " . get_class($item) ." is not allowed");
        }

        $nav_item = NavItem::fromModel($item);

        if ($this->menu->add($nav_item)) {
            return $nav_item;
        } else {
            throw new \Exception("Something went wrong while adding the NavItem {$nav_item->id} to Menu {$this->menu->id}");
        }
    }

    /**
     * Drop NavItem
     *
     * @param      \App\NavItem  $nav_item  The navigation item
     */
    public function drop($item)
    {
        if (is_int($item)) {
            $nav_item = $this->menu->items()->where('id', $item)->firstOrFail();
        } elseif ($item instanceof NavItem) {
            $nav_item = $this->menu->items()->where('id', $item->id)->firstOrFail();
        }

        if ($nav_item->delete()) {
            return true;
        } else {
            throw new \Exception("Errors while removing NavItem");
        }
    }
}
