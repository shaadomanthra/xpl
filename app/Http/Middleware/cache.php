<?php

namespace PacketPrep\Http\Middleware;

use Closure;

class cache
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
        $response = $next($request);

        $response->header('Cache-Control', 'max-age=31557600,public');

        return $response;
    }
}
