<?php

namespace P3in\Seeders;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use P3in\Models\Section;
use Modular;

class MenusModuleDatabaseSeeder extends Seeder {

	public function run()
	{

	}
    /**
     *
     */
    public function makeLink()
    {
        return [
            [
                'label' => 'Menus',
                'belongs_to' => ['websites'],
                'sub_nav' => '',
                'req_perms' => Permission::createCpRoutePerm('websites.navigation.index'),
                'order' => 5,
                'props' => [
                    'icon' => 'bars',
                    'link' => [
                        'href' => '/navigation',
                    ],
                ],
            ]
        ];
    }
}