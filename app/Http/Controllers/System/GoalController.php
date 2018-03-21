<?php

namespace PacketPrep\Http\Controllers\System;

use Illuminate\Http\Request;
use PacketPrep\Http\Controllers\Controller;
use PacketPrep\Models\System\Goal;

class GoalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Goal $goal)
    {
        $this->authorize('view', $goal);

        if(\Auth::guest())
            return redirect('login');
        
        $goals = $goal->orderBy('created_at','desc ')
                    ->paginate(config('global.no_of_records'));
        
        return view('appl.system.goal.index')
            ->with('goal',$goal)
            ->with('goals',$goals);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Goal $goal)
    {
        $this->authorize('create', $goal);
        return view('appl.system.goal.createedit')
                ->with('goal',$goal)
                ->with('jqueryui',true)
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

        if(!$request->title || !$request->end_at){
            flash('Tile and End date cannot be blank')->error();
            return redirect()->back()->withInput();;
        }
        try{
            $goal = new Goal;
            $goal->user_id = $request->user_id;
            $goal->title = $request->title;
            $goal->content = ($request->content)?$request->content:' ';
            $goal->endnote = ($request->endnote)?$request->endnote:' ';
            $goal->prime = $request->prime;
            $goal->status = $request->status;
            $goal->end_at = $request->end_at;
            $goal->save();

            flash('A new goal('.$request->title.') is created!')->success();
            return redirect()->route('goal.index');
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
        return redirect()->route('goal.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $goal = Goal::where('id',$id)->first();
        $this->authorize('edit', $goal);
        if($goal)
            return view('appl.system.goal.createedit')
                    ->with('goal',$goal)
                    ->with('jqueryui',true)
                    ->with('stub','Update');
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
            $goal = Goal::where('id',$id)->first();
            $goal->user_id = $request->user_id;
            $goal->title = $request->title;
            $goal->content = ($request->content)?$request->content:' ';
            $goal->endnote = ($request->endnote)?$request->endnote:' ';
            $goal->prime = $request->prime;
            $goal->status = $request->status;
            $goal->end_at = $request->end_at;
            $goal->save();

            flash('Goal (<b>id '.$goal->title.'</b>) Successfully updated!')->success();
            return redirect()->route('goal.index');
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
        $goal = new Goal;
        $this->authorize('create', $goal);
        Goal::where('id',$id)->first()->delete();
        flash('Goal Successfully deleted!')->success();
        return redirect()->route('goal.index');
    }
}
