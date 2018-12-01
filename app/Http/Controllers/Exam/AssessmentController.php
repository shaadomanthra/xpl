<?php

namespace PacketPrep\Http\Controllers\Exam;

use Illuminate\Http\Request;
use PacketPrep\Http\Controllers\Controller;
use PacketPrep\Models\Dataentry\Tag;
use PacketPrep\Models\Product\Client;
use PacketPrep\Models\Dataentry\Question;
use PacketPrep\Models\Dataentry\Passage;
use PacketPrep\Models\Exam\Exam;
use PacketPrep\Models\Exam\Examtype;
use PacketPrep\Models\Product\Test;
use PacketPrep\User;

class AssessmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Exam $exam, Request $request)
    {

        if(\auth::user())
            $user = \auth::user();
        else
            $user = User::where('username','krishnateja')->first();

        $examtypes = Examtype::all();

        $filter = $request->get('filter');
        $search = $request->search;
        $item = $request->item;

        if($filter){
            $examtype = Examtype::where('slug',$filter)->first();
            $exams = $exam->where('name','LIKE',"%{$item}%")->where('examtype_id',$examtype->id)->orderBy('created_at','desc ')->paginate(config('global.no_of_records'));
        }
        else
            $exams = $exam->where('name','LIKE',"%{$item}%")->paginate(config('global.no_of_records'));

        
        

        $view = $search ? 'list': 'index';

        return view('appl.exam.assessment.'.$view)
            ->with('exams',$exams)->with('exam',$exam)->with('examtypes',$examtypes);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function instructions($test)
    {
        $exam = Exam::where('slug',$test)->first();
        return view('appl.exam.assessment.instructions')
                ->with('exam',$exam);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function try($test,$id=null, Request $request)
    {
        $exam = Exam::where('slug',$test)->first();

        $completed = 0;

        if($id==null){
            $view ='questions';
            if(count($exam->sections)!=0)
            foreach($exam->sections as $section){
                if(count($section->questions)!=0)
                foreach($section->questions as $question)
                {
                    $id = $question->id;
                    break; 
                }else
                    $id = null;
                break;
            }else
                $id = null;
        }else
            $view = 'q';
        


        if($id){
            $question = Question::where('id',$id)->first();


            if($question){
            
                $passage = Passage::where('id',$question->passage_id)->first();
                
                $questions = array();
                $sections = array();
                $i= 0;$time = 0;
                foreach($exam->sections as $section){
                    foreach($section->questions as $q){
                        $questions[$i] = $q;
                        $sections[$i] = $section;
                        $i++;
                    }

                    $time = $time + $section->time;
                }

                $details = ['curr'=>null,'prev'=>null,'next'=>null,'qno'=>null,'display_type'=>'tag']; 

                $test = Test::where('question_id',$id)->where('test_id',$exam->id)->where('user_id',\auth::user()->id)->first();
                if($test){
                    $details['response'] = $test->response;
                }else{
                    $details['response'] = null;
                }


              
                $details['curr'] = $question->id;
                
                $tests = ['test1','test2','test3','test4','test5'];
                foreach($questions as $key=>$q){

                    if($q->id == $question->id){

                        if($key!=0)
                            $details['prev'] = $questions[$key-1]->id;

                        if(count($questions) != $key+1)
                            $details['next'] = $questions[$key+1]->id;

                        $details['qno'] = $key + 1 ;
                    }

                    $details['q'.$q->id] = null;

                    $t = Test::where('question_id',$q->id)->where('test_id',$exam->id)->where('user_id',\auth::user()->id)->first();
                    if(!$t){
                        $t= new Test();

                        $t->question_id = $q->id;
                        $t->test_id = $exam->id;
                        $t->user_id = \auth::user()->id;
                        $t->section_id= $sections[$key]->id;
                        $t->response = null;
                        $t->answer = strtoupper($q->answer);
                        $t->accuracy=0;
                        $t->time=0;
                        $t->save();
                    }else{
                        if($t->status != 1){
                        if ((strtotime("now") - strtotime($t->created_at)) > 3600){
                            $t->status =1;
                            $t->save();
                            $completed = 1;
                        }else{
                            if($t->response)
                            $details['q'.$q->id] = true;

                        }
                        }else{
                            $completed = 1;
                        }

                    }

                } 



                if($completed)
                    return redirect()->route('assessment.analysis',$exam->slug);
                else
                return view('appl.exam.assessment.'.$view)
                        ->with('mathjax',true)
                        ->with('question',$question)
                        ->with('passage',$passage)
                        ->with('details',$details)
                        ->with('exam',$exam)
                        ->with('timer',true)
                        ->with('time',$time)
                        ->with('questions',$questions);
            }else
                abort('404','Question not found');
            
        }
        else
            abort(403);
    }

    public function solutions($slug,$id=null,Request $request)
    {

        $exam = Exam::where('slug',$slug)->first();
         

        if($id==null){
            $view ='questions';
            if(count($exam->sections)!=0)
            foreach($exam->sections as $section){
                if(count($section->questions)!=0)
                foreach($section->questions as $question)
                {
                    $id = $question->id;
                    break; 
                }else
                    $id = null;
                break;
            }else
                $id = null;
        }else
            $view = 'q';
        


        if($id){
            $question = Question::where('id',$id)->first();


            if($question){
            
                $passage = Passage::where('id',$question->passage_id)->first();
                
                $questions = array();
                $i=0;
                foreach($exam->sections as $section){
                    foreach($section->questions as $q){
                        $questions[$i] = $q;
                        $i++;
                    }
                }

                $details = ['curr'=>null,'prev'=>null,'next'=>null,'qno'=>null,'display_type'=>'tag']; 

                $test = Test::where('question_id',$id)->where('user_id',\auth::user()->id)->first();
                if($test){
                    $details['response'] = $test->response;
                    $details['accuracy'] = $test->accuracy;
                }else{
                    $details['response'] = null;
                }


                
            
                $details['curr'] = route('assessment.solutions.q',[$exam->slug,$question->id]);
                
                $tests = ['test1','test2','test3','test4','test5'];
                $questions = Test::where('test_id',$exam->id)->where('user_id',\auth::user()->id)->get();
                foreach($questions as $key=>$q){

                    if($q->question_id == $question->id){

                        if($key!=0)
                            $details['prev'] = route('assessment.solutions.q',[$exam->slug,$questions[$key-1]->question_id]);

                        if(count($questions) != $key+1)
                            $details['next'] = route('assessment.solutions.q',[$exam->slug,$questions[$key+1]->question_id]);

                        $details['qno'] = $key + 1 ;
                    }

                    $details['q'.$q->id] = null;

                   

                } 

                

                return view('appl.exam.assessment.solutions')
                        ->with('mathjax',true)
                        ->with('question',$question)
                        ->with('passage',$passage)
                        ->with('details',$details)
                        ->with('exam',$exam)
                        ->with('tests',$tests)
                        ->with('questions',$questions);
            }else
                abort('404','Question not found');
            
        }
        else
            abort(403);
    }

    public function save($slug,$id,Request $request)
    {

        $exam = Exam::where('slug',$slug)->first();
        $question = Question::where('id',$id)->first();

        $test = Test::where('question_id',$id)->where('test_id',$exam->id)
                ->where('user_id',$request->get('user_id'))->first();
        if(!$test)
        $test = new Test();

        $test->question_id = $request->get('question_id');
        $test->test_id = $exam->id;
        $test->user_id = $request->get('user_id');
        if($request->get('response'))
        $test->response = strtoupper($request->get('response'));
        $test->answer = strtoupper($question->answer);
        if($request->get('time'))
        $test->time = $test->time+$request->get('time');

        if($test->response == $test->answer)
            $test->accuracy =1;
        else
            $test->accuracy=0;

        $test->save();

    }


    public function clear($slug,$id,Request $request)
    {

        $exam = Exam::where('slug',$slug)->first();
        $question = Question::where('id',$id)->first();

        $test = Test::where('question_id',$id)->where('test_id',$exam->id)
                ->where('user_id',$request->get('user_id'))->first();
        if(!$test)
        $test = new Test();

        $test->question_id = $request->get('question_id');
        $test->test_id = $exam->id;
        $test->user_id = $request->get('user_id');
        $test->time = $test->time+$request->get('time');
        $test->response = strtoupper($request->get('response'));
        $test->answer = strtoupper($question->answer);
        $test->accuracy=0;

        $test->save();

    }

    public function submit($slug,Request $request)
    {


        $exam = Exam::where('slug',$slug)->first();
        
        
        $questions = array();
        $i=0;
        foreach($exam->sections as $section){
            foreach($section->questions as $q){
                $questions[$i] = $q;
                    $i++;
            }
        }

        foreach($questions as $key=>$q){
            $t = Test::where('question_id',$q->id)->where('user_id',\auth::user()->id)->first();
            $t->status =1;
            $t->save();
        } 

        return redirect()->route('assessment.analysis',$slug);

    }

    public function analysis($slug,Request $request)
    {

        $exam = Exam::where('slug',$slug)->first();

        $questions = array();
        $i=0;
        foreach($exam->sections as $section){
            foreach($section->questions as $q){
                $questions[$i] = $q;
                    $i++;
            }
        }
        
        $details = ['correct'=>0,'incorrect'=>'0','unattempted'=>0,'attempted'=>0,'avgpace'=>'0','testdate'=>null,'marks'=>0,'total'=>0];
        $details['course'] = $exam->name;
        $sum = 0;
        $c=0; $i=0; $u=0;

        $tests = Test::where('test_id',$exam->id)
                        ->where('user_id',\auth::user()->id)->get();

        foreach($tests as $key=>$t){

            //dd($t->section->negative);
            if(isset($t)){
                $sum = $sum + $t->time;
                $details['testdate'] = $t->created_at->diffForHumans();
            }
            
            //$ques = Question::where('id',$q->id)->first();
            if($t->response){
                $details['attempted'] = $details['attempted'] + 1;  
                if($t->accuracy==1){
                    $details['c'][$c] = $t->question->categories->where('parent_id','<>','307')->first();
                    $c++;
                    $details['correct'] = $details['correct'] + 1;
                    $details['marks'] = $details['marks'] + $t->section->mark;
                }
                else{
                    $details['i'][$i] = $t->question->categories->where('parent_id','<>','307')->first();
                    $i++;
                    $details['incorrect'] = $details['incorrect'] + 1; 
                    $details['marks'] = $details['marks'] - $t->section->negative; 
                }

                
            }else{
                $details['u'][$u] = $q->categories->where('parent_id','<>','307')->first();
                    $u++;
                $details['unattempted'] = $details['unattempted'] + 1;  
            }

            $details['total'] = $details['total'] + $t->section->mark;

        } 
        $success_rate = $details['correct']/count($questions);
        if($success_rate > 0.9)
            $details['performance'] = 'Excellent';
        elseif(0.7 < $success_rate && $success_rate < 0.9)
            $details['performance'] = 'Good';
        elseif(0.4 < $success_rate && $success_rate < 0.7)
            $details['performance'] = 'Average';
        else
            $details['performance'] = 'Need to Improve';

        $details['avgpace'] = round($sum / count($questions),2);
        
        
        

        return view('appl.exam.assessment.analysis')
                        ->with('exam',$exam)
                        ->with('details',$details)
                        ->with('chart',true);

    }


    public function main(Request $request)
    {
        $tests = ['test1'=>null,'test2'=>null,'test3'=>null,'test4'=>null,'test5'=>null];

        if(\auth::user())
            $user = \auth::user();
        else
            $user = User::where('username','krishnateja')->first();

        foreach($tests as $test => $val){
                $tag = Tag::where('value',$test)->first();
                $questions = $tag->questions;
                    

                if(count($questions)==0)
                    $tests[$test.'_count'] = 0;
                else
                    $tests[$test.'_count'] = count($questions);

                foreach($questions as $key=>$q){
                    if($q){
                        
                        $t = Test::where('question_id',$q->id)->where('user_id',$user->id)->first();

                        if($t && \auth::user())
                            {
                                $tests[$test] = true;
                                break;
                            }else{
                                $tests[$test] = false;
                                break;
                            }
                        
                    }
                    
                } 

            }


        if(!\auth::user()){
            return view('appl.product.test.onlinetest')->with('tests',$tests);
        }else{

            return view('appl.product.test.onlinetest')->with('tests',$tests);
        }

    }
}
