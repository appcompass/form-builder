<?php

namespace P3in\Controllers;

use P3in\Interfaces\GalleryPhotosRepositoryInterface;
use Illuminate\Database\Eloquent\Model;
use P3in\Requests\FormRequest;
use P3in\Models\Gallery;
use Auth;
use Gate;

class GalleryPhotosController extends AbstractChildController
{
    public function __construct(GalleryPhotosRepositoryInterface $repo)
    {
        $this->repo = $repo;
    }

    public function store(FormRequest $request, Model $parent)
    {
        // @TODO: have validation check the request->user() instead of $request->user
        // request->user() is always set when a user is authenticated,
        // and this end point requires auth via middleware.
        // So this method should be removed if we can get validation to use the ->user() method instead.
        //  -- we can now requre['methods']['user']
        $this->repo->setParent($parent);

        Gate::authorize('store', $this->repo);

        $parent->touch();

        return parent::store($request, $parent);
    }

    public function destroy(FormRequest $request, Model $parent, Model $model)
    {
        $this->repo->setParent($parent);

        $this->repo->setModel($model);

        Gate::authorize('destroy', $this->repo);

        return parent::destroy($request, $parent, $model);
    }

    public function sort(FormRequest $request, Gallery $gallery)
    {
        $this->repo->setModel($gallery);

        // Gate::authorize('store', $this->repo);
        $this->repo->reorder($request->order, 'order');
    }
}
