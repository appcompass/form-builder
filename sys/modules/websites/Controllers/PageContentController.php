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
