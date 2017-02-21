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

        // removes everything up to first / so we don't have to store the api/ prefix
        // in the alias table
        $uri = preg_replace("/^([a-z]*\/)/", '', $route->getName());

        // resolve form by uri
        $form = Form::byResource($uri);

        // \Log::info('AfterRequest is looking for: ' . $uri);

        // get response
        $response = $next($request);

        // return for exceptions
        if (isset($response->exception)) {
            $result = [
                'errors' => $response->exception->getMessage(),
            ];

            if (env('APP_DEBUG')) {
                $result['file'] = $response->exception->getFile();
                $result['line'] = $response->exception->getLine();
                $result['trace'] = $response->exception->getTrace();
            }

            return response()->json($result, $response->getStatusCode());
        }

        if ($response->getStatusCode() === 200 && in_array($request->getMethod(), $methods)) {

            $content['collection'] = $response->getOriginalContent();

            $content['edit'] = $form->toEdit()->first();

            $content['list'] = $form->toList()->first();

            $response->setContent($content);
        }

        return $response;
    }

    public function terminate()
    {
    }
}
