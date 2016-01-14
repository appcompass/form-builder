<?php

namespace P3in\Controllers;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use P3in\Controllers\UiBaseController;
use P3in\Models\NavigationItem;
use P3in\Models\Navmenu;
use P3in\Models\Section;
use P3in\Models\Website;

class CpWebsiteNavigationController extends UiBaseController
{
    public $meta_install = [
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
        $this->module_name = 'websites';

        $this->setControllerDefaults();
    }

  /**
   *  Store
   */
  public function index($website_id)
  {

    $website = Website::managedById($website_id)->load('navmenus', 'pages');

    $navmenus = $website->navmenus()->whereNull('parent_id')->get();

    $navitems = [];

    // get navitem component out of all the website's pages
    foreach ($website->pages as $page) {

      $navitems[] = $page->navItem;

    }

    $utilities = Section::byType('utils')->get();

    $utils = [];

    foreach ($utilities as $util) {

      $utils[] = $util->navItem;

    }

    return view('navigation::index')
      ->with('website', $website)
      ->with('navmenus', $navmenus)
      ->with('utils', $utils)
      ->with('items', $navitems);
  }

  /**
   *  Edit
   */
  public function edit($website_id, $navitem_id)
  {
    $website = Website::managedById($website_id)->load('navmenus', 'pages');

    $navItem = NavigationItem::findOrFail($navitem_id);

    return view('navigation::edit-navmenu')
      ->with('navItem', $navItem)
      ->with('website', $website);
  }

  /**
   *  Create
   */
  public function create($website_id)
  {

    if (\Request::get('parent') === null) {

      return abort(500, "Error!");

    }

    $website = Website::managedById($website_id)->load('navmenus', 'pages');

    $parent = $website->navmenus()->where('name', '=', \Request::get('parent'))->firstOrFail();

    return view('navigation::create-navmenu')
      ->with('parent', $parent)
      ->with('website', $website);
  }

  /**
   * Update
   */
  public function update(Request $request, $website_id, $navitem_id) {}

  /**
   * Destroy
   */
  public function destroy(Request $request, $website_id, $item_id) {}

  /**
   *
   */
  public function store(Request $request, $website_id)
  {

    $this->validate($request, [
        'navmenu_name' => 'required',
        'hierarchy' => 'required'
    ]);

    $website = Website::managedById($website_id);

    $navmenu = $website->navmenus()
      ->where('name', '=', $request->navmenu_name)
      ->firstOrFail();

    if ($request->pretend) {

      $navmenu = new Navmenu($navmenu->toArray());

      $this->parsePretend($navmenu, json_decode($request->hierarchy, true));

    } else {

      $navmenu = $navmenu->clean(true);

      $this->parseHierarchy($navmenu, json_decode($request->hierarchy, true), $website);

      $navmenu = $navmenu->fresh();

    }

    return $navmenu;

  }

  /**
   *  parsePretend
   */
  private function parsePretend(Navmenu $navmenu, array $hierarchy)
  {

    foreach($hierarchy as $index => $content) {

      $item = NavigationItem::findOrFail($content['id']);

      if (isset($content['children']) && count($content['children'])) {

        $original_item = $item;

        $child_nav = new Navmenu([
          'label' => $item['label']
        ]);

        $child_nav->id = $item->id;

        $navmenu->children->push($child_nav);

        $item = $child_nav->getNavigationItem(['has_content' => true]);

        $item->navigatable_id = $original_item->id;
        $item->id = $original_item->id;

        $this->parsePretend($child_nav, $content['children']);

      }

      $navmenu->items->push($item);

    }

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
        'new_tab' => isset($content['new_tab']) ? $content['new_tab'] : false
      ];

      $item->fill(array_replace($item->toArray(), $overrides));

      if (isset($content['children']) && count($content['children'])) {

          $child_nav = Navmenu::byName($item->label);

          $navmenu->addChildren($child_nav, null, $overrides);

          $website->navmenus()->save($child_nav);

          $this->parseHierarchy($child_nav, $content['children'], $website);

      } else {

          $navmenu->addItem($item, null, $overrides);

      }

    }

  }

}