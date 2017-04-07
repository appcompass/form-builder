<?php

namespace P3in\Controllers;

use Illuminate\Database\Eloquent\Model;
use P3in\Requests\FormRequest;
use P3in\Interfaces\PageContentRepositoryInterface;
// use P3in\Models\Page;
// use P3in\Models\PageSectionContent;

class PageContentController extends AbstractChildController
{

    public function __construct(PageContentRepositoryInterface $repo)
    {
        $this->repo = $repo;
    }

    public function index(FormRequest $request, Model $parent)
    {
        return $this->repo->output($parent->buildContentTree(true));
    }

    public function update(FormRequest $request, Model $parent, Model $model)
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
    public function show(FormRequest $request, Model $parent, Model $model)
    {
        return $model->edit();
    }
}
