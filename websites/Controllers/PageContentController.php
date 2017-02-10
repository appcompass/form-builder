<?php

namespace P3in\Controllers;

use Illuminate\Http\Request;
use P3in\Interfaces\PageContentRepositoryInterface;
use P3in\Traits\StoresFiles;

class PageContentController extends AbstractChildController
{
    use StoresFiles;

    public function __construct(PageContentRepositoryInterface $repo)
    {
        $this->repo = $repo;
        // @TODO: we should do this automatically by detecting if it uses this trait
        // and then automatically runs this method.
        //
        // this is an example only, these disk instances are install specific
        // and some things like websites need to set their own disk for their page
        // galleries page contents, and blog posts to upload to.
        $this->initStorage(['plus3website', 'cp_form_fields', 'cp_components', 'cp_root']);
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
        $all = $request->all();
        $files = $request->file();
        $disk = $parent->website->getDisk();

        if (count($files)) {
            // @TODO: this is flawed since it doesn't account for multi-dimentional form payloads.
            foreach ($files as $fieldName => $file) {
                // @TODO: first way, can be store by name BUT it requires the
                // use of 'StoresFiles' AND initiStorage() somewhere before this is called.
                // Not a big fan of that aproach.
                // $all[$fieldName] = $file->storeAs('', $file->getClientOriginalName(), 'plus3website');

                // @TODO: second way, step back to the website storage and store.
                // cleaning, doesn't require a new trait (which may still be needed)
                // but it steps back in a chain up 3 levels, am not sure how I feel about that.
                $all[$fieldName] = $disk->putFileAs('', $file, $file->getClientOriginalName());
            }
        }

        if ($model->source) {

            foreach ($model->section->form->fields as $field) {

                if ($field->type !== 'Dynamic') {

                    continue;

                }

                $field_source = $model->source->update($request->{$field->name});

                unset($request->{$field->name});

            }

        }

        if ($model->update(['content' => $all])) {

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
        return $model->edit();
    }
}
