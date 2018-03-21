<?php

namespace PacketPrep\Http\Controllers\System;

use Illuminate\Http\Request;
use PacketPrep\Http\Controllers\Controller;
use PacketPrep\Models\System\Finance;

class FinanceController extends Controller
{
      /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request,Finance $finance)
    {
        $this->authorize('view', $finance);
        $search = $request->search;
        $item = $request->item;
        if(!$request->year){
            if(\Carbon\Carbon::now()->month<4)  
            $year = \Carbon\Carbon::now()->year-1;
            else
            $year = \Carbon\Carbon::now()->year;
        }else
        $year = '20'.$request->year;

        $month = $request->month;
        $quater = $request->quater;
        if($year && $quater==0 && $month ==0){
            $start = $year.'-04-01';
            $end = ($year+1).'-04-01';
        }elseif( $year && $quater && $month == 0 ){
            if($quater==1){
                $start_month = 4;
                $end_month = 6;
            }elseif($quater==2){   
                $start_month = 7;
                $end_month = 9;
            }elseif($quater==3){
                $start_month = 10;
                $end_month = 12;
            }else{
                $start_month = 1;
                $end_month = 3;
                $year=$year+1;
            }

            $start = $year.'-'.$start_month.'-01';
            $end = $year.'-'.$end_month.'-31';

        }
        elseif($year && $quater==0 && $month){

            if($month==1 ||$month==2 || $month==3)
                $year = $year+1;

            $start = $year.'-'.$month.'-01';
            $end = $year.'-'.$month.'-31';  

        }elseif($year && $quater && $month){
            return redirect()->route('finance.index',['year'=>$request->year,'month'=>$month]);

        }
        else{
            $start=$end=null;
        }

        $finances = $finance->getRecords($start,$end);            

        $finances->cashin = $finance->cash('IN',$start,$end);  
        $finances->cashout = $finance->cash('OUT',$start,$end);  
        if(\Carbon\Carbon::now()->month<4)  
            $finances->curr_year = substr(\Carbon\Carbon::now()->year, 2)-1;
        else
        $finances->curr_year = substr(\Carbon\Carbon::now()->year, 2);
        
        $view = $search ? 'list': 'index';
        return view('appl.system.finance.'.$view)
            ->with('finance',$finance)
            ->with('finances',$finances);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Finance $finance)
    {
         $this->authorize('create', $finance);
        return view('appl.system.finance.createedit')
                ->with('finance',$finance)
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
            $finance = new Finance;
            $finance->user_id = $request->user_id;
            $finance->content = $request->content;
            $finance->amount = $request->amount;
            $finance->flow = $request->flow;
            $finance->year = $request->year;
            $finance->save();

            flash('A new finance entry is created!')->success();
            return redirect()->route('finance.index');
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
        return redirect()->route('finance.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $finance = Finance::where('id',$id)->first();
        $this->authorize('edit', $finance);
        if($finance)
            return view('appl.system.finance.createedit')
                    ->with('finance',$finance)
                    ->with('stub','Update');
        else
            abort(404);
    }

    /**
     * Finance the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try{
            $finance = Finance::where('id',$id)->first();
            $finance->user_id = $request->user_id;
            $finance->content = $request->content;
            $finance->amount = $request->amount;
            $finance->flow = $request->flow;
            $finance->year = $request->year;
            $finance->save();

            flash('Finance (<b>id '.$id.'</b>) Successfully Financed!')->success();
            return redirect()->route('finance.index');
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
        $finance = new Finance;
        $this->authorize('create', $finance);
        Finance::where('id',$id)->first()->delete();
        flash('Finance Successfully deleted!')->success();
        return redirect()->route('finance.index');
    }
}
