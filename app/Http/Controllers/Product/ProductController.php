<?php

namespace PacketPrep\Http\Controllers\Product;

use Illuminate\Http\Request;
use PacketPrep\Http\Controllers\Controller;
use PacketPrep\Models\Dataentry\Tag;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $tags =  Tag::where('project_id','39')
                        ->orderBy('created_at','desc ')
                        ->get()->groupBy(function($item)
                        {
                          return $item->name;
                        });

        return view('appl.product.product.index')->with('tags',$tags['exam']);
    }

    public function welcome(){

        $url = url()->full();
        if($this->hasSubdomain($url)){
            $parsed = parse_url($url);
            $exploded = explode('.', $parsed["host"]);
            $subdomain = $exploded[0];
            $file = "../json/".$subdomain.".json";
            $filedata = json_decode(file_get_contents($file));
            if(file_exists($file)){
                if($subdomain == 'corporate')
                {
                    return view('appl.product.corporate.index');
                }
                else{
                    
                    if($filedata->status==0)
                        return view('appl.product.front.unpublished')->with('subdomain',$subdomain);
                    elseif($filedata->status==1)
                         return view('welcome');
                    elseif($filedata->status==2)
                        return view('appl.product.front.hold')->with('subdomain',$subdomain);
                    else
                        return view('appl.product.front.terminated')->with('subdomain',$subdomain);

                }       
            }
            else
                return view('appl.product.front.notfound')->with('subdomain',$subdomain);
        }
        else
            return view('appl.product.front.index'); 
    }

    public function hasSubdomain($url) {
        $parsed = parse_url($url);
        $exploded = explode('.', $parsed["host"]);
        return (count($exploded) > 2);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
