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
    ];

    /**
     *
     */
    public function __construct()
    {
        $this->middleware('auth');

        $this->controller_class = __CLASS__;
        $this->module_name = 'websites';

        $this->setControllerDefaults();
    }

  /**
   *
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

  public function update(Request $request, $website_id)
  {

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
   *
   */
  private function parseHierarchy(Navmenu $navmenu, $hierarchy, Website $website)
  {

    foreach($hierarchy as $index => $content) {


      if (!isset($content['id'])) {

        continue;

      }
      var_dump($content);

      $item = NavigationItem::findOrFail($content['id']);

      if ($item->has_content) {

        $child_nav = $this->createSubNav($item, $navmenu, $website);

        if (isset($content['children'])) {

          $this->parseHierarchy($child_nav, $content['children'], $website);

        }

      } else {

        echo "Adding Item: $item->id<br> to $navmenu->name \n";

        $navmenu->addItem($item);

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
        $last_name = $navmenu->getNextSubNav();
        $child_nav = Navmenu::byName($last_name);
        break;

      case 'P3in\Models\Navmenu':
        $child_nav = Navmenu::byName($item->navigatable->name);
        break;

      default:
        dd($item);

    }

    $navmenu->addChildren($child_nav);

    $website->navmenus()->save($child_nav);

    return $child_nav;

  }

  /**
   *
   */
  protected function cleanMenu(Navmenu $navmenu)
  {



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