<?php

namespace P3in\Modules\Providers;

use Illuminate\Contracts\Auth\Access\Gate as GateContract;
use Illuminate\Support\ServiceProvider;

class PermissionsServiceProvider extends ServiceProvider
{


  /**
   * Indicates if loading of the provider is deferred.
   *
   * @var bool
   */
  protected $defer = true;

  /**
   *   Register bindings in the container
   *
   *
   *
   */
  public function register()
  {

    // if (Modular::isLoaded('permissions')) {
    //     $main_nav = Navmenu::byName('cp_main_nav');
    //     $main_nav_permissions =  Navmenu::byName('cp_main_nav_permissions', 'GroupsPermissions Manager');

    //     $main_nav_media->addItem($this->navItem, 0);
    //     $main_nav->addChildren($main_nav_media, 5);
    // }

}

  /**
   * Bootstrap services
   *
   *
   *
   */
  public function boot(GateContract $gate)
  {

  }
}