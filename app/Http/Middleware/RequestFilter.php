<?php

namespace PacketPrep\Http\Middleware;

use Closure;

class RequestFilter
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
        foreach($request->all() as $key => $req)
        {
            $item = scriptStripper($req);
            $request->merge([$key => $item]);
        }

        return $next($request);
    }
}
