<?php

namespace PacketPrep\Http\Controllers\System;

use Illuminate\Http\Request;
use PacketPrep\Http\Controllers\Controller;
use PacketPrep\Models\System\Report;
use Carbon\Carbon;

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
        

        $reports =  $report->getReports();
         
        
        return view('appl.system.report.index')
            ->with('report',$report)
            ->with('reports',$reports);
    }


    public function  week(Report $report){

        $this->authorize('view', $report);
        if(\Auth::guest())
            return redirect('login');
        
        $today = Carbon::today();
        $reports =  $report->where('created_at', '>', $today->subDays(7))->orderBy('created_at','desc ')
                        ->get()->groupBy(function($date) {
                            return Carbon::parse($date->created_at)->format('d'); // grouping by years
                            //return Carbon::parse($date->created_at)->format('m'); // grouping by months
                        });
         
    
        
        return view('appl.system.report.week')
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
            $report->content = ($request->content)? summernote_imageupload(\auth::user(),$request->content):' ';
            $report->save();

            flash('A new Report('.$request->id.') is created!')->success();
            return redirect()->route('report.week');
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
            $report->content = ($request->content)? summernote_imageupload(\auth::user(),$request->content):' ';
            $report->save();

            flash('Report (<b>id '.$report->id.'</b>) Successfully updated!')->success();
            return redirect()->route('report.week');
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
        $report = Report::where('id',$id)->first();
        $this->authorize('create', $report);
        $report->content = summernote_imageremove($report->content);
        $report->delete();
        flash('Report Successfully deleted!')->success();
        return redirect()->route('report.index');
    }
}
