<?php

namespace P3in\Modules;

use Blade;
use Illuminate\Support\Facades\Cache;
use Modular;
use P3in\Models\Navmenu;
use P3in\Models\Permission;
use P3in\Models\Website;
use P3in\Modules\BaseModule;
use P3in\Traits\NavigatableTrait;

Class UiModule extends BaseModule
{

    use NavigatableTrait;

    public $module_name = 'ui';

    public function __construct()
    {

    }

    public function bootstrap()
    {
        Cache::tags('cp_ui')->rememberForever('nav', function(){
            return $this->buildCpNav();
        });
    }

    public function register()
    {

    }

    /**
     *
     */
    public function makeLink()
    {
        return [
            [
                'label' => 'Dashboard',
                'belongs_to' => ['cp_main_nav'],
                'sub_nav' => '',
                'req_perms' => Permission::createCpRoutePerm('dashboard'),
                'order' => 1,
                'props' => [
                    'icon' => 'dashboard',
                    'link' => [
                        'href' => '/dashboard',
                    ],
                ],
            ],
        ];
    }

    public function buildCpNav()
    {
        $rawLinks = array_collapse(array_values(Modular::makeLink()));

        $organized = $this->organizeNavItemsByNavName($rawLinks);

        return json_decode(json_encode($organized));
    }

    private function organizeNavItemsByNavName($nav)
    {
        $rtn = [];

        foreach ($nav as $row) {

            if (!empty($row['sub_nav'])) {
                $row['children'] = $this->buildChildNavs($row['sub_nav'], $nav);
            }

            foreach ($row['belongs_to'] as $belongs_to) {
                $rtn[$belongs_to][] = $row;
            }
        }

        array_walk($rtn, function(&$row, $key){
            $row = array_values(array_sort($row, function ($val) {
                return $val['order'];
            }));
        });

        return $rtn;
    }

    private function buildChildNavs($name, $nav)
    {
        $rtn = [];

        foreach ($nav as $row) {
            if (in_array($name,$row['belongs_to'])) {

                if (!empty($row['sub_nav'])) {
                    $row['children'] = $this->buildChildNavs($row['sub_nav'], $nav);
                }

                $rtn[] = $row;
            }
        }

        return array_values(array_sort($rtn, function ($val) {
            return $val['order'];
        }));
    }
}
