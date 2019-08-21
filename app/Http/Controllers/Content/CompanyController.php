<?php

namespace PacketPrep\Http\Controllers\Content;

use Illuminate\Http\Request;
use PacketPrep\Http\Controllers\Controller;
use PacketPrep\Models\Content\Company as Obj;
use Illuminate\Support\Facades\Storage;

class CompanyController extends Controller
{

    public function __construct(){
        $this->app      =   'content';
        $this->module   =   'company';
        $this->cache_path =  '../storage/app/cache/company/';
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Obj $obj,Request $request)
    {

     $search = $request->search;
     $item = $request->item;
     /* update in cache folder */
     if($request->refresh){
        $filename = 'index.'.$this->app.'.'.$this->module.'.json';
        $filepath = $this->cache_path.$filename;

        $objs = $obj->orderBy('created_at','desc')
        ->get();  
        file_put_contents($filepath, json_encode($objs,JSON_PRETTY_PRINT));

        foreach($objs as $obj){ 
            $filename = $obj->slug.'.json';
            $filepath = $this->cache_path.$filename;
            file_put_contents($filepath, json_encode($obj,JSON_PRETTY_PRINT));
        }

        flash('Company Pages Cache Updated')->success();
    }

    $objs = $obj->where('name','LIKE',"%{$item}%")
    ->orderBy('created_at','desc')
    ->paginate(config('global.no_of_records'));  

    $view = $search ? 'list': 'index';

    return view('appl.'.$this->app.'.'.$this->module.'.'.$view)
        ->with('objs',$objs)
        ->with('obj',$obj)
        ->with('app',$this);
    }

    /** PUBLIC LISTING
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function public(Obj $obj,Request $request)
    {

        $search = $request->search;
        $item = $request->item;
        
        //cache file
        $filename = 'index.'.$this->app.'.'.$this->module.'.json';
        $filepath = $this->cache_path.$filename;

        if(file_exists($filename) && !$search)
        {
            $objs = json_decode(file_get_contents($filename));
        }elseif($search){
            $objs = $obj->where('name','LIKE',"%{$item}%")
                    ->orderBy('created_at','desc')
                    ->get(); 
        }
        else{
            $objs = $obj->where('name','LIKE',"%{$item}%")
                    ->orderBy('created_at','desc')
                    ->get(); 
            file_put_contents($filepath, json_encode($objs,JSON_PRETTY_PRINT));
        }

        $view = $search ? 'public_list': 'public';

        return view('appl.'.$this->app.'.'.$this->module.'.'.$view)
                ->with('objs',$objs)
                ->with('obj',$obj)
                ->with('app',$this);
    }

    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $obj = new Obj();
        $this->authorize('create', $obj);

        return view('appl.'.$this->app.'.'.$this->module.'.createedit')
                ->with('stub','Create')
                ->with('jqueryui',true)
                ->with('obj',$obj)
                 ->with('editor','true')
                ->with('app',$this);
    }

    


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Obj $obj, Request $request)
    {
         try{

            // update slug with name if its empty
            if(!$request->get('slug')){
                $request->merge(['slug' => strtolower(str_replace(' ','_',$request->get('name')))]);
            }

            /* If image is given upload and store path */
            if(isset($request->all()['file_'])){
                $file      = $request->all()['file_'];
                $filename = $request->get('slug').'.'.$file->getClientOriginalExtension();
                $path = Storage::disk('public')->putFileAs('company', $request->file('file_'),$filename);
                $request->merge(['image' => $path]);
            }

            /* create a new entry */
            $obj->create($request->except(['file_']));


            /* update cache file of this product */
            $filename = $obj->slug.'.json';
            $filepath = $this->cache_path.$filename;
            file_put_contents($filepath, json_encode($obj,JSON_PRETTY_PRINT));

            /* update in cache folder main file */
            $filename = 'index.'.$this->app.'.'.$this->module.'.json';
            $filepath = $this->cache_path.$filename;
            $objs = $obj->orderBy('created_at','desc')
                        ->get(); 
            file_put_contents($filepath, json_encode($objs,JSON_PRETTY_PRINT));

            flash('A new ('.$this->app.'/'.$this->module.') item is created!')->success();
            return redirect()->route($this->module.'.index');
        }
        catch (QueryException $e){
           $error_code = $e->errorInfo[1];
            if($error_code == 1062){
                flash('Some error in Creating the record')->error();
                 return redirect()->back()->withInput();;
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $slug
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        $obj = Obj::where('slug',$slug)->first();

        if($obj)
            return view('appl.'.$this->app.'.'.$this->module.'.show')
                    ->with('obj',$obj)->with('app',$this);
        else
            abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $slug
     * @return \Illuminate\Http\Response
     */
    public function edit($slug)
    {
        $obj= Obj::where('slug',$slug)->first();
        $this->authorize('update', $obj);


        if($obj)
            return view('appl.'.$this->app.'.'.$this->module.'.createedit')
                ->with('stub','Update')
                ->with('jqueryui',true)
                ->with('editor','true')
                ->with('obj',$obj)->with('app',$this);
        else
            abort(404);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $slug
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $slug)
    {
         try{
            $obj = Obj::where('slug',$slug)->first();

             /* delete file request */
            if($request->get('deletefile')){

                if(Storage::disk('public')->exists($obj->image)){
                    Storage::disk('public')->delete($obj->image);
                }
                redirect()->route($this->module.'.show',[$slug]);
            }

            $this->authorize('update', $obj);
            /* If image is given upload and store path */
            if(isset($request->all()['file_'])){
                $file      = $request->all()['file_'];
                $filename = $request->get('slug').'.'.$file->getClientOriginalExtension();
                $path = Storage::disk('public')->putFileAs('company', $request->file('file_'),$filename);
                $request->merge(['image' => $path]);
            }

            

            $obj->update($request->except(['file_'])); 


            /* update cache file of this product */
            $filename = $obj->slug.'.json';
            $filepath = $this->cache_path.$filename;
            file_put_contents($filepath, json_encode($obj,JSON_PRETTY_PRINT));

            /* update in cache folder main file */
            $filename = 'index.'.$this->app.'.'.$this->module.'.json';
            $filepath = $this->cache_path.$filename;
            $objs = $obj->orderBy('created_at','desc')
                        ->get(); 
            file_put_contents($filepath, json_encode($objs,JSON_PRETTY_PRINT));
            

            flash('('.$this->app.'/'.$this->module.') item is updated!')->success();
            return redirect()->route($this->module.'.show',$slug);
        }
        catch (QueryException $e){
           $error_code = $e->errorInfo[1];
            if($error_code == 1062){
                 flash('Some error in updating the record')->error();
                 return redirect()->back()->withInput();
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $slug
     * @return \Illuminate\Http\Response
     */
     public function destroy($slug)
    {
        $obj = Obj::where('slug',$slug)->first();
        $this->authorize('update', $obj);
        $obj->delete();

        flash('('.$this->app.'/'.$this->module.') item  Successfully deleted!')->success();
        return redirect()->route($this->module.'.index');
    }
}
