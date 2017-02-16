<?php

namespace P3in\Builders;

use Closure;
use P3in\Builders\PageBuilder;
use P3in\Models\Link;
use P3in\Models\Menu;
use P3in\Models\MenuItem;
use P3in\Models\Page;
use P3in\Models\Website;

class MenuBuilder
{

    /**
     * Menu instance
     */
    private $menu = null;

    /**
     * Current MenuItem Instance
     */
    private $menu_item = null;

    /**
     * Parent instance
     */
    private $parent = null;

    private function __construct(Menu $menu)
    {
        $this->menu = $menu;
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
        $menu = Menu::create([
            'name' => $name,
            'website_id' => $website->id
        ]);

        $instance = new static($menu);

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
    public static function edit($menu, $parent = null)
    {
        if (!$menu instanceof Menu && !is_int($menu)) {
            throw new \Exception('Must pass id or menu instance');
        }

        if (is_int($menu)) {
            $menu = Menu::findOrFail($menu);
        }


        $instance = (new static($menu))->setParent($parent);

        return $instance;
    }

    /**
     * Adds an item.
     *
     * @param      <type>      $item   The item
     * @param      integer     $order  The order
     *
     * @throws     \Exception  (description)
     *
     * @return     <type>      ( description_of_the_return_value )
     */
    public function add($item, $order = 0)
    {

        if (!isset($this->menu)) {

            throw new \Exception('Menu not selected.');

        }

        if (is_array($item)) {

            // relying on default values requires a fresh() copy of the model
            $item = Link::create($item)->fresh();

        }

        $this->menu_item = MenuItem::fromModel($item, $order);

        if ($this->hasParent()) {

            // we are pointing the last inserted menu_item aka the parent -f
            $this->menu_item->setParent($this->parent->menu_item);
        }

        if ($this->menu->add($this->menu_item)) {

            // to have both worlds (return a MenuBuilder or a MenuItem) we return $this here
            // and we use a magic __call to check if we're calling methods MenuItem has -f
            return $this;

        } else {

            throw new \Exception("Something went wrong while adding the MenuItem {$this->menu_item->id} to Menu {$this->menu->id}");

        }

    }

    /**
     * { function_description }
     *
     * @return     self  ( description_of_the_return_value )
     */
    public function parent()
    {
        if (!$this->hasParent()) {
            // @TODO wouldn't end a while cycle
            return $this;
        }

        return $this->parent;
    }

    /**
     *
     */
    public function sub()
    {
        return MenuBuilder::edit($this->menu, $this);
    }

    /**
     * Sets the parent.
     *
     * @param      MenuBuilder  $menu_item  The menu builder
     */
    public function setParent(MenuBuilder $menu_builder = null)
    {
        $this->parent = $menu_builder;

        return $this;
    }

    /**
     * Determines if it has parent.
     *
     * @return     boolean  True if has parent, False otherwise.
     */
    public function hasParent()
    {
        return !!$this->parent;
    }

    /**
     * { function_description }
     *
     * @param      <type>  $method  The method
     * @param      <type>  $args    The arguments
     */
    public function __call($method, $args)
    {
        if (!method_exists($this->menu_item, $method)) {

            // @NOTE ignore and return this -f
            return $this;

        }

        call_user_func_array([$this->menu_item, $method], $args);

        return $this;
    }

    /**
     * Drop MenuItem
     *
     * @param      \App\MenuItem  $menu_item  The navigation item
     */
    public function drop($item)
    {
        if (is_int($item)) {
            $menu_item = $this->menu->items()->where('id', $item)->firstOrFail();
        } elseif ($item instanceof MenuItem) {
            $menu_item = $this->menu->items()->where('id', $item->id)->firstOrFail();
        }

        if ($menu_item->delete()) {
            return true;
        } else {
            throw new \Exception("Errors while removing MenuItem");
        }
    }

    /**
     *
     * @return     Function  ( description_of_the_return_value )
     */
    public function done() {

        return $this->menu;

    }
}
