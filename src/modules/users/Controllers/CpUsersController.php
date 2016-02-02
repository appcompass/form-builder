<?php

namespace P3in\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use Illuminate\Http\Request;
use P3in\Controllers\UiBaseController;
use P3in\Models\User;

class CpUsersController extends UiBaseController
{

    public $meta_install = [
        'index' => [
            'data_targets' => [
                [
                    'route' => 'users.index',
                    'target' => '#main-content-out',
                // ],[
                //     'route' => 'users.show',
                //     'target' => '#record-detail',
                ],
            ],
            'heading' => 'Manage Users',
            'table' => [
                'sortables' => ['Name', 'Email', 'Created', 'Updated'],
                'headers' => [
                    'Name',
                    'Email',
                    'Created',
                    'Updated',
                ],
                'rows' => [
                    'full_name' => [
                        'type' => 'link_by_id',
                        'target' => '#main-content-out',
                    ],
                    'email' => [
                        'type' => 'email',
                    ],
                    'created_at' => [
                        'type' => 'datetime',
                    ],
                    'updated_at' => [
                        'type' => 'datetime',
                    ],
                ],
            ],
        ],
        'show' => [
            'data_targets' => [
                [
                    'route' => 'users.show',
                    'target' => '#main-content-out',
                ],[
                    'route' => 'users.edit',
                    'target' => '#record-detail',
                ],
            ],
            'heading' => 'User Information',
            'sub_section_name' => 'User Information',
        ],
        'edit' => [
            'data_targets' => [
                [
                    'route' => 'users.show',
                    'target' => '#main-content-out',
                ],[
                    'route' => 'users.edit',
                    'target' => '#record-detail',
                ],
            ],
            'heading' => 'User Information',
            'route' => 'users.update'
        ],
        'create' => [
            'data_targets' => [
                [
                    'route' => 'users.show',
                    'target' => '#main-content-out',
                ],[
                    'route' => 'users.create',
                    'target' => '#record-detail',
                ],
            ],
            'heading' => 'Create a User',
            'route' => 'users.store'
        ],
        'form' => [
            'fields' => [
                [
                    'label' => 'First Name',
                    'name' => 'first_name',
                    'placeholder' => 'First Name',
                    'type' => 'text',
                    'help_block' => '',
                ],[
                    'label' => 'Last Name',
                    'name' => 'last_name',
                    'placeholder' => 'Last Name',
                    'type' => 'text',
                    'help_block' => '',
                ],[
                    'label' => 'Phone Number',
                    'name' => 'phone',
                    'placeholder' => '123-456-7890',
                    'type' => 'text',
                    'help_block' => '',
                ],[
                    'label' => 'Email',
                    'name' => 'email',
                    'placeholder' => 'john.doe@p3in.com',
                    'type' => 'text',
                    'help_block' => '',
                ],[
                    'label' => 'Password',
                    'name' => 'password',
                    'placeholder' => '',
                    'type' => 'password',
                    'help_block' => '',
                ],
            ],
        ],
    ];

    public function __construct()
    {
        $this->middleware('auth');

        $this->controller_class = __CLASS__;
        $this->module_name = 'users';

        $this->setControllerDefaults();
    }

    /**
     *
     *
     */
    public function index()
    {
        $this->records = User::all();

        return $this->build('index', ['users']);
    }

    /**
     *
     *
     */
    public function create()
    {
        return $this->build('create', ['users']);
    }

    /**
     *
     *
     */
    public function store(Request $request)
    {
        $this->validate($request, User::$validator_rules);

        $data = $request->all();

        $this->record = User::create($data);

        return $this->json($this->setBaseUrl(['users', $this->record->id, 'edit']));

    }

    /**
     *
     *
     */
    public function show($id)
    {
        $this->record = User::findOrFail($id);

        return $this->build('show', ['users', $id]);
    }

    /**
     *
     *
     */
    public function edit($id)
    {
        $this->record = User::findOrFail($id);

        return $this->build('edit', ['users', $id]);
    }

    /**
     *
     *
     */
    public function update(Request $request, $id)
    {
        $this->record = User::findOrFail($id);

        $this->record->update($request->all());

        return $this->json($this->setBaseUrl(['users', $id, 'edit']));
    }

}


