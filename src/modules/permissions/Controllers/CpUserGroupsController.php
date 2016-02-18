<?php

namespace P3in\Controllers;

use Illuminate\Http\Request;
use P3in\Controllers\UiBaseController;
use P3in\Models\Group;
use P3in\Models\Permission;
use P3in\Models\User;

class CpUserGroupsController extends UiBaseController
{

    public $meta_install = [

        'classname' => User::class,
        'index' => [
            'data_targets' => [
                [
                    'route' => 'users.show',
                    'target' => '#main-content-out'
                ],[
                    'route' => 'users.groups.index',
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
                    'route' => 'users.groups',
                    'target' => '#record-detail'
                ]
            ],
            'heading' => 'User Groups',
            'sub_section_name' => 'Manage User\'s Groups'
        ]

    ];


    public function __construct()
    {
        $this->middleware('auth');

        $this->controller_class = __CLASS__;
        $this->module_name = 'groups';

        $this->setControllerDefaults();

    }

    public function index(User $users)
    {
        $users->load('groups');

        $available_groups = Group::all();

        $this->meta->base_url = '/users/' . $users->id . '/groups/';

        return view('permissions::user.groups.index', compact('users', 'available_groups'))
            ->with('meta', $this->meta);
    }

    public function store(Request $request, User $users)
    {
        $users->groups()->detach();

        foreach ($request->groups as $group) {

            $users->addToGroup(Group::findOrFail($group['id']));

        }

        return \Response::json(['/users/'.$users->id.'/groups']);
    }

}