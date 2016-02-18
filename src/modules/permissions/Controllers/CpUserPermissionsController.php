<?php

namespace P3in\Controllers;

use Illuminate\Http\Request;
use P3in\Controllers\UiBaseController;
use P3in\Models\Permission;
use P3in\Models\User;

class CpUserPermissionsController extends UiBaseController
{

    public $meta_install = [

        'classname' => Permission::class,
        'index' => [
            'data_targets' => [
                [
                    'route' => 'users.show',
                    'target' => '#main-content-out'
                ],[
                    'route' => 'users.permissions.index',
                    'target' => '#record-detail'
                ]
            ],
            'heading' => 'User Groups',
        ],
        'show' => [
            'data_targets' => [
                [
                    'route' => 'users.show',
                    'target' => '#main-content-out'
                ],[
                    'route' => 'users.permissions',
                    'target' => '#record-detail'
                ]
            ],
            'heading' => 'User Permissions',
            'sub_section_name' => 'Manage User\'s Permissions'
        ],
        'edit' => [
            'heading' => 'User Permissions'
        ]

    ];


    public function __construct()
    {
        $this->middleware('auth');

        $this->controller_class = __CLASS__;
        $this->module_name = 'permissions';

        $this->setControllerDefaults();

    }

    public function index(User $users)
    {
        $this->meta->base_url = '/users/' . $users->id . '/permissions/';

        return view('permissions::assign', compact('users', 'available_perms'))
            ->with('owner', $users)
            ->with('owned', $users->permissions)
            ->with('avail', Permission::all())
            ->with('meta', $this->meta);
    }

    public function store(Request $request, User $users)
    {
        $users->permissions()->detach();

        foreach ($request->owned as $perm) {

            $users->grantPermission(Permission::findOrFail($perm['id']));

        }

        return \Response::json(['/users/'.$users->id.'/permissions']);
    }
}