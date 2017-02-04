<?php

namespace P3in\Controllers;

use Illuminate\Http\Request;
use P3in\Interfaces\PageContentRepositoryInterface;

class PageContentController extends AbstractChildController
{
    public function __construct(PageContentRepositoryInterface $repo)
    {
        $this->repo = $repo;
    }

    public function index(Request $request, $parent)
    {
        return [
            'data' => $parent->buildContentTree(true),
            'view' => $this->repo->view
        ];
    }

    public function update(Request $request, $parent, $model)
    {
        // check if we passing a content object, maybe a switch?, otherwise inferring it just from the content is gonna be tricky

        // sooo, based on the pagesectioncontent
        // we get the section
        // from the section we get the form
        // section form has a dynamic field
        // no, from

        dd($model);

        if ($model->source) {

            foreach ($model->section->form->fields as $field) {

                if ($field->type === 'Dynamic') {

                    // we found the dynamic field

                    dd($field->name); // we now get the data point it's supposed to be referring

                }

            }

        }

        dd($model->section->form);


        // dd($request->all());

        // check if datasources

        // update linked datasource

        if ($model->update(['content' => $request->all()])) {
            return ['success' => true];
        }

    }

    public function show($parent, $model)
    {
        $model->load('section.form');

        return [
            'form' => $model->section->form ? $model->section->form->render() : null,
            'content' => count($model->content) ? $model->content : ['' => ''] // @TODO needed to provide a workable object to the frontend, not gud
        ];

        return $model->section->form->render();
    }
}
