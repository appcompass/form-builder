<?php

namespace P3in\Controllers;

use Illuminate\Http\Request;
use P3in\Interfaces\WebsiteMenusRepositoryInterface;
use P3in\Models\MenuItem;
use P3in\Models\Page;
use P3in\Models\Link;

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
            'menu' => [
                'menu' => $model->render(),
                'repo' => [
                    'pages' => $parent->pages,
                    'links' => Link::all()
                ],
                'deletions' => []
            ]
        ];
    }

    public function update(Request $request, $parent, $menu)
    {
        $menu_structure = $this->flatten($request->get('menu')['menu']);

        $deletions = $request->get('menu')['deletions'];

        foreach ($deletions as $deletee_id) {

            // deletions are always MenuItems
            $menuitem = MenuItem::findOrFail($deletee_id)->delete();
        }

        foreach ($menu_structure as $item) {

            if (isset($item['navigatable_id'])) { // this is a MenuItem

                // being this a menuitem, we're sure the id is a menuitem id

                // so fetch it
                $menuitem = MenuItem::findOrFail($item['id']);

                // update it's content
                $menuitem->fill($item)->save();

                // then set parent if applicable, or null it to be sure (setParent takes care of saving as well)
                $parent_item = $menuitem->setParent(MenuItem::find($item['parent_id']));

                // finally, make sure the item belongs to the correct menu (current one obv)
                if (is_null($menuitem->menu_id)) {
                    $menu->add($menuitem);
                }
            } else {

                // $menuitem = MenuItem::fromModel(Page::findOrFail($item['id']), $item);
                // generate a MenuItem instance from model being added
                $menuitem = MenuItem::fromModel($item['type']::findOrFail($item['id']), $item);

                $menuitem->setParent(MenuItem::find($item['parent_id']));

                $menu->add($menuitem);
            }
        }
    }

    private function flatten(array $menu, $parent_id = null, $order = null)
    {
        $res = [];

        if (is_null($order)) {
            $order = 0;
        }

        foreach ($menu as $branch) {
            $branch['parent_id'] = $parent_id;

            $branch['order'] = $order++;

            $children = $branch['children'];

            unset($branch['children']);

            $res[] = $branch;

            if (count($children)) {
                $res = array_merge($res, $this->flatten($children, $branch['id'], $order));

                $branch['children'] = null;
            }
        }

        return $res;
    }
}
