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
        // if the PageSectionContent has a source, we go deeper
        if ($model->source) {

            // based on the form linked to the current PageContentSection, look for a dynamic field
            foreach ($model->section->form->fields as $field) {

                if ($field->type !== 'Dynamic') {

                    continue;

                }

                // we found a dynamic field

                // now check if we have corresponding data coming in

                if ($request->{$field->name}['config']) {

                    $config = $request->{$field->name}['config'];

                    $field_source = $model->source;

                    $field_source->update($config);

                }

            }

        }

        // check if datasources

        // update linked datasource

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
