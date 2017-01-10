<?php

namespace P3in\Repositories;

use P3in\Interfaces\GalleryPhotosRepositoryInterface;
use P3in\Models\Gallery;
use P3in\Models\Photo;

class GalleryPhotosRepository extends AbstractChildRepository implements GalleryPhotosRepositoryInterface
{

    // protected $with = ['user'];

    public function __construct(Photo $model, Gallery $parent)
    {
        $this->model = $model;

        $this->parent = $parent;

        $this->relationName = 'photos';

        // relation from parent to child
        // $this->parentToChild = 'pages';
    }

}
