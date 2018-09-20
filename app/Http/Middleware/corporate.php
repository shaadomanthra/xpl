<?php

namespace PacketPrep\Http\Middleware;

use Closure;

class corporate
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
        if(subdomain() != 'corporate')
            abort(403,'Unauthorized Access');
        else    
        return $next($request);
    }
}
