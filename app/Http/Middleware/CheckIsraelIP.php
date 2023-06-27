<?php

namespace App\Http\Middleware;

use App\Services\IPDetailsService;
use Closure;
use Illuminate\Http\Request;

class CheckIsraelIP
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (env('APP_ENV') === 'local') {
            return $next( $request );
        }

        $IPInfo = IPDetailsService::make()->getIPDetails($_SERVER[ 'REMOTE_ADDR' ]);
        if (! isset($IPInfo->country) || $IPInfo->country !== 'IL') {
            return abort(403);
        }

        return $next($request);
    }
}
