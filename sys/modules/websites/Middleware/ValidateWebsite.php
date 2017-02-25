<?php

namespace P3in\Middleware;

use Closure;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use P3in\Models\Website;
use Route;

class ValidateWebsite
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
        $origin = $request->header('origin');

        $parts = explode('://', $origin);

        if (count($parts) == 2) {

            list($scheme, $host) = $parts;

        }

        try {

            $request->website = Website::whereHost($host)->firstOrFail();

            return $next($request);

        } catch (NotFoundException $e) {

            App::abort(401, $host.' Not Authorized');

        } catch (ModelNotFoundException $e) {

            App::abort(401, $host.' Not Authorized');

        }

        // before
        $response = $next($request);
        // after
        return $response;
    }

    public function terminate()
    {
    }
}
