<?php

namespace PacketPrep\Http\Controllers\System;

use Illuminate\Http\Request;
use PacketPrep\Http\Controllers\Controller;
use PacketPrep\Models\System\Report;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Report $report)
    {
        $this->authorize('view', $report);

        if(\Auth::guest())
            return redirect('login');
        
        $reports = $report->orderBy('created_at','desc ')
                    ->paginate(config('global.no_of_records'));
        
        return view('appl.system.report.index')
            ->with('report',$report)
            ->with('reports',$reports);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Report $report)
    {
        $this->authorize('create', $report);
        return view('appl.system.report.createedit')
                ->with('report',$report)
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
            $report = new Report;
            $report->user_id = $request->user_id;
            $report->type= $request->type;
            $report->content = ($request->content)?$request->content:' ';
            $report->save();

            flash('A new Report('.$request->id.') is created!')->success();
            return redirect()->route('report.index');
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
        return redirect()->route('report.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $report = Report::where('id',$id)->first();
        $this->authorize('edit', $report);
        if($report)
            return view('appl.system.report.createedit')
                    ->with('report',$report)
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
            $report = Report::where('id',$id)->first();
            $report->user_id = $request->user_id;
            $report->type= $request->type;
            $report->content = ($request->content)?$request->content:' ';
            $report->save();

            flash('Report (<b>id '.$report->id.'</b>) Successfully updated!')->success();
            return redirect()->route('report.index');
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
        $report = new Report;
        $this->authorize('create', $report);
        Report::where('id',$id)->first()->delete();
        flash('Report Successfully deleted!')->success();
        return redirect()->route('report.index');
    }
}
