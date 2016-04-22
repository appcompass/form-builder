<?php

namespace P3in\Controllers;

use Illuminate\Http\Request;
use P3in\Controllers\UiBaseResourceController;
use P3in\Models\Gallery;

class CpGalleriesController extends UiBaseResourceController
{
    public function __construct(Request $request)
    {
        $this->init($request, function($routes){
            if (!empty($routes->params['galleries'])) {
                return $routes->params['galleries'];
            }else{
                return new Gallery;
            }
        });
    }
}
