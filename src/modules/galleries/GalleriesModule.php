<?php

namespace P3in\Modules;

use File;
use Illuminate\Contracts\Auth\Access\Gate;
use Illuminate\Filesystem\Filesystem;
use Modular;
use P3in\Models\Navmenu;
use P3in\Models\User;
use P3in\Module;
use P3in\Modules\BaseModule;
use P3in\Traits\NavigatableTrait as Navigatable;
use Storage;

Class GalleriesModule extends BaseModule
{

    use Navigatable;

    public $module_name = "galleries";

    public function __construct()
    {

        // $this->gate = $gate;

    }

    /**
     * Runs every time
     */
    public function bootstrap()
    {
        // $this->loadPolicies();
    }

    /**
     * Runs on module load
     */
    public function register()
    {
        $this->checkRackspaceCdnPathConfig();

        $this->checkOrSetUiConfig();

        if (Modular::isLoaded('navigation')) {
            $main_nav = Navmenu::byName('cp_main_nav');
            $main_nav_media =  Navmenu::byName('cp_main_nav_media', 'Media Manager');

            $main_nav_media->addItem($this->navItem, 0);
            $main_nav->addChildren($main_nav_media, 5);
        }

    }

    /**
     * Get Link data
     */
    public function makeLink($overrides = [])
    {

        return array_replace([
            "label" => 'Galleries',
            "url" => '',
            "req_perms" => null,
            "props" => [
                'icon' => 'camera',
                "link" => [
                    'href' => '/galleries',
                    'data-target' => '#main-content-out'
                ],
            ]
        ], $overrides);
    }

    /**
     *  Check Rackspace CDN path
     *
     *  Runs only if setting is not present in config file
     *
     */
    public function checkRackspaceCdnPathConfig()
    {

        if (!config('galleries.photos_cdn_path')) {

                $config = $this->importConfig(__DIR__);

          $container = Storage::disk('rackspace')
            ->getDriver()
            ->getAdapter()
            ->getContainer();

          $cdnContainer = $container->getCdn();

          $uri = $cdnContainer->getCdnSslUri();

          $config['photos_cdn_path'] = $uri;

          File::put(__DIR__.'/config.php', '<?php return ' . var_export($config, true) . ';');

        }

    }

    public function checkOrSetUiConfig()
    {

        $module = Modular::get($this->module_name);

        $module->config = [];
        $module->save();
    }

    /**
     *  Register policies
     *
     *
     */
    private function loadPolicies()
    {

        $this->gate->define('create-galleries', function(User $user) {

            return $user->hasPermission('create-galleries');

        });
    }
  }
