<?php

namespace P3in\Modules;

use Modular;
use P3in\Models\Navmenu;
use P3in\Models\Website;
use P3in\Modules\BaseModule;
use P3in\Traits\NavigatableTrait as Navigatable;

Class PagesModule extends BaseModule
{

    use Navigatable;

    public $module_name = "pages";

    public function __construct()
    {

    }

    public function bootstrap()
    {
        // echo "Bootstrapping PagesModule!";
    }

    public function register()
    {

        if (Modular::isLoaded('navigation')) {
            $main_nav = Navmenu::byName('cp-main-nav');
            $main_nav_sub_nav =  Navmenu::byName('cp-main-nav-pages', 'Pages Manager');

            $main_nav_sub_nav->addItem($this->navItem);
            $main_nav->addChildren($main_nav_sub_nav);
        }

    }

    public function makeLink()
    {
        $cp_website = Website::first();

        return [
            "label" => "{$cp_website->site_name} Pages",
            "url" => "",
            "new_tab" => "false",
            "req_perms" => null,
            "props" => [
                "icon" => "pencil",
                "link" => [
                    "data-click" => "/cp/websites/{$cp_website->id}/pages",
                    "data-target" => "#main-content",
                    "href" => "javascript:;",
                ]
            ]
      ];
    }

}