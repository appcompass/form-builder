<?php

namespace P3in\Controllers;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use P3in\Controllers\UiBaseController;
use P3in\Models\NavigationItem;
use P3in\Models\NavitemNavmenu;
use P3in\Models\Navmenu;
use P3in\Models\Section;
use P3in\Models\Website;

class CpWebsiteNavigationController extends UiBaseController
{
    public $meta_install = [
        'classname' => Navmenu::class,
        'index' => [
            'data_targets' => [
                [
                    'route' => 'websites.show',
                    'target' => '#main-content-out',
                ],[
                    'route' => 'websites.navigation.index',
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
                    'route' => 'websites.pages.edit',
                    'target' => '#record-detail',
                ],
            ],
            'heading' => 'Page Informations',
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
   *  Store
   */
  public function index(Website $websites)
  {

        // $websites->load('navmenus.navitems', 'pages', 'pages.navitem');

        // $navmenus = $websites->navmenus()->whereNull('parent_id')->get();
        // // dd($navmenus->toArray());
        // foreach($websites->pages as $page) {
        //   $navitems[] = $page->navItem()
        //     ->first()
        //     ->toArray();
        // }

        // foreach (Section::byType('utils')->with('navitem')->get() as $util) {
        //   $utils[] = $util->navItem()
        //     ->first()
        //     ->toArray();
        // }

        // return view('navigation::index', compact('navmenus', 'navitems', 'utils'))
        //   ->with('website', $websites);
  }

  /**
   *
   */
  public function store(Request $request, Website $websites)
  {

    $this->validate($request, [
        'navmenu_name' => 'required',
        'hierarchy' => 'required'
    ]);

    $navmenu = $websites->navmenus()
      ->where('name', '=', $request->navmenu_name)
      ->firstOrFail();

    if ($request->pretend == 'true') {

        $navmenu = new Navmenu($navmenu->toArray());

        $navmenu->load('children.navitems', 'navitems');

        $this->parsePretend($navmenu, json_decode($request->hierarchy, true));

    } else {

        $navmenu = $navmenu->clean(true);

        $this->parseHierarchy($navmenu, json_decode($request->hierarchy, true), $websites);

        $navmenu = $navmenu->fresh();

    }

    return $navmenu;

  }

    /**
    *  parsePretend
    *
    *  generates a navmenu hierarchy on the fly, without persisting
    */
    private function parsePretend(Navmenu $navmenu, array $hierarchy)
    {

        foreach($hierarchy as $content) {

            list($discard, $id) = explode('_', $content['id']);

            if (isset($content['pivot'])) {

                $pivot = NavitemNavmenu::findOrFail($content['pivot']);

            } else {

                $navitem = NavigationItem::findOrFail($id);

                $pivot = new NavitemNavmenu([
                    'navmenu_id' => $navmenu->id,
                    'navigation_item_id' => $navitem->id,
                    'order' => null,
                    'label' => $navitem->label,
                    'url' => $navitem->url,
                    'props' => $navitem->props,
                    'new_tab' => false
                ]);

                $pivot->id = null;

            }

            if (isset($content['children']) && count($content['children'])) {

                $child_nav = new Navmenu(['label' => $pivot->label ]);

                $child_nav->load('children.navitems', 'navitems');

                $child_nav->id = $pivot->linked_id;

                $this->parsePretend($child_nav, $content['children'], $navmenu);

                $navmenu->children->push($child_nav);

            }

            $navmenu->navitems->push($pivot);

        }

        return $navmenu;

    }

  /**
   *
   */
  private function parseHierarchy(Navmenu $navmenu, array $hierarchy, Website $website)
  {

    foreach($hierarchy as $index => $content) {

      $item = NavigationItem::findOrFail($content['id']);

      $overrides = [
        'label' => isset($content['label']) ? $content['label'] : $item->label,
        'url' => isset($content['url']) ? $content['url'] : $item->url,
        'props' => isset($content['props']) ? $content['props'] : [],
        'new_tab' => isset($content['new_tab']) ? $content['new_tab'] : false
      ];

      if ( (isset($content['children']) && count($content['children'])) ) {

          $child_nav = $website->navmenus()->byName($item->label);

          $navmenu->addChildren($child_nav, null, $overrides);

          $website->navmenus()->save($child_nav);

          $this->parseHierarchy($child_nav, $content['children'], $website);

      } else {

        $item->fill(array_replace($item->toArray(), $overrides));

        $overrides['content'] = isset($content['content']) ? $content['content'] : '';

        $navmenu->addItem($item, null, $overrides);

      }

    }

    return $navmenu;

  }

}
