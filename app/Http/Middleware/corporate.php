<?php

namespace PacketPrep\Http\Middleware;

use Closure;

class Corporate
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
        if(subdomain()){
            if(subdomain()!='hire' && subdomain()!='xplore'){
               $filename = '../storage/app/cache/company/'.subdomain().'.json';
               $logo_1 = url('/').'/storage/companies/'.subdomain().'.png';
               $logo_2 = url('/').'/storage/companies/'.subdomain().'.jpg';
               $logo_3 = url('/').'/img/logo-onlinelibrary.png';

                if(file_exists($filename)){

                        $client = json_decode(file_get_contents($filename));


                        if(urlexists($logo_1))
                            $client->logo = $logo_1;
                        elseif(urlexists($logo_2))
                            $client->logo = $logo_2;
                        else
                            $client->logo = $logo_3;



                        if($client->status==0)
                            abort(403,'Site is not published');
                        elseif($client->status==2)
                            abort(403,'Site is on hold');
                        elseif($client->status==3)
                            abort(403,'Site services are terminated');
                        $request->session()->put('client',$client);
                }else{
                    abort(404,'Site not found');
                } 
            }
            

            return $next($request);
            
        }
        else{
            $filename = 'corporate.json';
            $client = json_decode(file_get_contents($filename));
            $client->name = 'Xplore';
            $client->logo = url('/').'/img/xplore.png';

            $request->session()->put('client',$client);

            return $next($request);
        }    
        
    }
}
