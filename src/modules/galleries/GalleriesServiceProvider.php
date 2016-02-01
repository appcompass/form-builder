<?php

namespace P3in\Modules\Providers;

use P3in\Models\Gallery;
use P3in\Policies\GalleriesPolicy;
use Illuminate\Contracts\Auth\Access\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider;
use Illuminate\Support\ServiceProvider;

class GalleriesServiceProvider extends ServiceProvider
{


  /**
   * Indicates if loading of the provider is deferred.
   *
   * @var bool
   */
  protected $defer = true;

  /**`
   *
   *
   */
  protected $policies = [

    Gallery::class => GalleriesPolicy::class
    // "P3in\Models\Gallery" => "P3in\Policies\GalleriesPolicy"

  ];

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
  public function boot(Gate $gate)
  {

    $this->registerPolicies($gate);

  }

  /**
   * Register the application's policies.
   *
   * @param  \Illuminate\Contracts\Auth\Access\Gate  $gate
   * @return void
   */
  public function registerPolicies(Gate $gate)
  {
    foreach ($this->policies as $key => $value) {
      $gate->policy($key, $value);
    }
  }
}