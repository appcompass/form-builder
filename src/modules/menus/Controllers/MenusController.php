<?php

namespace P3in\Controllers;

use P3in\Controllers\UiBaseController;
use Illuminate\Http\Request;
use P3in\Models\MenuItem;
use P3in\Models\Website;
use P3in\Models\Menu;
use P3in\Models\Page;
use P3in\Models\Link;

class MenusController extends UiBaseController
{
    public $meta_install =
    [
        'classname' => Menu::class,
        'index' => [
            'data_targets' => [
                [
                    'route' => 'websites.show',
                    'target' => '#main-content-out',
                ],[
                    'route' => 'websites.menus.index',
                    'target' => '#record-detail',
                ],
            ],
        ],
        'update' => [
            'data_targets' => [
                [
                    'route' => 'websites.show',
                    'target' => '#main-content-out',
                ],[
                    'route' => 'websites.menus.edit',
                    'target' => '#record-detail',
                ],
            ],
            'heading' => 'Navigation Manager',
            'route' => 'pages.update'
        ],
    ];

    /**
     *  init
     */
    public function __construct()
    {
        $this->middleware('auth');

        $this->controller_class = __CLASS__;
        $this->nav_name = 'websites';

        $this->setControllerDefaults();
    }

    /**
     * Index
     *
     * @param      \Illuminate\Http\Request  $request   The request
     * @param      \P3in\Models\Website      $websites  The websites
     *
     * @return     <type>                    ( description_of_the_return_value )
     */
    public function index(Request $request, Website $websites)
    {

        $data = $this->prepareData($websites);

        return view('menus::index', $data);
    }

    /**
     * Store
     *
     * @param      \Illuminate\Http\Request  $request  The request
     * @param      \P3in\Models\Website      $website  The website
     *
     * @return     <type>                    ( description_of_the_return_value )
     */
    public function store(Request $request, Website $website)
    {
        $menu = Menu::create([
            'name' => $request->name,
            'website_id' => $website->id
        ]);

        return $this->prepareData($website);
    }

    /**
     * Update
     *
     * @param      \Illuminate\Http\Request  $request   The request
     * @param      \P3in\Models\Website      $websites  The websites
     * @param      \P3in\Models\Menu         $menus     The menus
     *
     * @return     <type>                    ( description_of_the_return_value )
     */
    public function update(Request $request, Website $websites, Menu $menus)
    {
        $menu_structure = $this->flatten($request->get('menu')['menu']);

        // housekeeping
        foreach ($request->get('menu')['deletions'] as $deletee_id) {

            // deletions are always MenuItems we make sure we clean whole branches
            $this->clean(MenuItem::findOrFail($deletee_id));
        }

        foreach ($menu_structure as $menuitem) {
            if (is_null($menuitem->menu_id)) {
                $menus->add($menuitem);
            }
        }

        return $websites->menus
            ->load('items')
            ->map(function($menu, $key) use($websites) {
                return [
                    'items' => $menu->render(),
                    'deletions' => [],
                    'name' => $menu->name,
                    'id' => $menu->id,
                    'website' => $websites->id
                ];
            });
    }

    /**
     * destroy
     *
     * @param      \Illuminate\Http\Request  $request  The request
     * @param      \P3in\Models\Website      $website  The website
     * @param      \P3in\Models\Menu         $menu     The menu
     *
     * @return     <type>                    ( description_of_the_return_value )
     */
    public function destroy(Request $request, Website $website, Menu $menu)
    {
        if ($website->menus->find($menu->id)->delete()) {

            return response()->json(['message' => 'Menu Deleted']);

        }

    }

    /**
     * prepareData for UI
     *
     * @param      \P3in\Models\Website  $website  The website
     *
     * @return     <type>                ( description_of_the_return_value )
     */
    private function prepareData(Website $website)
    {
        $menus = $website->menus
            ->load('items')
            ->map(function($menu, $key) use($website) {
                return [
                    'items' => $menu->render(),
                    'deletions' => [],
                    'name' => $menu->name,
                    'id' => $menu->id,
                    'website' => $website->id
                ];
            });


        $pages = $website->pages->each(function ($item) {
            $item->children = [];
            $item->type = 'Page';
        });

        $links = Link::all()->each(function ($item) {
            $item->children = [];
            $item->type = 'Link';
        });

        return compact('menus', 'pages', 'links');
    }

    /**
     * addLink
     *
     * @param      \Illuminate\Http\Request  $request  The request
     *
     * @return     array                     ( description_of_the_return_value )
     */
    public function addlink(Request $request)
    {
        if (!$request->has('alt')) {
            $request['alt'] = '';
        }
        $link = Link::create($request->except(['children']));

        $menuitem = MenuItem::fromModel($link);

        $menuitem->save();

        $link->children = [];

        $menuitem->children = [];

        return ['link' => $link, 'menuitem' => $menuitem];
    }

    /**
     * DeleteLink
     *
     * @param      \Illuminate\Http\Request  $request  The request
     * @param      \P3in\Models\Website      $website  The website
     * @param      \P3in\Models\Link         $link     The link
     *
     * @return     <type>                    ( description_of_the_return_value )
     */
    public function deleteLink(Request $request, Website $website, Link $link)
    {
        // @TODO move this in Link? who does housekeeping
        $menu_items = MenuItem::whereNavigatableId($link->id)->whereNavigatableType(get_class($link))->get()->pluck('id');

        // @TODO extend this method (meh) or add a 'deleting' listener (yay)
        $link->delete();

        MenuItem::whereIn('id', $menu_items)->delete();

        return response()->json(['message' => 'Model deleted.']);
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
        if (!isset($item['type'])) {
            dd($item);
        }

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
}
