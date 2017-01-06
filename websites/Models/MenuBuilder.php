<?php

namespace P3in\Models;

use P3in\Models\Menu;
use P3in\Models\Link;
use Closure;

class MenuBuilder
{

    /**
     * Menu instance
     */
    private $menu;

    private function __construct(Menu $menu = null)
    {
        if (!is_null($menu)) {

            $this->menu = $menu;

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

        $instance->menu = Menu::create([

            'name' => $name,
            'website_id' => $website->id

        ]);

        if ($closure) {

            $closure($instance);

        }

        return $instance;
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

        if ($item instanceof NavItem) {

            $nav_item = $item;

        } else if ($item instanceof Link) {

            $nav_item = NavItem::fromLink($item);

        } else if (is_array($item)) {

            $nav_item = NavItem::fromLink(Link::create($item));

        } else if ($item instanceof Page) {

            $nav_item = NavItem::fromPage($item);

        } else {

            throw new \Exception("Trying to add something i don't understand");

        }

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

        } else if ($item instanceof NavItem) {

            $nav_item = $this->menu->items()->where('id', $item->id)->firstOrFail();

        }

        if ($nav_item->delete()) {

            return true;

        } else {

            throw new \Exception("Errors while removing NavItem");

        }

    }

}