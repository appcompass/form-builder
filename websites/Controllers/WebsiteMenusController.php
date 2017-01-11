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
                'repo' => $parent->pages
            ]
        ];

    }

    public function update(Request $request, $parent, $model)
    {
        $menu = $request->get('menu-editor')['menu'];

        $flattened_shiet = $this->flatten($menu);

        foreach ($flattened_shiet as $item) {

            if (isset($item['navigatable_id'])) { // this is a NavItem

                // being this a navitem, we're sure the id is a navitem id

                try {

                    $navitem = NavItem::findOrFail($item['id']);

                } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {

                    dd($item);

                }


                if (is_null($navitem)) {

                    dd($item);

                }

                $navitem->fill($item)->save();

                if (!is_null($item['parent_id'])) {

                    // echo "$item[id] $item[label] $item[parent_id]<br>";

                    try {

                        $parent_item = $navitem->setParent(NavItem::findOrFail($item['parent_id']));

                        if (is_null($parent_item)) {

                            dd("Parent not found: " + $item['parent_id']);

                        }

                    } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {

                        dd($item);

                    }


                } else {

                    $navitem->setParent(null);

                }


            } else {

                dd("here");

                // this must be a Page instance (because otherwise...)

                $navitem = NavItem::fromModel(Page::findOrFail($item['id']), $item); // in order for this to work we must pass an array of overrides to the Navitem::fromModel

                // set navitem parent

                $navitem->setParent(Navitem::findOrFail($item['parent_id']));

                // add navitem to current menu

                $model->add($navitem);

            }

        }

    }

    private function flatten(array $menu, $parent_id = null)
    {
        $res = [];

        foreach($menu as $branch) {

            $branch['parent_id'] = $parent_id;

            if (isset($branch['children']) && count($branch['children']) > 0) {

                $res = array_merge($res, $this->flatten($branch['children'], $branch['id']));

                $branch['children'] = null;

            }

            $res[] = $branch;

        }

        return $res;
    }
}