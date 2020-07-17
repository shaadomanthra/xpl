<?php

namespace PacketPrep\Http\Middleware;
use PacketPrep\Models\Product\Client;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Cache;

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

            if($_SERVER['HTTP_HOST'] == 'bfs.piofx.com' || $_SERVER['HTTP_HOST'] == 'piofx.com' || $_SERVER['HTTP_HOST'] == 'bfs' ){
                $filename = 'corporate.json';
                $client = json_decode(file_get_contents($filename));
                $client->name = 'Bajaj Finserv';
                $client->logo = url('/').'/img/bfs.jpg';

                $request->session()->put('client',$client);
            }
            elseif(subdomain()!='hire' && subdomain()!='xplore' && subdomain()!='bfs'){

                $client = Cache::get('client_'.subdomain(),function() {
                            return Client::where('slug',subdomain())->first();
                });
                if($client){


                    if(Storage::disk('s3')->exists('companies/'.subdomain().'.png')){
                        $client->logo = Storage::disk('s3')->url('companies/'.subdomain().'.png');
                    }
                    else if(Storage::disk('s3')->exists('companies/'.subdomain().'.jpg'))
                        $client->logo = Storage::disk('s3')->url('companies/'.subdomain().'.jpg');
                    else 
                        $client->logo = url('/').'/img/xplore.png';

                        //$client = json_decode(file_get_contents($filename));
                        // if(urlexists($logo_1))
                        //     $client->logo = $logo_1;
                        // elseif(urlexists($logo_2))
                        //     $client->logo = $logo_2;
                        // else
                        //     $client->logo = $logo_3;

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
            }else{
                $filename = 'corporate.json';
                $client = json_decode(file_get_contents($filename));
                $client->name = 'Xplore';
                $client->logo = url('/').'/img/xplore.png';
                $request->session()->put('client',$client);
                return $next($request);

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
