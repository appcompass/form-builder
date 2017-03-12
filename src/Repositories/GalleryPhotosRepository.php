<?php

namespace P3in\Repositories;

use P3in\Interfaces\GalleryPhotosRepositoryInterface;
use P3in\Requests\FormRequest;
use P3in\Models\Gallery;
use P3in\Models\Photo;
use P3in\Models\User;

class GalleryPhotosRepository extends AbstractChildRepository implements GalleryPhotosRepositoryInterface
{

    protected $with = ['user'];

    // models required in order to persist
    protected $requires = [
        'methods' => [
            'user' => ['from' => 'id', 'to' => 'user_id']
        ],
        'props' => [
        ]
    ];

    public function __construct(Photo $model, Gallery $parent)
    {
        $this->model = $model;

        $this->parent = $parent;

        $this->relationName = 'photos';
    }
}
