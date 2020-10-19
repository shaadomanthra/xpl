<?php

namespace PacketPrep\Http\Middleware;

use Closure;

class nocache
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
        if(!$request->get('export') && !$request->get('student'))
        {
            $response->header('Expires', 'Fri, 01 Jan 1990 00:00:00 GMT');
            $response->header('Cache-Control', 'no-cache, must-revalidate, no-store, max-age=0, private');
        }
        

        return $response;
    }
}
