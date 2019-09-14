<?php

namespace PacketPrep\Http\Controllers\Content;

use Illuminate\Http\Request;
use PacketPrep\Http\Controllers\Controller;
use PacketPrep\Models\Content\Label as Obj;
use Illuminate\Support\Facades\Storage;

class LabelController extends Controller
{
    
    public function __construct(){
        $this->app      =   'content';
        $this->module   =   'label';
        $this->cache_path =  '../storage/app/cache/label/';
    }
	/**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Obj $obj,Request $request)
    {

     $this->authorize('view', $obj);
     $search = $request->search;
     $item = $request->item;
     $page = $request->page;
     $filename = 'index.'.$this->app.'.'.$this->module.'.json';
     $filepath = $this->cache_path.$filename;

        /* update in cache folder */
        if($request->refresh){

        $objs = $obj->orderBy('created_at','desc')->where('status',1)->get();  
        file_put_contents($filepath, json_encode($objs,JSON_PRETTY_PRINT));

        foreach($objs as $obj){ 
            $filename = $obj->slug.'.json';
            $obj->articles = $obj->articles;
            $filepath = $this->cache_path.$filename;
            file_put_contents($filepath, json_encode($obj,JSON_PRETTY_PRINT));
        }

        flash('Blog Pages Cache Updated')->success();
        }

        $objs = $obj->where('name','LIKE',"%{$item}%")
        ->where('status',1)
        ->orderBy('created_at','desc')
        ->paginate(18);  

        $view = $search ? 'list': 'index';

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
                ->with('obj',$obj)
                ->with('editor',true)
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
            
            /* If image is given upload and store path */
            if(isset($request->all()['file'])){
                $file      = $request->all()['file'];
                $path = Storage::disk('public')->putFile('label', $request->file('file'));
                $request->merge(['image' => $path]);
            }

            // update slug with name if its empty
            if(!$request->get('slug')){
                $request->merge(['slug' => strtolower(str_replace(' ','-',$request->get('name')))]);
            }
            
            /* create a new entry */
            $obj = $obj->create($request->except(['file']));

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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $obj = Obj::where('id',$id)->first();
        $this->authorize('view', $obj);
        if($obj)
            return view('appl.'.$this->app.'.'.$this->module.'.show')
                    ->with('obj',$obj)->with('app',$this);
        else
            abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $obj= Obj::where('id',$id)->first();
        $this->authorize('update', $obj);


        if($obj)
            return view('appl.'.$this->app.'.'.$this->module.'.createedit')
                ->with('stub','Update')
                ->with('obj',$obj)
                ->with('editor',true)
                ->with('app',$this);
        else
            abort(404);
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
        try{
            $obj = Obj::where('id',$id)->first();

             /* delete file request */
            if($request->get('deletefile')){

                if(Storage::disk('public')->exists($obj->image)){
                    Storage::disk('public')->delete($obj->image);
                }
                redirect()->route($this->module.'.show',[$id]);
            }

            $this->authorize('update', $obj);
            /* If file is given upload and store path */
            if(isset($request->all()['file'])){
                $file      = $request->all()['file'];
                $path = Storage::disk('public')->putFile('label', $request->file('file'));
                $request->merge(['image' => $path]);
            }

            $obj = $obj->update($request->except(['file'])); 
            flash('('.$this->app.'/'.$this->module.') item is updated!')->success();
            return redirect()->route($this->module.'.show',$id);
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $obj = Obj::where('id',$id)->first();
        $this->authorize('update', $obj);

        // remove file
        if(Storage::disk('public')->exists($obj->image))
            Storage::disk('public')->delete($obj->image);
        
        $obj->delete();

        flash('('.$this->app.'/'.$this->module.') item  Successfully deleted!')->success();
        return redirect()->route($this->module.'.index');
    }
}
