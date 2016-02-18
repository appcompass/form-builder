<?php

namespace P3in\Controllers;

use Illuminate\Http\Request;
use P3in\Controllers\UiBaseController;
use P3in\Models\Group;
use P3in\Models\Permission;

class CpGroupPermissionsController extends UiBaseController
{

    public $meta_install = [
        'classname' => Permission::class,
        'index' => [
            'data_targets' => [
                [
                    'route' => 'groups.show',
                    'target' => '#main-content-out'
                ],
                [
                    'route' => 'groups.permissions.index',
                    'target' => '#record-detail'
                ]
            ],
            'heading' => 'Group\'s Permissions',
            'table' => [
                'headers' => [
                    'Type',
                    'Description',
                    'Created',
                    'Updated',
                    'Actions',
                ],
                'rows' => [

                ]
            ]
        ],
        'edit' => [
            'data_targets' => [
                'route' => 'groups.permissions.edit',
                'target' => '#record-detail'
            ]
        ],
        'show' => [
            'data_targets' => [
                'route' => 'groups.permissions.edit',
                'target' => '#record-detail'
            ]
        ],
        'create' => [
            'data_targets' => [
                'route' => 'groups.permissions.edit',
                'target' => '#record-detail'
            ]
        ]
    ];

    /**
     *
     */
    public function __construct()
    {
        $this->middleware('auth');

        $this->controller_class = __CLASS__;
        $this->module_name = 'groups';

        $this->setControllerDefaults();
    }

    public function index(Group $groups)
    {

        $groups->load('permissions');

        $permissions = Permission::all();

        $this->meta->base_url = "/groups/" . $groups->id . "/permissions/";

        return view('permissions::groups.permissions.index', compact('permissions', 'groups'))
            ->with('meta', $this->meta);
    }

    public function store(Request $request, Group $groups)
    {
        $groups->revokeAll();

        foreach($request->get('permissions') as $permission) {

            $groups->grantPermissions($permission['type']);

        }

        return \Response::json(['/groups/'.$groups->id.'/permissions']);
    }

}