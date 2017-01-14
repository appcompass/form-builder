<?php

namespace P3in\Controllers;

use Illuminate\Http\Request;
use P3in\Interfaces\WebsiteMenusRepositoryInterface;
use P3in\Models\NavItem;
use P3in\Models\Page;

class WebsiteMenusController extends AbstractChildController
{

    public function __construct(WebsiteMenusRepositoryInterface $repo)
    {
        $this->repo = $repo;
    }

    public function show($parent, $model)
    {

        return [
            'id' => $model->id,
            'menu-editor' => [
                'menu' => $model->render(),
                'repo' => $parent->pages,
                'deletions' => []
            ]
        ];

    }

    public function update(Request $request, $parent, $menu)
    {

        $menu_structure = $this->flatten($request->get('menu-editor')['menu']);

        $deletions = $request->get('menu-editor')['deletions'];

        foreach ($deletions as $deletee_id) {

            // deletions are always NavItems
            $navitem = NavItem::findOrFail($deletee_id)->delete();

        }

        foreach ($menu_structure as $item) {

            if (isset($item['navigatable_id'])) { // this is a NavItem

                // being this a navitem, we're sure the id is a navitem id

                // so fetch it
                $navitem = NavItem::findOrFail($item['id']);

                // update it's content
                $navitem->fill($item)->save();

                // then set parent if applicable, or null it to be sure (setParent takes care of saving as well)
                if (!is_null($item['parent_id'])) {

                        $parent_item = $navitem->setParent(NavItem::findOrFail($item['parent_id']));

                } else {

                    $navitem->setParent(null);

                }

                // finally, make sure the item belongs to the correct menu (current one obv)
                if (is_null($navitem->menu_id)) {

                    $menu->add($navitem);

                }


            } else {

                // this must be a Page instance (because otherwise logic is flawed)

                // in order for this to work we must pass an array of overrides to the Navitem::fromModel (label changes, overrides in general)

                $navitem = NavItem::fromModel(Page::findOrFail($item['id']), $item);

                // set navitem parent

                $navitem->setParent(Navitem::findOrFail($item['parent_id']));

                // add navitem to current menu

                $menu->add($navitem);

            }

        }

    }

    private function flatten(array $menu, $parent_id = null, $sort = null)
    {
        $res = [];

        if (is_null($sort)) {

            $sort = 0;

        }

        foreach($menu as $branch) {

            $branch['parent_id'] = $parent_id;

            $branch['sort'] = $sort++;

            $children = $branch['children'];

            unset($branch['children']);

            $res[] = $branch;

            if (count($children)) {

                $res = array_merge($res, $this->flatten($children, $branch['id'], $sort));

                $branch['children'] = null;

            }


        }

        return $res;
    }
}