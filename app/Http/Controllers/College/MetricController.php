<?php

namespace PacketPrep\Http\Controllers\College;

use Illuminate\Http\Request;
use PacketPrep\Http\Controllers\Controller;
use PacketPrep\Models\College\Metric as Obj;
use PacketPrep\Models\College\Branch; 
use PacketPrep\Models\College\Zone; 
use Illuminate\Support\Facades\DB;
use PacketPrep\User;

class MetricController extends Controller
{
    public function __construct(){
        $this->app      =   'college';
        $this->module   =   'metric';
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

        return view('appl.'.$this->app.'.'.$this->module.'.createedit')
                ->with('stub','Create')
                ->with('jqueryui',true)
                ->with('obj',$obj)
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
            $obj = $obj->create($request->all());
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
        if(is_numeric($id))
        $obj = Obj::where('id',$id)->first();
        else
         $obj = Obj::where('name',$id)->first();

        $this->authorize('view', $obj);
        if($obj)
            return view('appl.'.$this->app.'.'.$this->module.'.show')
                    ->with('obj',$obj)->with('app',$this);
        else
            abort(404);
    }


    public function students($id,Request $request)
    {
        if(is_numeric($id))
         $obj = Obj::where('id',$id)->first();
        else
         $obj = Obj::where('name',$id)->first();


        $branch = $request->get('branch');
        $zone = $request->get('zone');
        $z = Zone::where('name',$zone)->first();
        $b = Branch::where('name',$branch)->first();

        $obj_users = $obj->users()->pluck('id')->toArray();
        
        if($branch){
            $branch_users = $b->users()->pluck('id')->toArray();
            $u= array_intersect($obj_users,$branch_users);
            $users = User::whereIn('id',$u)->orderBy('id','desc')->paginate(config('global.no_of_records'));
             $total = count($u);
        }
        if($zone){
            $zone_users = $z->users()->pluck('id')->toArray();
            $u= array_intersect($obj_users,$zone_users);
            $users = User::whereIn('id',$u)->orderBy('id','desc')->paginate(config('global.no_of_records'));
            $total = count($u);
           
        }
        if(!$branch && !$zone)
        {
            $total = count($obj_users);
            $users = $obj->users()->orderBy('id','desc')->paginate(config('global.no_of_records'));
        }


        
        $this->authorize('view', $obj);
        if($obj)
            return view('appl.'.$this->app.'.'.$this->module.'.student')
                    ->with('obj',$obj)->with('app',$this)->with('users',$users)->with('total',$total)->with('zone',$z)->with('branch',$b);
        else
            abort(404);
    }

    public function show2($id,Request $request)
    {
        if(is_numeric($id))
         $obj = Obj::where('id',$id)->first();
        else
         $obj = Obj::where('name',$id)->first();

        $this->authorize('view', $obj);

        $metrics = Obj::all();
        $zones = Zone::all();
        $obj->branches = Branch::all();
        $data = array();

        $obj_users = $obj->users()->pluck('id')->toArray();
            
            foreach($obj->branches as $b){
                $branch_users = $b->users()->pluck('id')->toArray();
                $u= array_intersect($obj_users,$branch_users);
                $data['branches'][$b->name] = count($u);
            }

            foreach($zones as $z){

                $zone_users = $z->users()->pluck('id')->toArray();
                $u= array_intersect($obj_users,$zone_users);
                $data['zones'][$z->name] = count($u);

            }

            $data['users']['all'] = count($obj_users);
            
    

        if($obj)
            return view('appl.'.$this->app.'.'.$this->module.'.show2')
                    ->with('college',$obj)->with('app',$this)
                    ->with('obj',$obj)->with('app',$this)
                    ->with('metrics',$metrics)
                    ->with('data',$data);
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
                ->with('jqueryui',true)
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
            $obj = $obj->update($request->all()); 
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
