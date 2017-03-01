<?php

namespace P3in\Modules\Middleware;

use App;
use Closure;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Intervention\Image\Exception\NotFoundException;
use P3in\Models\Website;

class ValidateAndSetWebsite
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

            if (is_null(Website::getCurrent())) {

                $site_name = $request->header('site-name');

                $current = Website::setCurrent(Website::where('site_name', '=', $site_name)->firstOrFail());

            }

            return $next($request);

        } catch (NotFoundException $e) {

            App::abort(401, 'Unauthorized');

        } catch (ModelNotFoundException $e) {

            App::abort(401, 'Unauthorized');

        }
    }
}
