<?php

namespace PacketPrep\Http\Controllers\System;

use Illuminate\Http\Request;
use PacketPrep\Http\Controllers\Controller;
use PacketPrep\Models\System\Update;
use PacketPrep\Models\System\Goal;

class UpdateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request,Update $update)
    {
        $this->authorize('view', $update);
        $item = $request->item;

        if(\Auth::guest())
            return redirect('login');
        if(\Auth::user()->checkRole(['administrator','manager'])){
            $updates = $update->orderBy('created_at','desc ')
                    ->paginate(config('global.no_of_records'));
        }else{
            $updates = $update->where('status',1)
                    ->orderBy('created_at','desc ')
                    ->paginate(config('global.no_of_records'));
        }
        
        return view('appl.system.update.index')
            ->with('update',$update)
            ->with('updates',$updates);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Update $update)
    {
        $this->authorize('create', $update);
        return view('appl.system.update.createedit')
                ->with('update',$update)
                ->with('stub','Create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try{
            $update = new Update;
            $update->user_id = $request->user_id;
            $update->content = $request->content;
            $update->type = $request->type;
            $update->status = $request->status;
            $update->save();

            flash('A new update('.$request->name.') is created!')->success();
            return redirect()->route('update.index');
        }
        catch (QueryException $e){
           $error_code = $e->errorInfo[1];
            if($error_code == 1062){
                flash('Some error is there kindly recheck!')->error();
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
        return redirect()->route('update.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $update = Update::where('id',$id)->first();
        $this->authorize('edit', $update);
        if($update)
            return view('appl.system.update.createedit')
                    ->with('update',$update)
                    ->with('stub','Update');
        else
            abort(404);
    }


    public function system(){
        $goals = Goal::where('prime',1)->where('status',0)->get();
        if(\auth::user()->checkRole(['administrator','investor','patron','promoter','employee']))
            return view('appl.system.index')->with('goals',$goals); 
        else
            return abort('403','Unauthorized Access');

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
            $update = Update::where('id',$id)->first();
            $update->user_id = $request->user_id;
            $update->content = $request->content;
            $update->type = $request->type;
            $update->status = $request->status;
            $update->save();

            flash('Update (<b>id '.$id.'</b>) Successfully updated!')->success();
            return redirect()->route('update.index');
        }
        catch (QueryException $e){
           $error_code = $e->errorInfo[1];
            if($error_code == 1062){
                 flash('Some error is there kindly recheck!')->error();
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
        $update = new Update;
        $this->authorize('create', $update);
        Update::where('id',$id)->first()->delete();
        flash('Update Successfully deleted!')->success();
        return redirect()->route('update.index');
    }
}
