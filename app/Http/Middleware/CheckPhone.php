<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Redirect;
use Jenssegers\Agent\Agent;

class CheckPhone
{

    /**
     * Minimum version 
     */
    const IOS_MIN_VERSION = 12.0;

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $agent = new Agent();
        $version = $agent->version($agent->platform());
        if ($agent->is('OS X') && (float)$version < self::IOS_MIN_VERSION) {
            return Redirect::to('https://www.apple.com/iphone/buy/');
        }
        return $next($request);
    }
}
