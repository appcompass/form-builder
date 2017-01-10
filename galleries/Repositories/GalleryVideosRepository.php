<?php

namespace P3in\Repositories;

use P3in\Interfaces\GalleryVideosRepositoryInterface;
use P3in\Models\Gallery;
use P3in\Models\Video;

class GalleryVideosRepository extends AbstractChildRepository implements GalleryVideosRepositoryInterface
{

    // protected $with = ['user'];

    public function __construct(Video $model, Gallery $parent)
    {
        $this->model = $model;

        $this->parent = $parent;

        $this->relationName = 'videos';

        // relation from parent to child
        // $this->parentToChild = 'pages';
    }

}
