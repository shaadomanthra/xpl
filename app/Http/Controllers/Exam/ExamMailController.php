<?php

namespace PacketPrep\Http\Controllers\Exam;

use Illuminate\Http\Request;
use PacketPrep\Http\Controllers\Controller;

class ExamMailController extends Controller
{
    //

    public function __construct(){
        $this->app      =   'exam';
        $this->module   =   'exam';
        $this->cache_path =  '../storage/app/cache/exams/';
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Exam $exam,Request $request)
    {
        $this->authorize('view', $exam);

        $search = $request->search;
        $item = $request->item;

        if($request->get('refresh')){
            $objs = $exam->orderBy('created_at','desc')
                        ->get();

            foreach($objs as $obj){
                //$filename = $obj->slug.'.json';
                //$filepath = $this->cache_path.$filename;
                $obj->sections = $obj->sections;
                $obj->products = $obj->products;
                $obj->product_ids = $obj->products->pluck('id')->toArray();
                foreach($obj->sections as $m=>$section){
                    $obj->sections->questions = $section->questions;
                    foreach($obj->sections->questions as $k=>$question){
                       $obj->sections->questions[$k]->passage = $question->passage;
                    }

                }
                //update redis cache
                $obj->updateCache();

                //file_put_contents($filepath, json_encode($obj,JSON_PRETTY_PRINT));

            }

            flash('Exams Cache Updated')->success();
        }

        if(\auth::user()->isAdmin())
        $exams = $exam->where('name','LIKE',"%{$item}%")->orderBy('created_at','desc ')->withCount('users')->with('user')->paginate(config('global.no_of_records'));
        else
        $exams = $exam->where('user_id',\auth::user()->id)->where('name','LIKE',"%{$item}%")->with('user')->withCount('users')->orderBy('created_at','desc ')->paginate(config('global.no_of_records'));



        $view = $search ? 'list': 'index';

        return view('appl.exam.exam.'.$view)
        ->with('exams',$exams)->with('exam',$exam);
    }
}
