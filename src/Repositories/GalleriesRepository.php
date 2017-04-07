<?php

namespace P3in\Repositories;

use P3in\Interfaces\GalleriesRepositoryInterface;
use P3in\Models\Gallery;

class GalleriesRepository extends AbstractRepository implements GalleriesRepositoryInterface
{
    const EDIT_OWNED = 1;

    protected $with = ['user', 'videos.user', 'galleryable.storage'];

    // // List view
    // protected $view = 'Card';
    protected $view_types = ['Card', 'Table'];

    protected $requires = [
        'methods' => [
            'user' => ['from' => 'id', 'to' => 'user_id']
        ],
        'props' => []
    ];

    public function __construct(Gallery $model)
    {
        $this->model = $model;
    }
}
