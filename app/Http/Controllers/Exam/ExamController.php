<?php

namespace PacketPrep\Http\Controllers\Exam;

use Illuminate\Http\Request;
use PacketPrep\Http\Controllers\Controller;
use PacketPrep\Models\Exam\Exam;
use PacketPrep\Models\Exam\Section;
use PacketPrep\Models\Exam\Examtype;

class ExamController extends Controller
{
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
        
        $exams = $exam->where('name','LIKE',"%{$item}%")->orderBy('created_at','desc ')->paginate(config('global.no_of_records'));   
        $view = $search ? 'list': 'index';

        return view('appl.exam.exam.'.$view)
        ->with('exams',$exams)->with('exam',$exam);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $exam = new Exam();
        $examtypes = Examtype::all();
        $this->authorize('create', $exam);


        return view('appl.exam.exam.createedit')
                ->with('stub','Create')
                ->with('jqueryui',true)
                ->with('editor',true)
                ->with('exam',$exam)->with('examtypes',$examtypes);
    }


    public function createExam()
    {
       for($i=4;$i<11;$i++){
            $this->createExamLoop($i);
       }
    }

    public function createExamLoop($n)
    {
        //create exam
        $exam = new Exam();
        $exam->name = 'Cocubes Aptitude Practice Test #'.$n;
        $exam->slug = 'cocubes-aptitude-'.$n;
        $exam->user_id = \auth::user()->id;
        $exam->instructions = '<ul ><li>This test contains 45 questions to be answered in 45 minutes</li><li>For every question there are either four options A,B,C,D or five options A,B,C,D,E out of which only one option is correct</li><li>Each question carries 1 mark and there is no negative marking</li></ul>';
        $exam->status = 2;
        $exam->examtype_id = 6;//general
        $e = Exam::where('slug',$exam->slug)->first();

        if(!$e)
            $exam->save();
        else
            $exam =$e;


        $sections = ['General English','Analytical Reasoning','Numerical Reasoning'];
        //create sections
        foreach($sections as $s){
            $section = new Section();
            $section->exam_id = $exam->id;
            $section->name = $s;
            $section->mark = 1;
            $section->user_id = \auth::user()->id;
            $section->negative =0;
            $section->time = 15;
            $c = Section::where('name',$section->name)->where('exam_id',$exam->id)->first();
            if(!$c)
            $section->save();

        }

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Exam $exam,Request $request)
    {
        try{

            if(!$request->slug )
            $request->slug  = $request->name;
            $request->slug = strtolower(str_replace(' ', '-', $request->slug));

            $exam->name = $request->name;
            $exam->slug = $request->slug;
            $exam->user_id = $request->user_id;
            $exam->examtype_id = $request->examtype_id;
            $exam->description = ($request->description) ? $request->description: null;
            $exam->instructions = ($request->instructions) ? $request->instructions : null;
            $exam->status = $request->status;
            $exam->save(); 

            flash('A new exam('.$request->name.') is created!')->success();
            return redirect()->route('exam.index');
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
    public function show($id)
    {
        $exam= Exam::where('slug',$id)->first();

        
        $this->authorize('view', $exam);

        if($exam)
            return view('appl.exam.exam.show')
                    ->with('exam',$exam);
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
        $exam= Exam::where('slug',$id)->first();
        $examtypes = Examtype::all();
        $this->authorize('update', $exam);


        if($exam)
            return view('appl.exam.exam.createedit')
                ->with('stub','Update')
                ->with('jqueryui',true)
                ->with('editor',true)
                ->with('examtypes',$examtypes)
                ->with('exam',$exam);
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
    public function update(Request $request, $slug)
    {
        try{
            $exam = Exam::where('slug',$slug)->first();

            $this->authorize('update', $exam);

            $exam->name = $request->name;
            $exam->slug = $request->slug;
            $exam->user_id = $request->user_id;
            $exam->examtype_id = $request->examtype_id;
            $exam->description = ($request->description) ? $request->description: null;
            $exam->instructions = ($request->instructions) ? $request->instructions : null;
            $exam->status = $request->status;
            $exam->save(); 

            flash('Exam (<b>'.$request->name.'</b>) Successfully updated!')->success();
            return redirect()->route('exam.show',$request->slug);
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
    public function destroy($id)
    {
        $exam = Exam::where('id',$id)->first();
        $this->authorize('update', $exam);

        
        $exam->delete();

        flash('Exam Successfully deleted!')->success();
        return redirect()->route('exam.index');
    }
}
