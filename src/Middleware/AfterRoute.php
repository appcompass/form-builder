<?php

namespace P3in\Middleware;

use Closure;
use Illuminate\Http\Request;
use P3in\Models\Form;
use P3in\Models\FormAlias;
use P3in\Models\PageComponentContent;
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
        $route = Route::current();

        $methods = ['GET'];

        // resolve form by uri
        $form = Form::byResource($route->getName())->first();

        // get response
        $response = $next($request);

        if ($response->getStatusCode() === 200 && in_array($request->getMethod(), $methods)) {

            $response->setContent([
                'collection' => $response->getOriginalContent(),
                'edit' => $form ? $form->render('edit') : null,
                'list' => $form ? $form->render('list') : null
            ]);
        }

        return $response;
    }

    public function terminate()
    {
    }
}
