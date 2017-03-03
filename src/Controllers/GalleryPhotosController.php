<?php

namespace P3in\Controllers;

use P3in\Interfaces\GalleryPhotosRepositoryInterface;
use Illuminate\Database\Eloquent\Model;
use P3in\Requests\FormRequest;
use P3in\Models\Gallery;
use Auth;

class GalleryPhotosController extends AbstractChildController
{
    public function __construct(GalleryPhotosRepositoryInterface $repo)
    {
        $this->repo = $repo;
    }

    public function store(FormRequest $request, Model $parent)
    {

        if (Auth::check()) {

            $request->user = Auth::user();

            return parent::store($request, $parent);

        }

        throw new \Exception('Not logged, or whatever we should do here.');
    }

    public function sort(FormRequest $request, Gallery $gallery)
    {
        $this->repo->setModel($gallery);

        $this->repo->reorder($request->order, 'order');

        // info($request->order);

        // $items = Photo::whereIn('id', $request->order)->get();

        // dd($items);

        // for ($i = 0; $i <= count($items); $i++) {

        //     $items[$i]->update(['order' => $i]);

        // }

    }

}
