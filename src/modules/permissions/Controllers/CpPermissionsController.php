<?php

namespace P3in\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use Illuminate\Http\Request;
use P3in\Controllers\UiBaseController;
use P3in\Models\Permission;

class CpPermissionsController extends UiBaseController
{

    public $meta_install = [
        'classname' => Permission::class,
        'index' => [
            'data_targets' => [
                [
                    'route' => 'permissions.index',
                    'target' => '#main-content-out'
                ]
            ],
            'heading' => 'Website\'s permissions',
            'table' => [
                'headers' => [
                    'Type',
                    'Description',
                    'Created',
                    'Updated',
                    'Actions',
                ],
                'rows' => [
                    'type' => [
                        'type' => 'text',
                    ],
                    'label' => [
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
                        'data' => ['edit', 'delete']
                    ],
                ],
            ],
        ],
        'show' => [
            'data_targets' => [
                [
                    'route' => 'permissions.show',
                    'target' => '#main-content-out',
                ]
            ],
            'heading' => 'Permissions Informations',
            'sub_section_name' => 'Permissions Administration',
        ],
    ];

    public function __construct()
    {
        $this->middleware('auth');

        $this->controller_class = __CLASS__;
        $this->module_name = 'permissions';

        $this->setControllerDefaults();

    }

    public function index()
    {
        $this->records = Permission::all();

        return $this->build('index', ['permissions']);
    }

    public function show(Permission $permissions)
    {
        $this->record = $permissions;

        return $this->build('show', ['permissions', $permissions->id]);
    }
}
