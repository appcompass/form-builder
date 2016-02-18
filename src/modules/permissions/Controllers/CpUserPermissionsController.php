<?php

namespace P3in\Controllers;

use P3in\Controllers\UiBaseController;
use P3in\Models\User;

class CpUserGroupsController extends UiBaseController
{

    public $meta_install = [

        'classname' => User::class,
        'index' => [
            'data_targets' => [
                [
                    'route' => 'users.index',
                    'target' => '#record-detail'
                ],[
                    'route' => 'users.groups',
                    'target' => '#record-detail'
                ]
            ]
        ],
        'show' => [
            'data_targets' => [
                [
                    'route' => 'users.show',
                    'target' => '#main-content-out'
                ],[
                    'route' => 'users.groups',
                    'target' => '#record-detail'
                ]
            ],
            'heading' => 'User Groups',
            'sub_section_name' => 'Manage User\'s Groups'
        ]

    ];


}