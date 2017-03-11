<?php

namespace P3in\Middleware;

use P3in\Models\PageComponentContent;
use Illuminate\Http\Request;
use P3in\Models\FormAlias;
use P3in\Models\Form;
use Closure;
use Route;

class AfterRoute
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $methods = ['GET'];

        // resolve form by uri
        $form = Form::byResource(Route::currentRouteName())->first();

        // get response
        $response = $next($request);

        if ($response->getStatusCode() === 200 && in_array($request->getMethod(), $methods)) {

            $response->setContent([
                'collection' => $response->getOriginalContent(),
                'edit' => $form ? $form->render('edit') : null,
                'list' => $form ? $form->render('list') : null,
                'abilities' => ['create', 'edit', 'destroy', 'index', 'show'] // @TODO show is per-item in the collection
            ]);
        }

        return $response;
    }

    public function terminate()
    {
    }
}
