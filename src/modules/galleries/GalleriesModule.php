<?php

namespace P3in\Modules;

use File;
use Illuminate\Contracts\Auth\Access\Gate;
use Illuminate\Filesystem\Filesystem;
use Modular;
use P3in\Models\Navmenu;
use P3in\Models\Permission;
use P3in\Models\User;
use P3in\Models\Website;
use P3in\Module;
use P3in\Modules\BaseModule;
use P3in\Traits\NavigatableTrait as Navigatable;
use Storage;

Class GalleriesModule extends BaseModule
{

    use Navigatable;

    public $module_name = 'galleries';

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

    }

    /**
     * Get Link data
     */
    public function makeLink()
    {

        return [
            [
                'label' => 'Media Manager',
                'belongs_to' => ['cp_main_nav'],
                'sub_nav' => 'cp_main_nav_media',
                'req_perms' => null,
                'order' => 4,
                'props' => [
                    'icon' => 'camera',
                ],
            ], [
                'label' => 'Galleries',
                'belongs_to' => ['cp_main_nav_media'],
                'sub_nav' => '',
                'req_perms' => Permission::createCpRoutePerm('galleries.index'),
                'order' => 1,
                'props' => [
                    'icon' => 'table',
                    'link' => [
                        'href' => '/galleries',
                    ],
                ],
            ], [
                'label' => 'Gallery Info',
                'belongs_to' => ['galleries'],
                'sub_nav' => '',
                'req_perms' => Permission::createCpRoutePerm('galleries.edit'),
                'order' => 1,
                'props' => [
                    'icon' => 'info-circle',
                    'link' => [
                        'href' => '/edit',
                    ],
                ],
            ],
        ];
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
