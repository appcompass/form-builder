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

    $website = Website::findOrFail($website_id)->load('navmenus', 'pages');

    $navmenus = $website->navmenus()->whereNull('parent_id')->get();

    $pages = $website->pages;

    $utilities = Section::byType('utils')->get();

    return view('navigation::index')
      ->with('website', $website)
      ->with('navmenus', $navmenus)
      ->with('pages', $pages)
      ->with('utilities', $utilities);
  }

  /**
   *  Edit
   */
  public function edit($website_id, $navitem_id)
  {
    $website = Website::findOrFail($website_id)->load('navmenus', 'pages');

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

    $website = Website::findOrFail($website_id)->load('navmenus', 'pages');

    $parent = $website->navmenus()->where('name', '=', \Request::get('parent'))->firstOrFail();

    return view('navigation::create-navmenu')
      ->with('parent', $parent)
      ->with('website', $website);
  }

  /**
   * Update
   */
  public function update(Request $request, $website_id, $navitem_id)
  {
    $this->validate($request, [
        'label' => 'required'
        // 'parent' => 'required',
    ]);

    $website = Website::findOrFail($website_id);

    if (is_numeric($navitem_id)) {

      $navItem = NavigationItem::findOrFail($navitem_id);

      $navItem->label = $request->label;

      $navItem->url = $request->url;

      if ($navItem->save()) {

        return $this->json($this->setBaseUrl(['websites', $website_id, 'navigation']));

      } else {

        return $this->json([], false, "Error updating this item.");

      }


    } else {

      $parent = Navmenu::where('name', '=', $request->parent)->firstOrFail();

      $navmenu_name = strtolower(str_replace(' ', '_', $request->label));

      $navmenu = Navmenu::byName($navmenu_name, $request->label);

      if (isset($request->url)) {

        $navmenu->navItem(['url' => $request->url]);

      }

      $parent->addChildren($navmenu);

      $website->navmenus()->save($navmenu);

      return $this->json($this->setBaseUrl(['websites', $website_id, 'navigation']));
    }



  }


  /**
   *
   */
  public function store(Request $request, $website_id)
  {

    $this->validate($request, [
        'item_id' => 'required',
        'navmenu_name' => 'required',
        'hierarchy' => 'required'
    ]);

    list($discard, $navitem_id) = explode('_', $request->item_id);

    $website = Website::findOrFail($website_id);

    $navmenu = $website->navmenus()
      ->where('name', '=', $request->navmenu_name)
      ->firstOrFail();

    // $navmenu = $navmenu->clean();
    $navmenu->clean();

    // clean up hierarchy coming from the ui
    $hierarchy = $this->knotit(json_decode($request->hierarchy, true), $navitem_id);

    // parse the structure, building the navmenu
    $this->parseHierarchy($navmenu, $hierarchy, $website);

    return $this->index($website_id);

  }

  /**
   * Destroy
   */
  public function destroy(Request $request, $website_id, $item_id)
  {

    $navigation_item_navmenu = \DB::table('navigation_item_navmenu')
      ->where('id', $item_id)
      ->first();

    $navigation_item = NavigationItem::findOrFail($navigation_item_navmenu->navigation_item_id);

    // if that's a container we empty it
    if ($navigation_item->has_content) {

      $navigation_item->navigatable->clean(true)->delete();

      // and delete it's navigation item
      $result = $navigation_item->delete();

    } else {

      $result = \DB::table('navigation_item_navmenu')
        ->where('id', $item_id)
        ->delete();

    }

    if ($result) {

      return redirect()->action('\P3in\Controllers\CpWebsiteNavigationController@index', [$website_id]);

    } else {

      return $this->json([], false, 'Unable to remove item.');

    }

  }

  /**
   *
   */
  private function parseHierarchy(Navmenu $navmenu, $hierarchy, Website $website)
  {

    foreach($hierarchy as $index => $content) {


      if (!isset($content['id'])) {

        continue;

      }

      $item = NavigationItem::findOrFail($content['id']);

      if ($item->has_content) {

        $child_nav = $this->createSubNav($item, $navmenu, $website);

        if (isset($content['children'])) {

          $this->parseHierarchy($child_nav, $content['children'], $website);

        }

      } else {

        try {

          $navmenu->addItem($item);

        } catch (\Exception $e) {

          return redirect()->action('\P3in\Controllers\CpWebsiteNavigationController@index', [$website->id])->with('message', 'unable to update navmenu.');

        }

      }

    }

  }

  /**
   *  Attaches a subnav to a passed navmenu and links it to a website
   *
   */
  private function createSubNav(NavigationItem $item, Navmenu $navmenu, Website $website)
  {

    switch(get_class($item->navigatable)) {

      case 'P3in\Models\Section':
        $child_nav = Navmenu::byName($navmenu->getNextSubNav());
        break;

      case 'P3in\Models\Navmenu':
        $child_nav = Navmenu::byName($item->navigatable->name);
        break;

      default:
        // will never reach it
        dd($item);

    }

    $navmenu->addChildren($child_nav);

    $website->navmenus()->save($child_nav);

    return $child_nav;

  }

  /**
   *  FIX fixes a bug on droppable + sortable
   *  the id of the newly dropped item doesn't show up
   *  but it's being set to null instead
   *
   *  recursively looping through the hierarchy lets us replace that item
   *  with the correct one.
   *  returns at first match
   */
  private function knotit(array $hierarchy, $item_id)
  {

    foreach ($hierarchy as $level => $content) {

      if (is_null($content)) {

        $hierarchy[$level] = ["id" => $item_id];

        return $hierarchy;

      } else if (in_array('children', array_keys($content))) {

        $hierarchy[$level]['children'] = $this->knotit($hierarchy[$level]['children'], $item_id);

      }

    }

    return $hierarchy;
  }

}