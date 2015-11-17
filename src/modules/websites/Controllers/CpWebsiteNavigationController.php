<?php

namespace P3in\Controllers;

use Illuminate\Http\Request;
use P3in\Controllers\UiBaseController;
use P3in\Models\Website;

class CpWebsiteNavigationController extends UiBaseController
{


  public function __construct()
  {
    $this->middleware('auth');

    $this->setControllerDefaults(__DIR__);
  }

  /**
   *
   */
  public function index($website_id)
  {

    $website = Website::findOrFail($website_id)->load('navmenus', 'pages');

    $navmenus = $website->navmenus;

    $pages = $website->pages;

    return view('navigation::index')
      ->with('navmenus', $navmenus)
      ->with('pages', $pages);
  }

  /**
   *
   */
  public function store(Request $request, $website_id)
  {

  }

}