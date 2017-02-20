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
    private $menu;
    private $item;

    private $allowedModels = [Page::class, Link::class];

    // we only set the MenuItem second param when we are looking to add child items to a parent item
    // not sure how I feel about this aproach here though.
    public function __construct(Menu $menu = null, MenuItem $item = null)
    {
        if (!is_null($menu)) {
            $this->menu = $menu;
        }
        if (!is_null($item)) {
            $this->item = $item;
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

        // @TODO inject website->pages so we can link them from within the closure
        // $website->load('pages');

        if ($closure) {
            $closure($instance);
        }

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
    public function add($item, $order = 1)
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

        $menu_item = $item->makeMenuItem($order);

        $this->menu->add($menu_item);

        // @TODO this is odd, based on the fact an item exists, we should have a cleaner api for that
        $menu_item->setParent($this->item);

        return new static($this->menu, $menu_item);
    }


    /**
     * Sets the icon.
     *
     * @param      string  $name   The name
     *
     * @return     <type>  ( description_of_the_return_value )
     */
    public function setIcon($name = '')
    {
        $this->item->icon($name);

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
}