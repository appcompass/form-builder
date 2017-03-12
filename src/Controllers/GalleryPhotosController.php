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
        $this->repo->setParent($parent);

        Gate::authorize('store', $this->repo);

        $request->user = Auth::user();

        $parent->touch();

        return parent::store($request, $parent);

        throw new \Exception('Not logged, or whatever we should do here.');
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
        // @TODO swap that out once sorting is differentiated between absrtact/abstractChild
        $this->repo->setModel($gallery);

        // Gate::authorize('store', $this->repo);

        // @TODO take a look at how generic reordering is
        //  -- not THAT many cases for this kind of reordering yet: the other one -menu- sorts in place and the pushes the whole thing. for photos we are properly using parent/child relations, thus we push every time we sort. where else is this gonna happen?
        $this->repo->reorder($request->order, 'order');

    }

}
