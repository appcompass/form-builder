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
                    'Label',
                    'Description',
                    'Created',
                    'Updated',
                    'Actions',
                ],
                'rows' => [
                    'label' => [
                        'type' => 'link_by_id',
                        'target' => '#main-content-out',
                        'append' => '/edit'
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
        'edit' => [
            'data_targets' => [
                [
                    'route' => 'permissions.show',
                    'target' => '#main-content-out',
                ], [
                    'route' => 'permissions.edit',
                    'target' => '#record-detail',
                ]
            ],
        ],
        'create' => [
            'data_targets' => [
                [
                    'route' => 'permissions.show',
                    'target' => '#main-content-out',
                ]
            ],
            'heading' => "Create a new Permission",
            'route' => 'permissions.store'
        ],
        'form' => [
            'fields' => [
                [
                    'label' => 'Label',
                    'name' => 'label',
                    'placeholder' => 'Permission label',
                    'type' => 'text',
                    'help_block' => 'The new permission will be identified by the name you set here.',
                ],[
                    'label' => 'Type',
                    'name' => 'type',
                    'placeholder' => 'Permission type',
                    'type' => 'slugify',
                    'field' => 'label',
                    'help_block' => 'Internal permission representation.',
                ],[
                    'label' => 'Description',
                    'name' => 'description',
                    'placeholder' => 'Permission description',
                    'type' => 'text',
                    'help_block' => 'Brief description of what the group represents.'
                ]
            ]
        ]
    ];

    public function __construct()
    {
        $this->middleware('auth');

        $this->controller_class = __CLASS__;
        $this->nav_name = 'cp_permissions_subnav';

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

    public function create()
    {
        return $this->build('create', ['permissions']);
    }

    public function store(Request $request)
    {
        $this->validate($request, Permission::$rules);

        $permission = Permission::create($request->all());

        $this->record = $permission;

        return $this->json($this->setBaseUrl(['permissions']));
    }

    public function edit(Permission $permissions)
    {
        $this->record = $permissions;

        return $this->build('edit', ['permissions', $permissions->id, 'edit']);
    }
}
