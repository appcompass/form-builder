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
            ],
            'heading' => 'Group Permissions'
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

        return view('permissions::assign', compact('permissions', 'groups'))
            ->with('owner', $groups)
            ->with('owned', $groups->permissions)
            ->with('avail', $permissions)
            ->with('meta', $this->meta);
    }

    public function store(Request $request, Group $groups)
    {
        $groups->revokeAll();

        foreach($request->owned as $permission) {

            $groups->grantPermissions($permission['type']);

        }

        return \Response::json(['/groups/'.$groups->id.'/permissions']);
    }

}