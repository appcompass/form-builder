<?php

namespace P3in\Controllers;

use Illuminate\Database\Eloquent\Model;
use P3in\Controllers\BaseController;
use P3in\Requests\FormRequest;
use Illuminate\Http\Request;
use P3in\Models\Form;
use Route;

abstract class AbstractController extends BaseController
{

    protected $repo;

    public function index(Request $request)
    {

        return $this->repo->get();
    }

    public function show(FormRequest $request, Model $model)
    {
        return $this->repo->findByPrimaryKey($model->id);
    }

    public function update(FormRequest $request, Model $model)
    {
        $model->update($request->all());

        return response()->json(['message' => 'Model updated.']);
    }

    public function create(Request $request)
    {
        return;
    }

    public function destroy(Model $model)
    {
        if ($model->delete()) {

            return response()->json(['message' => 'Model deleted.']);

        } else {

            throw new \Exception('Cannot delete model.');

        }
    }

    public function store(FormRequest $request)
    {
        $model = $this->repo->create($request);

        if ($model) {

            return response()->json([
                'message' => 'Model Created.',
                'id' => $model['id'],
                // 'model' => $success['model']
                'model' => $model
            ]);

        } else {

            return response()->json([
                'message' => 'Error'
            ], 503);

        }

    }

}
