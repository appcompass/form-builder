<?php

namespace P3in\Middleware;

use Closure;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use P3in\Models\Form;
use P3in\Models\FormAlias;
use P3in\Models\PageComponentContent;
use Route;

class AddDebug
{
    private $logged = [];
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (env('APP_DEBUG')) {
            $this->enableLogging();

            // get response
            $response = $next($request);

            return $this->setOutput($response);
        }else{
            return $next($request);
        }
    }

    public function terminate()
    {
    }

    private function enableLogging()
    {
        \DB::enableQueryLog();

        \Event::listen('illuminate.log', function ($level, $message, $context) {
            $this->logged['logged'][] = [
                'level' => $level,
                'message' => $message,
                'context' => $context
            ];
        });
    }

    private function setOutput($response)
    {
        if ($response instanceof JsonResponse) {
            $content = $response->getData(true);
            $rtn_method = 'setData';
        } else {
            $content = $response->getOriginalContent();
            $rtn_method = 'setContent';
        }

        $this->logged['queries'] = \DB::getQueryLog();

        $content['debug'] = $this->logged;

        return $response->$rtn_method($content);
    }
}
