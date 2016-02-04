<?php

namespace P3in\Controllers;

use P3in\Models\Gallery;
use Illuminate\Http\Request;
use P3in\Controllers\UiBaseController;

class CpGalleriesController extends UiBaseController
{

    public $meta_install = [
        'index' => [
            'data_targets' => [
                [
                    'route' => 'galleries.index',
                    'target' => '#main-content-out',
                // ],[
                //     'route' => 'galleries.show',
                //     'target' => '#record-detail',
                ],
            ],
            'heading' => 'Manage Galleries',
            'table' => [
                'sortables' => ['Name', 'Created', 'Updated'],
                'headers' => [
                    'Name',
                    'Description',
                    'Created',
                    'Updated',
                ],
                'rows' => [
                    'name' => [
                        'type' => 'link_by_id',
                        'target' => '#main-content-out',
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
                ],
            ],
        ],
        'show' => [
            'data_targets' => [
                [
                    'route' => 'galleries.show',
                    'target' => '#main-content-out',
                // ],[
                //     'route' => 'galleries.pages.show',
                //     'target' => '#record-detail',
                ],
            ],
            'heading' => 'Gallery Informations',
            'sub_section_name' => 'Gallery Administration',
        ],
        'edit' => [
            'data_targets' => [
                [
                    'route' => 'galleries.show',
                    'target' => '#main-content-out',
                ],[
                    'route' => 'galleries.edit',
                    'target' => '#record-detail',
                ],
            ],
            'heading' => 'Gallery Information',
            'route' => 'galleries.update'
        ],
        'create' => [
            'data_targets' => [
                [
                    'route' => 'galleries.create',
                    'target' => '#main-content-out',
                ],
            ],
            'heading' => 'Add a page to this website',
            'route' => 'galleries.store'
        ],
        'form' => [
            'fields' => [
                [
                    'label' => 'Name',
                    'name' => 'name',
                    'placeholder' => 'Gallery Name',
                    'type' => 'text',
                    'help_block' => '',
                ],[
                    'label' => 'Description',
                    'name' => 'description',
                    'placeholder' => 'Some random description of this gallery.',
                    'type' => 'textarea',
                    'help_block' => '',
                ],
            ],
        ],
    ];

    public function __construct()
    {
        $this->middleware('auth');

        $this->controller_class = __CLASS__;
        $this->module_name = 'galleries';

        $this->setControllerDefaults();
    }

    /**
     *
     *
     */
    public function index()
    {
        // $this->authorize('index', Gallery::class);

        $this->records = Gallery::all();

        return $this->build('index', ['galleries']);

    }

    /**
     *
     *
     */
    public function create()
    {
        return $this->build('create', ['galleries']);
    }

    /**
     *
     *
     */
    public function store(Request $request)
    {

        $gallery = new Gallery($request->all());

        $this->record = $this->user->galleries()->save($gallery);

        return $this->json($this->setBaseUrl(['galleries', $this->record->id, 'photos']));

    }

    /**
     *
     *
     */
    public function show($id)
    {
        // dd(\Route::current());

        $this->record = Gallery::findOrFail($id);

        return $this->build('show', ['galleries', $id]);
    }

    /**
     *
     *
     */
    public function edit($id)
    {
        // $this->authorize('edit', Gallery::class); // @TODO this works

        $this->record = Gallery::findOrFail($id);

        return $this->build('edit', ['galleries', $id]);
    }

    /**
     *
     *
     */
    public function update(Request $request, $id)
    {
        $this->record = Gallery::findOrFail($id);

        $this->record->update($request->all());

        return $this->build('edit', ['galleries', $id]);
    }
}
