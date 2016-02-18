<?php

namespace P3in\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use Illuminate\Http\Request;
use P3in\Controllers\UiBaseController;
use P3in\Models\Group;

class CpGroupsController extends UiBaseController
{

    public $meta_install = [
        'classname' => Group::class,
        'index' => [
            'data_targets' => [
                [
                    'route' => 'groups.index',
                    'target' => '#main-content-out'
                ]
            ],
            'heading' => 'Groups Manager',
            'table' => [
                // 'sortables' => ['Name', 'Email', 'Created', 'Updated'],
                'headers' => [
                    'Name',
                    'Description',
                    'Created',
                    'Updated',
                    'Actions'
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
                    ]
                ],
            ],
        ],
        'show' => [
            'data_targets' => [
                [
                    'route' => 'groups.show',
                    'target' => '#main-content-out',
                ]
            ],
            'heading' => 'Groups Informations',
            'sub_section_name' => 'Groups Administration',
        ],
        'edit' => [
            'data_targets' => [
                [
                    'route' => 'groups.show',
                    'target' => '#main-content-out',
                ],[
                    'route' => 'groups.edit',
                    'target' => '#record-detail',
                ],
            ],
            'heading' => 'Group Informations',
            'sub_section_name' => 'Group Details'
        ],
        'create' => [
            'data_targets' => [
                [
                    'route' => 'groups.create',
                    'target' => '#main-content-out',
                ],
            ],
            'heading' => 'Add a new Group',
            'description_title' => 'Group Creation Form',
            'description_text' => '',
            'route' => 'groups.store'
        ],
        'form' => [
            'fields' => [
                [
                    'label' => 'Label',
                    'name' => 'label',
                    'placeholder' => 'Name of the group',
                    'type' => 'text',
                    'help_block' => 'The new group will be identified by the name you set here.',
                ],[
                    'label' => 'Internal Name',
                    'name' => 'name',
                    'placeholder' => 'The internal name of the group',
                    'type' => 'slugify',
                    'field' => 'label',
                    'help_block' => 'The internal name of the group. If unsure leave it as is.',
                ],[
                    'label' => 'Description',
                    'name' => 'description',
                    'placeholder' => 'Group Description',
                    'type' => 'text',
                    'help_block' => 'Brief description of what the group represents.'
                ],[
                    'label' => 'Quick Permissions',
                    'name' => 'permissions',
                    'placeholder' => 'Group Permissions',
                    'type' => 'multi_select',
                    'help_block' => 'Quick permissions assignment. For more details please refer to the Groups/Permissions section.'
                ]
            ]
        ]
    ];

    public function __construct()
    {
        $this->middleware('auth');

        $this->controller_class = __CLASS__;
        $this->module_name = 'groups';

        $this->setControllerDefaults();

    }

    public function index()
    {
        $this->records = Group::all();

        return $this->build('index', ['groups']);
    }

    public function show(Group $groups)
    {
        $this->record = $groups;

        return $this->build('show', ['groups', $groups->id]);
    }

    public function create()
    {
        return $this->build('create', ['groups']);
    }

    public function edit(Group $groups)
    {
        $this->record = $groups;

        $this->record->permissions = $groups->permissions->lists('type')->toArray();

        return $this->build('edit', ['groups', $groups->id]);
    }

    public function store(Request $request)
    {
        $this->validate($request, Group::$rules);

        $group = Group::create($request->all());

        $group->grantPermissions($request->permissions);

        $this->record = $group;

        return $this->json($this->setBaseUrl(['groups', $this->record->id]));
    }

    public function update(Request $request, Group $groups)
    {
        $groups->update($request->all());

        $groups->revokeAll();

        if ($request->permissions) {

            $groups->grantPermissions($request->permissions);

        }

        $this->record = $groups;

        return $this->json($this->setBaseUrl(['groups', $this->record->id, 'edit']));
    }

    public function destroy(Group $groups)
    {
        $groups->revokeAll();

        $groups->delete();

        return $this->json($this->setBaseUrl(['groups']));
    }
}
