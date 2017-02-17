<?php

namespace P3in\Controllers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use P3in\Interfaces\WebsiteMenusRepositoryInterface;
use P3in\Models\Link;
use P3in\Models\MenuItem;
use P3in\Models\Page;

class WebsiteMenusController extends AbstractChildController
{
    public function __construct(WebsiteMenusRepositoryInterface $repo)
    {
        $this->repo = $repo;
    }

    public function update(Request $request, Model $parent, Model $menu)
    {
        $menu_structure = $this->flatten($request->get('menu')['menu']);

        // housekeeping
        foreach ($request->get('menu')['deletions'] as $deletee_id) {

            // deletions are always MenuItems we make sure we clean whole branches
            $this->clean(MenuItem::findOrFail($deletee_id));
        }

        foreach ($menu_structure as $menuitem) {
            if (is_null($menuitem->menu_id)) {
                $menu->add($menuitem);
            }
        }
    }


    /**
     * Recursively remove MenuItem and children
     *
     * @param      \P3in\Models\MenuItem  $menuitem  The menuitem
     */
    private function clean(MenuItem $menuitem)
    {
        $children = MenuItem::where('parent_id', $menuitem->id)->get();

        if ($children) {
            foreach ($children as $child) {
                $this->clean($child);
            }
        }

        $menuitem->delete();

        return;
    }

    /**
     * Obtains a MenuItem from an array of properties expects either `type` or
     * `navigatable_id` to be set
     *
     * @param      array  $item   Properties of the item
     *
     * @return     array  The menu item.
     */
    private function getMenuItem(array $item): MenuItem
    {
        // item is a MenuItem (has the polymorphic ref)
        if (isset($item['navigatable_id'])) {
            $menuitem = MenuItem::findOrFail($item['id']);
        } else {

            // doing the extra mile here to greatly simplify the frontend stuff
            switch ($item['type']) {
                case 'Link':
                    $class_name = Link::class;
                    break;
                case 'Page':
                    $class_name = Page::class;
                    break;
            }

            // otherwise generate a MenuItem instance from model being added
            $menuitem = MenuItem::fromModel($class_name::findOrFail($item['id']), $item['order']);
        }

        $menuitem->fill($item)->save();

        return $menuitem;
    }

    /**
     * flattens a menu, converts item into MenuItem
     *
     * @param      array    $menu       The menu
     * @param      <type>   $parent_id  The parent identifier
     * @param      integer  $order      The order
     *
     * @return     array    ( description_of_the_return_value )
     */
    private function flatten(array $menu, $parent_id = null, $order = null)
    {
        $res = [];

        if (is_null($order)) {
            $order = 0;
        }

        foreach ($menu as $branch) {
            $branch['order'] = $order++;

            $menuitem = $this->getMenuItem($branch);

            $menuitem->setParent(MenuItem::find($parent_id));

            $menuitem->save();

            $children = $branch['children'];

            $res[] = $menuitem;

            if (count($children)) {
                $res = array_merge($res, $this->flatten($children, $menuitem->id, $order));
            }
        }

        return $res;
    }
}
