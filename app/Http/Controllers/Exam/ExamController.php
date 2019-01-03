<?php

namespace PacketPrep\Http\Controllers\Exam;

use Illuminate\Http\Request;
use PacketPrep\Http\Controllers\Controller;
use PacketPrep\Models\Exam\Exam;
use PacketPrep\Models\Exam\Section;
use PacketPrep\Models\Exam\Examtype;
use PacketPrep\Models\Dataentry\Category;
use PacketPrep\Models\Dataentry\Question;

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
        
        $examtypes = Examtype::all();
       /* 
       for($i=1;$i<4;$i++){
            $this->createExamLoop($i);
       }*/

       // Quantitative Aptitude
       return view('appl.exam.exam.createexam')
                ->with('stub','Create')
                ->with('jqueryui',true)
                ->with('editor',true)->with('examtypes',$examtypes);
       

    }

    public function storeExam(Request $request)
    {
        
       for($i=$request->get('l_start');$i<$request->get('l_end');$i++){
            $this->createExamLoop($request,$i);
       }

       return view('appl.exam.exam.message');
    }



    public function get_questions($slug){

       $result = array();
       $ques= array();
       $k=0;
       $category = Category::where('slug',$slug)->first();
       $siblings = $category->descendants()->withDepth()->having('depth', '=', 1)->get();


       if($slug == 'general-english' )
       foreach($siblings as $s){
            $inner = $s->descendants()->get();

            $result[$s->name] = $s->questions->pluck('id')->toArray();
                if(count($result[$s->name])!=0){
                   $id = array_rand($result[$s->name],1);
                   $ques[++$k] = $result[$s->name][$id]; 
                }
       }

       if($slug == 'logical-reasoning' || $slug == 'mental-ability')
       foreach($siblings as $s){
            $inner = $s->descendants()->get();

            $result[$s->name] = array();
            foreach($inner as $in){
                $result[$in->name] = $in->questions->pluck('id')->toArray();

                if(count($result[$in->name])!=0){
                   $id = array_rand($result[$in->name],1);
                   $ques[++$k] = $result[$in->name][$id]; 
                }
            }
       }

       if($slug == 'quantitative-aptitude' )
       foreach($siblings as $s){
            $inner = $s->descendants()->get();

            $result[$s->name] = array();
            foreach($inner as $in){

                $result[$s->name] = array_merge($result[$s->name] , $in->questions->pluck('id')->toArray());
            }

            if(count($result[$s->name])!=0){
               $id = array_rand($result[$s->name],1);
               $ques[++$k] = $result[$s->name][$id]; 
            }
            
       }

       foreach($ques as $id => $q){

            $q = Question::find($q);
            if($q->type !='mcq'){
                unset($ques[$id]);
            }
          
       }

       return $ques;
    }

    public function createExamLoop($request,$n)
    {
        //create exam
        $exam = new Exam();
        $exam->name = $request->name.$n;
        $exam->slug = $request->slug.$n;
        $exam->user_id = \auth::user()->id;
        $exam->instructions = $request->instructions;
        $exam->status = $request->status;
        $exam->examtype_id = $request->examtype_id;//general
        $count = 15;
        $e = Exam::where('slug',$exam->slug)->first();

        if(!$e)
            $exam->save();
        else
            $exam =$e;


        //create sections
        for($k=1;$k<5;$k++){

            if($request->get('sec_'.$k)){
                $section = new Section();
                $section->exam_id = $exam->id;
                $section->name = $request->get('sec_'.$k);
                $section->mark = $request->get('sec_mark_'.$k);
                $section->user_id = \auth::user()->id;
                $section->negative = $request->get('sec_negative_'.$k);
                $section->time = $request->get('sec_time_'.$k);

                $c = Section::where('name',$section->name)->where('exam_id',$exam->id)->first();
                if(!$c){
                    $section->save();
                    $c = Section::where('name',$section->name)->where('exam_id',$exam->id)->first();
                }

                if(count($c->questions) ==0 )
                {

                   $topic = $request->get('sec_slug_'.$k);
                   $count = $request->get('sec_count_'.$k);
                    // questions connect
                   $ques_set = array();
               
                   $ques = $this->get_questions($topic);
                   if(count($ques) < $count)
                   {
                        while(1){
                         $ques = array_merge($ques,$this->get_questions($topic));
                         if(count($ques) > $count)
                            break;
                        }
                   }

                   $i =0;
                   foreach($ques as $q){
                        $ques_set[$i] = $q;

                        if($i == ($count - 1) )
                            break;
                        $i++;

                   }
                  
                   foreach($ques_set as $i => $q){
                        $question = Question::where('id',$q)->first();
                        if(!$question->sections->contains($c->id))
                            $question->sections()->attach($c->id);
                   }

                }
            }
            
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
