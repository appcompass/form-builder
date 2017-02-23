<?php

namespace P3in\Controllers;

use P3in\Interfaces\GalleryPhotosRepositoryInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Auth;

class GalleryPhotosController extends AbstractChildController
{
    public function __construct(GalleryPhotosRepositoryInterface $repo)
    {
        $this->repo = $repo;
    }

    public function store(Request $request, Model $parent)
    {
        if (Auth::check()) {

            $request->user = Auth::user();

            $result = parent::store($request, $parent);

            return ['id' => $parent->id, 'model' => 'galleries'];
        }

        throw new \Exception('Not logged, or whatever we should do here.');
    }


}
