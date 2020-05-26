<?php

namespace PacketPrep\Http\Controllers\Exam;

use Illuminate\Http\Request;
use PacketPrep\Http\Controllers\Controller;
use PacketPrep\Models\Exam\Exam;
use PacketPrep\Models\Exam\Section;

class SectionController extends Controller
{
     public function __construct(){
        $this->cache_path =  '../storage/app/cache/exams/';
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index( $exam, Section $section,Request $request)
    {

        $this->authorize('view', $section);

        $exam = Exam::where('slug',$exam)->first();

        $search = $request->search;
        $item = $request->item;
        $sections = $section->where('name','LIKE',"%{$item}%")->where('exam_id',$exam->id)->orderBy('created_at','desc ')->paginate(config('global.no_of_records'));
        $view = $search ? 'list': 'index';

        return view('appl.exam.section.'.$view)
        ->with('sections',$sections)->with('exam',$exam);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($exam)
    {
        $section = new Section();
        $this->authorize('create', $section);
        $exam = Exam::where('slug',$exam)->first();

        return view('appl.exam.section.createedit')
                ->with('stub','Create')
                ->with('jqueryui',true)
                ->with('section',$section)
                ->with('exam',$exam);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store($exam, Section $section, Request $request)
    {
        try{
            $exam = Exam::where('slug',$exam)->first();
            $section->name = $request->name;
            $section->user_id = $request->user_id;
            $section->exam_id = $exam->id;
            $section->instructions = ($request->instructions) ? $request->instructions : null;
            $section->mark = $request->mark;
            $section->negative = $request->negative;
            $section->time = $request->time;
            $section->save(); 

            //update cache
            $obj = $exam;
                $filename = $obj->slug.'.json';
                $filepath = $this->cache_path.$filename;
                $obj->sections = $obj->sections;
                $obj->products = $obj->products;
                $obj->product_ids = $obj->products->pluck('id')->toArray();
                foreach($obj->sections as $m=>$section){
                    $obj->sections->questions = $section->questions;
                    foreach($obj->sections->questions as $k=>$question){
                       $obj->sections->questions[$k]->passage = $question->passage; 
                    }
                }
                
                file_put_contents($filepath, json_encode($obj,JSON_PRETTY_PRINT));
            
           


            flash('A new section('.$request->name.') is created!')->success();
            return redirect()->route('sections.index',$exam->slug);
        }
        catch (QueryException $e){
           $error_code = $e->errorInfo[1];
            if($error_code == 1062){
                flash('The slug(<b>'.$request->slug.'</b>) is already taken. Kindly use a different slug.')->error();
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
    public function show($exam,$id)
    {
        $exam= Exam::where('slug',$exam)->first();
        $section= Section::where('id',$id)->first();
        
        $this->authorize('view', $section);

        if($exam)
            return view('appl.exam.section.show')
                    ->with('exam',$exam)->with('section',$section);
        else
            abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($exam,$id)
    {
        $exam= Exam::where('slug',$exam)->first();
        $section= Section::where('id',$id)->first();
        $this->authorize('edit', $section);

        if($section)
            return view('appl.exam.section.createedit')
                ->with('stub','Update')
                ->with('jqueryui',true)
                ->with('exam',$exam)
                ->with('section',$section);
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
    public function update($exam, Request $request, $id)
    {
        try{
            $exam= Exam::where('slug',$exam)->first();
            $section= Section::where('id',$id)->first();

            $this->authorize('update', $section);

            $section->name = $request->name;
            $section->user_id = $request->user_id;
            $section->exam_id = $exam->id;
            $section->instructions = ($request->instructions) ? $request->instructions : null;
            $section->mark = $request->mark;
            $section->negative = $request->negative;
            $section->time = $request->time;
            $section->save(); 

            //update cache
            $obj = $exam;
                $filename = $obj->slug.'.json';
                $filepath = $this->cache_path.$filename;
                $obj->sections = $obj->sections;
                $obj->products = $obj->products;
                $obj->product_ids = $obj->products->pluck('id')->toArray();
                foreach($obj->sections as $m=>$section){
                    $obj->sections->questions = $section->questions;
                    foreach($obj->sections->questions as $k=>$question){
                       $obj->sections->questions[$k]->passage = $question->passage; 
                    }
                }
                
                file_put_contents($filepath, json_encode($obj,JSON_PRETTY_PRINT));
            
           

            flash('Section (<b>'.$request->name.'</b>) Successfully updated!')->success();
            return redirect()->route('sections.show',[$exam->slug,$id]);
        }
        catch (QueryException $e){
           $error_code = $e->errorInfo[1];
            if($error_code == 1062){
                flash('The slug(<b>'.$request->slug.'</b>) is already taken. Kindly use a different slug.')->error();
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
    public function destroy($exam,$id)
    {
        $exam= Exam::where('slug',$exam)->first();
        $section= Section::where('id',$id)->first();
        $section->questions()->detach();
        $this->authorize('update', $section);

        $section->delete();
        flash('Section Successfully deleted!')->success();
        return redirect()->route('sections.index',$exam->slug);
    }
}
