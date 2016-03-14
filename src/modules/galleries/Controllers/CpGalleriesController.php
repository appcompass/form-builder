<?php

namespace P3in\Controllers;

use Illuminate\Http\Request;
use P3in\Controllers\UiBaseResourceController;
use P3in\Models\Gallery;

class CpGalleriesController extends UiBaseResourceController
{
    public function __construct(Request $request, Gallery $galleries)
    {
        $this->init($request, $galleries);
    }

    // /**
    //  *
    //  *
    //  */
    // public function store(Request $request)
    // {
    //     $gallery = new Gallery($request->all());

    //     $this->record = $this->user->galleries()->save($gallery);

    //     return $this->json($this->setBaseUrl(['galleries', $this->record->id, 'photos']));

    // }

    // /**
    //  *
    //  *
    //  */
    // public function update(Request $request, Gallery $galleries)
    // {
    //     $this->record = $galleries;

    //     $this->record->update($request->all());

    //     return $this->json($this->setBaseUrl(['galleries', $galleries->id, 'edit']));
    // }
}
