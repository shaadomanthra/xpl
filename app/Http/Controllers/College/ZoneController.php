<?php

namespace PacketPrep\Http\Controllers\College;

use Illuminate\Http\Request;
use PacketPrep\Http\Controllers\Controller;
use PacketPrep\Models\College\Zone as Obj;
use PacketPrep\Models\College\Metric;
use PacketPrep\Models\College\Branch;

class ZoneController extends Controller
{
    public function __construct(){
        $this->app      =   'college';
        $this->module   =   'zone';
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

    public function students($id,Request $request)
    {
        if(is_numeric($id))
            $obj = Obj::where('id',$id)->first();
        else
           $obj = Obj::where('name',$id)->first(); 

        $branch = $request->get('branch');
        $year_of_passing = $request->get('year_of_passing');
        $metric= $request->get('metric');

       $users = $obj->users()->paginate(config('global.no_of_records'));
       dd($users);
        $total = count($obj->users);

        if($branch){
            if($year_of_passing){
            $users = $obj->users()->whereHas('branches', function ($query) use ($branch) {
                                $query->where('name', '=', $branch);
                            })->whereHas('details', function ($query) use ($year_of_passing) {
                                $query->where('year_of_passing', '=', $year_of_passing);
                            })->get();
            }else
            $users = $obj->users()->whereHas('branches', function ($query) use ($branch) {
                                $query->where('name', '=', $branch);
                            })->get();
        }else{

            if($year_of_passing){
            $users = $obj->users()->whereHas('details', function ($query) use ($year_of_passing) {
                                $query->where('year_of_passing', '=', $year_of_passing);
                            })->get();
            }
        }

        if($metric){
            if($year_of_passing){
            $users = $obj->users()->whereHas('metrics', function ($query) use ($metric) {
                                $query->where('name', '=', $metric);
                            })->whereHas('details', function ($query) use ($year_of_passing) {
                                $query->where('year_of_passing', '=', $year_of_passing);
                            })->get();
            }else
            $users = $obj->users()->whereHas('metrics', function ($query) use ($metric) {
                                $query->where('name', '=', $metric);
                            })->get();

        }



        
        $this->authorize('view', $obj);
        if($obj)
            return view('appl.'.$this->app.'.'.$this->module.'.student')
                    ->with('obj',$obj)->with('app',$this)->with('users',$users)->with('total',$total);
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

        $year_of_passing = $request->get('year_of_passing');
        $metrics = Metric::all();
        $obj->branches = Branch::all();
        $data = array();

        if($year_of_passing)
        {
            

            foreach($obj->branches as $b){
            $data['branches'][$b->name] = $obj->users()->whereHas('details',function($query) use($year_of_passing){
                $query->where('year_of_passing',$year_of_passing);
            })->whereHas('branches', function ($query) use ($b) {
                            $query->where('name', '=', $b->name);
                        })->count(); 
            }

            foreach($metrics as $m){
                $data['metrics'][$m->name] = $obj->users()->whereHas('details',function($query) use($year_of_passing){
                $query->where('year_of_passing',$year_of_passing);
            })->whereHas('metrics', function ($query) use ($m) {
                                $query->where('name', '=', $m->name);
                            })->count(); 
            }

            $data['users']['all'] = $obj->users()->whereHas('details',function($query) use($year_of_passing){
                $query->where('year_of_passing',$year_of_passing);
            })->count();

            $data['users']['pro'] =  $obj->users()->whereHas('details',function($query) use($year_of_passing){
                $query->where('year_of_passing',$year_of_passing);
            })->whereHas('services', function ($query) use ($m) {
                                $query->where('name', '=', 'Pro Access');
                            })->count();

            $data['users']['premium'] = $obj->users()->whereHas('details',function($query) use($year_of_passing){
                $query->where('year_of_passing',$year_of_passing);
            })->whereHas('services', function ($query) use ($m) {
                                $query->where('name', '=', 'Premium Access');
                            })->count();

            
        }else{

            foreach($obj->branches as $b){
            $data['branches'][$b->name] = $obj->users()->whereHas('branches', function ($query) use ($b) {
                            $query->where('name', '=', $b->name);
                        })->count(); 
            }

            foreach($metrics as $m){
                $data['metrics'][$m->name] = $obj->users()->whereHas('metrics', function ($query) use ($m) {
                                $query->where('name', '=', $m->name);
                            })->count(); 
            }

            $data['users']['all'] = $obj->users()->count();
            $data['users']['pro'] =  $obj->users()->whereHas('services', function ($query) use ($m) {
                                $query->where('name', '=', 'Pro Access');
                            })->count();
            $data['users']['premium'] = $obj->users()->whereHas('services', function ($query) use ($m) {
                                $query->where('name', '=', 'Premium Access');
                            })->count();
            
        }

        

        


        //dd($obj->users);
        
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
