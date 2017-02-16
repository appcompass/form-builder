<?php

namespace P3in\Controllers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use P3in\Interfaces\PageContentRepositoryInterface;
// use P3in\Models\Page;
// use P3in\Models\PageSectionContent;

class PageContentController extends AbstractChildController
{

    public function __construct(PageContentRepositoryInterface $repo)
    {
        $this->repo = $repo;
    }

    public function index(Request $request, Model $parent)
    {
        return [
            'data' => $parent->buildContentTree(true),
            'view' => $this->repo->view
        ];
    }

    public function update(Request $request, Model $parent, Model $model)
    {
        if ($model->source) {
            foreach ($model->section->form->fields as $field) {
                if ($field->type !== 'Dynamic') {
                    continue;
                }

                $field_source = $model->source->update($request->{$field->name});

                unset($request->{$field->name});
            }
        }

        if ($model->update(['content' => $request->all()])) {
            return ['success' => true];
        }
    }

    /**
     * show
     *
     * @param      <type>  $parent  The parent
     * @param      <type>  $model   The model
     *
     * @return     array   ( description_of_the_return_value )
     */
    public function show(Request $request, Model $parent, Model $model)
    {
        return $model->edit();
    }
}
