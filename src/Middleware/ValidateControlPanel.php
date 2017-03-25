<?php

namespace P3in\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use P3in\Models\Website;

class ValidateControlPanel
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
        $request->website = $website = Website::fromRequest($request, env('ADMIN_WEBSITE_HOST'));

        Config::set('app.url', $website->url);
        Config::set('app.name', $website->name);
        Config::set('mail.from.address', 'website@'.$website->host);
        Config::set('mail.from.name', $website->name);

        return $next($request);
    }

    public function terminate()
    {
    }
}
