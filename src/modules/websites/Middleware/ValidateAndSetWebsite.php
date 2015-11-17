<?php

namespace P3in\Modules\Middleware;

use App\App;
use Closure;
use Illuminate\Contracts\Routing\Middleware;
use P3in\Models\Website;

class ValidateAndSetWebsite implements Middleware
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
        try {
            Website::current($request);
            return $next($request);
        } catch (Exception $e) {
            App::abort(401, trans('websites::accessnotauthorized'));
        } catch (ModelNotFoundException $e) {
            App::abort(401, trans('websites::accessnotauthorized'));
        }
    }
}
