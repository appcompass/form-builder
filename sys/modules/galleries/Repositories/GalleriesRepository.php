<?php

namespace P3in\Repositories;

use P3in\Models\Gallery;
use P3in\Model\User;
use P3in\Interfaces\GalleriesRepositoryInterface;

class GalleriesRepository extends AbstractRepository implements GalleriesRepositoryInterface
{
    protected $with = ['user', 'photos', 'videos'];

    public function __construct(Gallery $model)
    {
        $this->model = $model;

        // @TODO not sure about this, we need a way to make sure the model is injected what it needs for create
        //      how about we post into User/Gallery? -f
        //      that or -in this specific instance- we know we want the logged in user, so this repository should be in charge of that -f
        $this->requires = User::class;
    }

    public function create($attributes)
    {
        // $user = \Auth::loginUsingId(2);

        if (!Auth::user()) {

            die('User not logged in');

        }

        $attributes['user_id'] = $user->id;

        return parent::create($attributes);
    }
}
