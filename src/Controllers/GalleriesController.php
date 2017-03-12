<?php

namespace P3in\Controllers;

use P3in\Interfaces\GalleriesRepositoryInterface;

use Illuminate\Database\Eloquent\Model;
use P3in\Requests\FormRequest;
use P3in\Models\Gallery;
use P3in\Models\Photo;
use P3in\Models\User;
use Auth;
use Gate;

class GalleriesController extends AbstractController
{
    public function __construct(GalleriesRepositoryInterface $repo)
    {
        $this->repo = $repo;
    }

    public function store(FormRequest $request)
    {

        if (Auth::check()) {

            $request->user = Auth::user();

            return parent::store($request);
        }

        throw new \Exception('Not logged, or whatever we should do here.');
    }

    public function update(FormRequest $request, Model $model)
    {
        $this->repo->setModel($model);

        return parent::update($request, $model);
    }


}
