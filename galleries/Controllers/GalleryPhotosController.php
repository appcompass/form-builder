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

            return parent::store($request, $parent);

        }

        throw new \Exception('Not logged, or whatever we should do here.');
    }


}
