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
        $host = $request->header('host');

        $origin = $request->header('origin'); // what is this?
        if ($origin) {
            list($scheme, $host) = explode('://', $origin);
        }

        $website = Website::where('host', $host)->first();

        if ($website) {

            $request->website = $website;

            return $next($request);

        }

        // temporary ofcourse so we can work locally with properly seeded data.
        $host = 'www.plus3interactive.com';
        try {
            $website = Website::where('host', $host)->firstOrFail();

            $request->website = $website;

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
