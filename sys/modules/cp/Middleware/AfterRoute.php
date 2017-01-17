<?php

namespace P3in\Middleware;

use Closure;
use P3in\Models\Form;
use P3in\Models\FormAlias;
use P3in\Models\PageContent;
use Route; // links a view to a form

class AfterRoute
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $route = Route::current();

        $methods = ['GET'];

        // removes everything up to first / so we don't have to store the api/ prefix
        // in the alias table
        $uri = preg_replace("/^([a-z]*\/)/", '', $route->getName());

        \Log::info("FormAlias is looking for: " . $uri);

        $alias = FormAlias::byAlias($uri)->first();

        $response = $next($request);

        if ($response->exception) {
            $result = [
                'errors' => $response->exception->getMessage()
            ];

            if (env('APP_DEBUG')) {
                $result['file'] = $response->exception->getFile();
                $result['line'] = $response->exception->getLine();
                $result['trace'] = $response->exception->getTrace();
            }

            return response()->json($result, $response->getStatusCode());
        }

        if ($response->getStatusCode() === 200 && in_array($request->getMethod(), $methods)) {
            $content = [

                'collection' => json_decode($response->getContent()),

            ];

            // was getting impatient o.O
            // I know, this is getting wiped out and replaced, I just wanted to see the output for now :)
            // prob should have PageContent implement Formable Interface so we just check for the interface.
            $model = $response->getOriginalContent();
            if ($model instanceof PageContent) {
                $content['edit'] = $model->section->form;
            } elseif (count($alias)) {
                $content['edit'] = $alias->form->toEdit()->first();

                $content['list'] = $alias->form->toList()->first();
            }

            $response->setContent($content);
        }



        return $response;
    }

    public function terminate()
    {
    }
}
