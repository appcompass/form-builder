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