<?php

namespace P3in\Controllers;

use Illuminate\Database\Eloquent\Model;
use P3in\Controllers\BaseController;
use App\Http\Controllers\Controller;
use P3in\Requests\FormRequest;

abstract class AbstractChildController extends Controller
{

    protected $repo;

    public function index(FormRequest $request, Model $parent)
    {
        $this->repo->setParent($parent);

        return $this->repo->get();
    }

    public function store(FormRequest $request, Model $parent)
    {
        $this->repo->setParent($parent);

        return $this->repo->create($request);
    }

    public function show(FormRequest $request, Model $parent, Model $model)
    {
        return $this->repo
            ->setParent($parent)
            ->findByPrimaryKey($model->id);
    }

    public function update(FormRequest $request, Model $parent, Model $model)
    {
        $this->repo
            ->setParent($parent)
            ->fromModel($model)
            ->update($request->all());

        return ['message' => 'Model updated.'];
    }

    public function create(FormRequest $request, Model $parent)
    {
        return;
    }

    public function destroy(FormRequest $request, Model $parent, Model $model)
    {
        $success = $this->repo
            ->fromModel($model)
            ->destroy();

        if ($success) {

            return ['message' => 'Model deleted.'];

        }
    }

}