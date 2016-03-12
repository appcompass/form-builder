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
        ],
        'edit' => [
            'heading' => 'User\'s Groups'
        ]

    ];


    public function __construct()
    {
        $this->middleware('auth');

        $this->controller_class = __CLASS__;
        $this->nav_name = 'cp_groups_subnav';

        $this->setControllerDefaults();

    }

    public function index(User $users)
    {
        $available_groups = Group::all()->load('permissions');

        $users->load('groups.permissions');

        $this->meta->base_url = '/users/' . $users->id . '/groups/';

        return view('permissions::assign', compact('users', 'available_groups'))
            ->with('owner', $users)
            ->with('owned', $users->groups)
            ->with('avail', $available_groups)
            ->with('meta', $this->meta);
    }

    public function store(Request $request, User $users)
    {
        $users->groups()->detach();

        foreach ($request->owned as $group) {

            $users->addToGroup(Group::findOrFail($group['id']));

        }

        return \Response::json(['/users/'.$users->id.'/groups']);
    }

}