<?php

namespace PacketPrep\Http\Controllers\College;

use Illuminate\Http\Request;
use PacketPrep\Http\Controllers\Controller;
use PacketPrep\Models\College\College as Obj;
use PacketPrep\Models\College\Zone;
use PacketPrep\Models\College\Branch;

class CollegeController extends Controller
{
    public function __construct(){
        $this->app      =   'college';
        $this->module   =   'college';
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
        
        $objs = $obj->where('name','LIKE',"%{$item}%")
                    ->orderBy('created_at','desc ')
                    ->paginate(config('global.no_of_records'));   
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
        $zones = Zone::all();
        $branches = Branch::all();


        return view('appl.'.$this->app.'.'.$this->module.'.createedit')
                ->with('stub','Create')
                ->with('jqueryui',true)
                ->with('obj',$obj)
                ->with('zones',$zones)
                ->with('branches',$branches)
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

            $zone_id = $request->get('zone_id');
            $branches = $request->get('branches');


            $obj = $obj->create($request->except(['zone_id','branches']));

            //branches
            $branch_list =  Branch::orderBy('created_at','desc ')
                        ->get()->pluck('id')->toArray();
            if($branches)
            foreach($branch_list as $branch){
                if(in_array($branch, $branches)){
                    if(!$obj->branches->contains($branch))
                        $obj->branches()->attach($branch);
                }else{
                    if($obj->branches->contains($branch))
                        $obj->branches()->detach($branch);
                }
                
            }else{
                $obj->branches()->detach();
            } 

            //zone

            if(!$obj->zones->contains($zone_id))
                $obj->zones()->attach($zone_id);

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
        $zones = Zone::all();
        $branches = Branch::all();



        if($obj)
            return view('appl.'.$this->app.'.'.$this->module.'.createedit')
                ->with('stub','Update')
                ->with('jqueryui',true)
                ->with('branches',$branches)
                ->with('zones',$zones)
                ->with('obj',$obj)->with('app',$this);
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

            $this->authorize('update', $obj);

            $zone_id = $request->get('zone_id');
            $branches = $request->get('branches');

            //branches
            $branch_list =  Branch::orderBy('created_at','desc ')
                        ->get()->pluck('id')->toArray();
            if($branches)
            foreach($branch_list as $branch){
                if(in_array($branch, $branches)){
                    if(!$obj->branches->contains($branch))
                        $obj->branches()->attach($branch);
                }else{
                    if($obj->branches->contains($branch))
                        $obj->branches()->detach($branch);
                }
                
            }else{
                $obj->branches()->detach();
            } 

            //zone
            $obj->zones()->detach();
            if(!$obj->zones->contains($zone_id))
                $obj->zones()->attach($zone_id);

            $obj = $obj->update($request->except(['zone_id','branches'])); 
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
        $obj->delete();

        flash('('.$this->app.'/'.$this->module.') item  Successfully deleted!')->success();
        return redirect()->route($this->module.'.index');
    }
}
