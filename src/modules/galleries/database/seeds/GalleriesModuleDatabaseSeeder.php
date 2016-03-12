<?php

namespace P3in\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Modular;
use P3in\Models\Navmenu;
use P3in\Models\Page;
use P3in\Models\RouteMeta;
use P3in\Models\Website;

class GalleriesModuleDatabaseSeeder extends Seeder
{

    /**
    * Run the database seeds.
    *
    * @return void
    */
    public function run()
    {
        Model::unguard();

        if (Modular::isLoaded('websites') && Modular::isLoaded('navigation') && Modular::isLoaded('pages')) {

            $website = Website::admin();

            $page = Page::firstOrNew([
                'name' => 'cp_gallery_info',
                'title' => 'Gallery Info',
                'description' => 'Gallery Info Details Form',
                'slug' => 'edit',
                'order' => 4,
                'active' => true
            ]);

            $page->published_at = Carbon::now();

            $website->pages()->save($page);

            // @TODO: Federico, you know what to do with this :)
            // $navmenu = Navmenu::byName('cp_galleries_subnav');

            // $website->navmenus()->save($navmenu);

            // $navmenu->addItem($page, 4, [
            //     'url' => '/edit',
            //     'props' => [
            //         'icon' => 'camera',
            //         'link' => [
            //             'href' => '/edit',
            //             'data-target' => '#record-detail'
            //         ]
            //     ]
            // ]);

        }

        if (Modular::isLoaded('ui')) {
            $route = RouteMeta::firstOrNew([
                        'name' => 'galleries.form',
            ]);

            $route->config = [
                'fields' => [
                    [
                        'label' => 'Name',
                        'name' => 'name',
                        'placeholder' => 'Gallery Name',
                        'type' => 'text',
                        'help_block' => '',
                    ],[
                        'label' => 'Description',
                        'name' => 'description',
                        'placeholder' => 'Some random description of this gallery.',
                        'type' => 'textarea',
                        'help_block' => '',
                    ],
                ],
            ];
            $route->save();


            $route = RouteMeta::firstOrNew([
                        'name' => 'galleries.index',
            ]);
            $route->config = [
                'data_targets' => [
                    [
                        'route' => 'galleries.index',
                        'target' => '#main-content-out',
                    ],
                ],
                'heading' => 'Manage Galleries',
                'table' => [
                    'sortables' => ['Name', 'Created', 'Updated'],
                    'headers' => [
                        'Name',
                        'Description',
                        'Created',
                        'Updated',
                        'Actions',
                    ],
                    'rows' => [
                        'name' => [
                            'type' => 'link_by_id',
                            'target' => '#main-content-out',
                        ],
                        'description' => [
                            'type' => 'text',
                        ],
                        'created_at' => [
                            'type' => 'datetime',
                        ],
                        'updated_at' => [
                            'type' => 'datetime',
                        ],
                        'actions' => [
                            'type' => 'action_buttons',
                            'data' => ['edit', 'clone', 'delete']
                        ],
                    ],
                ],
            ];
            $route->save();

            $route = RouteMeta::firstOrNew([
                        'name' => 'galleries.show',
            ]);
            $route->config = [
                'data_targets' => [
                    [
                        'route' => 'galleries.show',
                        'target' => '#main-content-out',
                    ],
                ],
                'heading' => 'Gallery Informations',
                'sub_section_name' => 'Gallery Administration',
            ];
            $route->save();

            $route = RouteMeta::firstOrNew([
                        'name' => 'galleries.edit',
            ]);
            $route->config = [
                'data_targets' => [
                    [
                        'route' => 'galleries.show',
                        'target' => '#main-content-out',
                    ],[
                        'route' => 'galleries.edit',
                        'target' => '#record-detail',
                    ],
                ],
                'heading' => 'Gallery Information',
                'route' => 'galleries.update'
            ];
            $route->save();

            $route = RouteMeta::firstOrNew([
                        'name' => 'galleries.create',
            ]);
            $route->config = [
                'data_targets' => [
                    [
                        'route' => 'galleries.create',
                        'target' => '#main-content-out',
                    ],
                ],
                'heading' => 'Add a page to this website',
                'route' => 'galleries.store'
            ];
            $route->save();
        }

        Model::reguard();
    }
}
