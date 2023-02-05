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

        if( $_SERVER['HTTP_HOST'] == 'packetprep.xplore.co.in'){
             return redirect('https://learn.packetprep.com/',301);
         }
           

        if( subdomain()=='packetprep' && domain()=='xplore')
            return redirect('https://learn.packetprep.com/',301);

        if(subdomain()){

             

            if(subdomain() == 'www'){
                $url = url()->full();
                $parsed = parse_url($url);
                $exploded = explode('.', $parsed["host"]);
                array_shift($exploded);
                $new_url = implode('.',$exploded);

                return redirect()->to('https://'.$new_url);
            }
            elseif($_SERVER['HTTP_HOST'] == 'onlinelibrary.test' || $_SERVER['HTTP_HOST'] == 'piofx.in' || $_SERVER['HTTP_HOST'] == 'p24.in' ){
                $filename = 'corporate.json';
                $client = json_decode(file_get_contents($filename));
                $client->name = 'Piofx';
                $client->logo = url('/').'/img/piofx.png';

                $request->session()->put('client',$client);
            }
            elseif($_SERVER['HTTP_HOST'] == 'gradable.in' || $_SERVER['HTTP_HOST'] == 'gradable.test'){
                $filename = 'corporate.json';
                $client = json_decode(file_get_contents($filename));
                $client->name = 'Gradable';
                $client->logo = url('/').'/img/gradable.png';
                $request->session()->put('client',$client);
            }
             elseif($_SERVER['HTTP_HOST'] == 'myparakh.test' || $_SERVER['HTTP_HOST'] == 'myparakh.com'){
                $filename = 'corporate.json';
                $client = json_decode(file_get_contents($filename));
                $client->name = 'Parakh';
                $client->logo = url('/').'/img/myparakh.png';
                $request->session()->put('client',$client);
            }
            elseif( subdomain()!='xplore' && subdomain()!='bfs'){

                $client = Cache::remember('client_'.subdomain(),2400,function() {
                            return Client::where('slug',subdomain())->first();
                });
                if($client){


                    if(Storage::disk('s3')->exists('companies/'.subdomain().'.png')){
                        $client->logo = Storage::disk('s3')->url('companies/'.subdomain().'.png');
                    }
                    else if(Storage::disk('s3')->exists('companies/'.subdomain().'.jpg'))
                        $client->logo = Storage::disk('s3')->url('companies/'.subdomain().'.jpg');
                    else{
                        $client->logo = url('/').'/img/default_logo.png';
                    } 
                        

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
                        $request->session()->put('settings',json_decode($client->settings));
                }else{
                    abort(404,'Site not found - '.subdomain());
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
