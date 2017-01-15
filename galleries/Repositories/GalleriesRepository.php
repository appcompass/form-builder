<?php

namespace P3in\Repositories;

use P3in\Models\Gallery;
use P3in\Model\User;
use P3in\Interfaces\GalleriesRepositoryInterface;

class GalleriesRepository extends AbstractRepository implements GalleriesRepositoryInterface
{
    protected $with = ['user', 'photos', 'videos']; // we add photos and videos here because as of current logic,
                                                    // every model fetches the photos and videos, so better to
                                                    // do it in query builder than loop per record...

    public function __construct(Gallery $model)
    {
        $this->model = $model;

        // @TODO not sure about this, we need a way to make sure the model is injected what it needs for create
        $this->requires = User::class;
    }

    public function create($attributes)
    {
        $user = \Auth::loginUsingId(2);

        $attributes['user_id'] = $user->id;

        return parent::create($attributes);
    }
}
