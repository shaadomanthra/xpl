<?php

namespace PacketPrep\Http\Controllers\Training;

use Illuminate\Http\Request;
use PacketPrep\Http\Controllers\Controller;
use PacketPrep\Models\Training\Training;
use PacketPrep\Models\Training\Resource as Obj;

class ResourceController extends Controller
{
    
    public function __construct(){
        $this->app      =   'training';
        $this->module   =   'resource';
        if(request()->route('training')){
            $this->training = Training::where('slug',request()->route('training'))->first();
        } 
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store($training,Obj $obj, Request $request)
    {
        try{
            $obj = $obj->create($request->all());

            flash('A new ('.$this->app.'/'.$obj->name.') item is created!')->success();
            return redirect()->route('schedule.index',$this->training->slug);
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
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($training,$id)
    {
        $obj= Obj::where('id',$id)->first();
        $this->authorize('update', $obj);

        if($obj)
            return view('appl.'.$this->app.'.'.$this->module.'.createedit')
                ->with('stub','Update')
                ->with('editor',1)
                ->with('jqueryui',1)
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
    public function update($training,$id,Request $request)
    {
        try{
            $obj = Obj::where('id',$id)->first();
            $this->authorize('update', $obj);
            $obj->update($request->all()); 
            flash('Resource item is updated!')->success();
            return redirect()->route('schedule.index',$training);
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
     public function destroy($training,$id)
    {
        $obj = Obj::where('id',$id)->first();

        $obj->delete();

        flash('('.$this->app.'/'.$this->module.') item  Successfully deleted!')->success();
        return redirect()->route('schedule.index',$training);
    }
}
