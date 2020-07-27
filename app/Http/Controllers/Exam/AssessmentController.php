<?php

namespace PacketPrep\Http\Controllers\Exam;

use Illuminate\Http\Request;
use PacketPrep\Http\Controllers\Controller;
use PacketPrep\Models\Dataentry\Tag;
use PacketPrep\Models\Product\Client;
use PacketPrep\Models\Dataentry\Question;
use PacketPrep\Models\Dataentry\Passage;
use PacketPrep\Models\Exam\Exam;
use PacketPrep\Models\Exam\Section;
use PacketPrep\Models\Exam\Examtype;
use PacketPrep\Models\Product\Test;
use PacketPrep\Models\Exam\Tests_Overall;
use PacketPrep\Models\Exam\Tests_Section;
use PacketPrep\Jobs\ProcessAttempts;

use PacketPrep\Models\Product\Product;
use PacketPrep\Models\Product\Order;
use PacketPrep\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Cache;
use Log;


class AssessmentController extends Controller
{

    public function __construct(){
        $this->app      =   'exam';
        $this->module   =   'exam';
        $this->cache_path =  '../storage/app/cache/exams/';
    }

    public function certificate($exam,$user,Request $request)
    {

        $user = User::where('username',$user)->first();
        $exam = Exam::where('slug',$exam)->first();
        $date = Test::where('test_id',$exam->id)
                        ->where('user_id',$user->id)->first()->created_at;
                        
        return view('appl.exam.assessment.certificate')->with('date',$date)->with('user',$user)->with('exam',$exam);

    }

    public function certificate_sample(Request $request)
    {

        $user = User::where('username','shaadomanthra_xPk3N')->first();
        $user->name = 'ROBINHOOD';
        $exam = Exam::where('slug','proficiency-test')->first();

        $date = Test::where('test_id',$exam->id)
                        ->where('user_id',$user->id)->first()->created_at;
                        
        return view('appl.exam.assessment.certificate')->with('date',$date)->with('user',$user)->with('exam',$exam);

    }

    public function report($exam,$user,Request $request)
    {

        $user = User::where('username',$user)->first();
        $exam = Exam::where('slug',$exam)->first();

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
                        ->where('user_id',$user->id)->get();

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
                    $details['c'][$c]['category'] = $t->question->categories->first();
                    $details['c'][$c]['question'] = $t->question;
                    $c++;
                    $details['correct'] = $details['correct'] + 1;
                    $details['marks'] = $details['marks'] + $t->section->mark;
                }
                else{
                    $details['i'][$i]['category'] = $t->question->categories->first();
                    $details['i'][$i]['question'] = $t->question;
                    $i++;
                    $details['incorrect'] = $details['incorrect'] + 1; 
                    $details['marks'] = $details['marks'] - $t->section->negative; 
                }

                
            }else{
                $details['u'][$u]['category'] = $t->question->categories->first();
                $details['u'][$u]['question'] = $t->question;
                    $u++;
                $details['unattempted'] = $details['unattempted'] + 1;  
            }

            $details['total'] = $details['total'] + $t->section->mark;

        } 
        $success_rate = $details['correct']/count($questions);
        if($success_rate > 0.7)
            $details['performance'] = 'Excellent';
        elseif(0.3 < $success_rate && $success_rate <= 0.7)
            $details['performance'] = 'Average';
        else
            $details['performance'] = 'Need to Improve';

        $details['avgpace'] = round($sum / count($questions),2);
        
        
        

        return view('appl.exam.assessment.analysis-report')
                        ->with('exam',$exam)
                        ->with('user',$user)
                        ->with('details',$details)
                        ->with('chart',true);

    }

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

        $client = subdomain();

        if($filter){
            $examtype = Examtype::where('slug',$filter)->first();
            $exams = $exam->where('name','LIKE',"%{$item}%")->where('examtype_id',$examtype->id)->orderBy('created_at','desc ')->where('client',$client)->with('sections')->paginate(config('global.no_of_records'));
        }
        else
            $exams = $exam->where('name','LIKE',"%{$item}%")->where('client',$client)->with('sections')->paginate(config('global.no_of_records'));

        $view = $search ? 'list': 'index';

        return view('appl.exam.assessment.'.$view)
            ->with('exams',$exams)->with('exam',$exam)->with('examtypes',$examtypes);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function instructions($test,Request $r)
    {
        

        $filename = $test.'.json';
        $filepath = $this->cache_path.$filename;

        $exam = Cache::get('test_'.$test);
        if(!$exam)
        if(file_exists($filepath))
        {
            $exam = json_decode(file_get_contents($filepath));

        }else{
            $exam = Exam::where('slug',$test)->first();
        }
        
        if($exam->active){
            return view('appl.exam.assessment.inactive')->with('exam',$exam); 
        }


        if(!trim(strip_tags($exam->instructions)))
        {
            $url = route('assessment.try',$test);
            if($r->get('code')){
                $url=$url.'?code='.$r->get('code');
            }
            return redirect($url);
        }

        $code = $r->get('code');
        $user = \auth::user();
        if(isset($exam->product_ids))
        $products = $exam->product_ids;
        else
            $products = null;
        $product = null;

        $test_taken = $user->attempted($exam->id);//Test::where('test_id',$exam->id)->where('user_id',$user->id)->first();

        if($test_taken)
            return redirect()->route('assessment.analysis',$exam->slug);

        if(!$code){
           if($exam->status == 2){
            
            $entry=null;
            if($user){
                if($products){
                    $entry = DB::table('product_user')
                    ->whereIn('product_id', $products)
                    ->where('user_id', $user->id)
                    ->first(); 
                    $product = $exam->products[0];
                } 
            }
            

            if(!$entry)
                return view('appl.course.course.access');
            } 
        }else{
            $code = strtoupper($code);
            $exam->code = strtoupper($exam->code);
            if (strpos($exam->code, ',') !== false) {
                    $examcodes = explode(',',$exam->code);
                    $exists = false;
                    foreach($examcodes as $c){
                        if($c==$code)
                            $exists=true;
                    }
                    if(!$exists){
                        return view('appl.exam.assessment.wrongcode')->with('code',$code); 
                    }
            }else{
               if($exam->code != $code)
                return view('appl.exam.assessment.wrongcode')->with('code',$code); 
            }

            
        }
        
        $responses = Cache::get('responses_'.$user->id.'_'.$exam->id);

        return view('appl.exam.assessment.instructions')
                ->with('exam',$exam)->with('responses',$responses);
    }

    public function try2($test,$id=null, Request $request)
    {
        $filename = $test.'.json';
        $filepath = $this->cache_path.$filename;


        $exam = Cache::get('test_'.$test);

        if(!$exam)
        if(file_exists($filepath))
        {
            $exam = json_decode(file_get_contents($filepath));
        }else{
            $exam = Exam::where('slug',$test)->first();
        }

        if(!$exam)
            abort('404','Test not found');

        if($exam->active){
            return view('appl.exam.assessment.inactive')->with('exam',$exam); 
        }

        if($request->get('student') && $request->get('admin')){
            $user = User::where('username',$request->get('student'))->first();
            $responses = Test::where('test_id',$exam->id)->where('user_id',$user->id)->get();

        }else{
            $user = \auth::user();

            $responses = Cache::get('responses_'.$user->id.'_'.$exam->id);

            //dd($responses);

            if(is_array($responses))
            {
                $responses = collect($responses);
            }

            //$responses = null;

           
        }

        $jsonname = $test.'_'.$user->id;

        if(Storage::disk('s3')->exists('urq/'.$jsonname.'.json'))
            $images = json_decode(Storage::disk('s3')->get('urq/'.$jsonname.'.json'),true);
        else
            $images = [];


        $window_change = true;

        if(trim(strip_tags($exam->emails))){
            if(strpos(strtolower($exam->emails),strtolower($user->email))!==false)
            {
                
            }else{
                abort('403','You are not authorized to perform this action.');
            }
        }
        if(isset($exam->product_ids))
        $products = $exam->product_ids;
        else
            $products = null;
        $code = $request->get('code');

        if(!$request->get('admin')){
        $test_taken = $user->attempted($exam->id);
        if($test_taken)
            return redirect()->route('assessment.analysis',$exam->slug);
        }

        if(!$code){
           if($exam->status == 2){
            $entry=null;
            if($user){
                if($products){
                    $entry = DB::table('product_user')
                    ->whereIn('product_id', $products)
                    ->where('user_id', $user->id)
                    ->first(); 
                    $product = $exam->products[0];
                } 
            }
            if(!$entry)
                return view('appl.course.course.access');
            } 
        }else{
            $code = strtoupper($code);
            $exam->code = strtoupper($exam->code);
            if (strpos($exam->code, ',') !== false) {
                    $examcodes = explode(',',$exam->code);
                    $exists = false;
                    foreach($examcodes as $c){
                        if($c==$code)
                            $exists=true;
                    }
                    if(!$exists){
                        return view('appl.exam.assessment.wrongcode')->with('code',$code); 
                    }
            }else{
               if($exam->code != $code)
                return view('appl.exam.assessment.wrongcode')->with('code',$code); 
            }
           
        }



        $completed = 0;
        $questions = array();
        $ques = [];
        $sections = array();
        $i = 0; $time = 0;

        $question = new Question();

        $time_used = 0;
        $code_ques =[];
        $passages = array();
        $dynamic =array();
        $section_questions = array();
        foreach($exam->sections as $section){
            $qset = $section->questions;
            

            //shuffle($qset);
            if($exam->shuffle)
                $qset = $qset->shuffle();

            $k=0;
            foreach( $qset as $q){
                if($exam->shuffle){
                    if(!$responses){
                        $q->dynamic = rand(1,4);  
                        $q->response = null;
                        $q->time = 0;
                        
                    }else{
                        $keys = $responses->keyBy('question_id');
                        $q->dynamic = $keys[$q->id]->dynamic;
                        if(!isset($keys[$q->id]->response))
                            $keys[$q->id]->response = null;
                        $q->response = $keys[$q->id]->response;
                        $q->time = $keys[$q->id]->time;

                        $time_used = $time_used + intval($q->time);
                        
                    }
                }
                else{
                    $q->dynamic = 1;
                    if(!$responses){
                        $q->response = null;
                        $q->time =0;
                    }else{
                        $keys = $responses->keyBy('question_id');
                        if(!isset($keys[$q->id]->response))
                            $keys[$q->id]->response = null;
                        $q->response = $keys[$q->id]->response;
                        $q->time = $keys[$q->id]->time;
                        
                        
                         $time_used = $time_used + intval($q->time);

                    }
                }
                

                if(isset($images)){
                    if(isset($images[$q->id]))
                        $q->images = $images[$q->id];
                    else
                        $q->images = [];
                }else{
                    $q->images = [];
                }



                $q->answer = $this->new_answer(strtoupper($q->answer),$q->dynamic);
                //$q = $question->dynamic_variable_replacement($q->dynamic,$q);
                $q = $this->option_swap2($q,$q->dynamic);

                
                if($i==0){
                    $id = $q->id;
                }
                $questions[$i] = $q;
                $ques[$i] = $ques;
                if(isset($q->passage))
                $passages[$i] = $q->passage;
                else
                $passages[$i] =null;
                $sections[$i] = $section;
                if($q->dynamic)
                $dynamic[$i] = $q->dynamic;
                else
                    $dynamic[$i] =1;
                $section_questions[$section->id][$k]= $q;
                $i++;$k++;
                if($q->type=='code'){
                    $code_ques[$i]=1;
                    $window_change = false;
                }
            }
        }


        // time
        foreach($exam->sections as $section){
            $time = $time + $section->time;
            


        }

        $time = round(($time * 60 - $time_used)/60,2);


        if(!count($questions))
            abort(403,'No questions found');

        return view('appl.exam.assessment.blocks.test')
                        ->with('mathjax',true)
                        ->with('highlight',true)
                        ->with('exam',$exam)
                        ->with('code',true)
                        ->with('user',$user)
                        ->with('code_ques',$code_ques)
                        ->with('timer2',true)
                        ->with('camera',$exam->camera)
                        ->with('window_change',$window_change)
                        ->with('time',$time)
                        ->with('sections',$sections)
                        ->with('passages',$passages)
                        ->with('questions',$questions)
                        ->with('dynamic',$dynamic)
                        ->with('section_questions',$section_questions);
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
        $code = $request->get('code');
        $ajax = $request->get('ajax');

        if(!$ajax)
        if(!$code){
           if($exam->status == 2){
            
            $user = \Auth::user();
            $entry=null;
            if($user)
            foreach($exam->products as $product)
            {
                if($product->users()->find($user->id)){
                    $entry = DB::table('product_user')
                        ->where('product_id', $product->id)
                        ->where('user_id', $user->id)
                        ->first();
                     $p = $product;   
                }
                
            }
            if(!$entry)
                return view('appl.course.course.access');
            } 
        }else{
            $code = strtoupper($code);
            if($exam->code != $code)
                return view('appl.exam.assessment.wrongcode')->with('code',$code);
        }
        $completed = 0;
        $questions = array();
        $sections = array();
        $i= 0;$time = 0;
        $details = ['curr'=>null,'prev'=>null,'next'=>null,'qno'=>null,'display_type'=>'tag']; 
        $test_exists = Test::where('test_id',$exam->id)->where('user_id',\auth::user()->id)->first();
        if($id==null){
            $view ='questions';
            if(!$test_exists){
                foreach($exam->sections as $section){
                    $qset = $section->questions->shuffle();
                    foreach( $qset as $q){
                        if($i==0)
                            $id = $q->id;
                        $questions[$i] = $q;
                        $sections[$i] = $section;
                        $i++;
                    }
                }
                $details['response'] = null;
            }
            else{
                $details['response'] = $test_exists->response;
                $id = $test_exists->question_id;
            }
        }else{
            $view = 'q';
            $test = Test::where('question_id',$id)->where('test_id',$exam->id)->where('user_id',\auth::user()->id)->first();
            $details['response'] = $test->response;
        }
        $test_responses = Test::where('test_id',$exam->id)->where('user_id',\auth::user()->id)->get();
        // question set
        $i=0;
        if($test_responses)
        foreach($test_responses as $res){
            $m = new AssessmentController();
            $m->id = $res->question_id;
            $questions[$i] = $m;
            $i++;
        }
        // time
        foreach($exam->sections as $section){
            $time = $time + $section->time;
        }
        $question = Question::where('id',$id)->first();
        $passage = Passage::where('id',$question->passage_id)->first();
        $details['curr'] = $question->id;
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
                        $t->accuracy=0;
                        $t->time=0;
                        $t->dynamic = rand(1,4);
                        $t->answer = $this->new_answer(strtoupper($q->answer),$t->dynamic);
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
                
                $test_responses = Test::where('test_id',$exam->id)->where('user_id',\auth::user()->id)->get();
                $test_response = Test::where('question_id',$question->id)->where('test_id',$exam->id)->where('user_id',\auth::user()->id)->first();
                $question = $question->dynamic_variable_replacement($test_response->dynamic);
                $question = $this->option_swap($question,$test_response->dynamic);
                
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
                        ->with('section_questions',$test_responses->groupBy('section_id'))
                        ->with('questions',$questions);
    }


    public function option_swap($question,$dynamic){

            if(!$dynamic){
                $question['option_a'] = $question['a'];
                $question['option_b'] = $question['b'];
                $question['option_c'] = $question['c'];
                $question['option_d'] = $question['d'];
                $question['option_e'] = $question['e'];
            }

            if($dynamic == 4){
                $question['option_a'] = $question['d'];
                $question['option_b'] = $question['a'];
                $question['option_c'] = $question['b'];
                $question['option_d'] = $question['c'];
                $question['option_e'] = $question['e'];
            }

            if($dynamic == 3){
                $question['option_a'] = $question['c'];
                $question['option_b'] = $question['d'];
                $question['option_c'] = $question['a'];
                $question['option_d'] = $question['b'];
                $question['option_e'] = $question['e'];
            }

            if($dynamic == 2){
                $question['option_a'] = $question['b'];
                $question['option_b'] = $question['c'];
                $question['option_c'] = $question['d'];
                $question['option_d'] = $question['a'];
                $question['option_e'] = $question['e'];
            }

            if($dynamic == 1){
                $question['option_a'] = $question['a'];
                $question['option_b'] = $question['b'];
                $question['option_c'] = $question['c'];
                $question['option_d'] = $question['d'];
                $question['option_e'] = $question['e'];
            }

            return $question;
    }

    public function option_swap2($question,$dynamic){


            if(!$dynamic){

                $question->option_a = $question->a;
                $question->option_b = $question->b;
                $question->option_c = $question->c;
                $question->option_d = $question->d;
                $question->option_e = $question->e;
            }

            if($dynamic == 4){

                if(strip_tags(trim($question->question_d)))
                    $question->question = $question->question_d;

                $question->option_a = $question->d;
                $question->option_b = $question->a;
                $question->option_c = $question->b;
                $question->option_d = $question->c;
                $question->option_e = $question->e;
            }

            if($dynamic == 3){
                if(strip_tags(trim($question->question_c)))
                    $question->question = $question->question_c;
                $question->option_a = $question->c;
                $question->option_b = $question->d;
                $question->option_c = $question->a;
                $question->option_d = $question->b;
                $question->option_e = $question->e;
            }

            if($dynamic == 2){

                if(strip_tags(trim($question->question_b)))
                    $question->question = $question->question_b;
                $question->option_a = $question->b;
                $question->option_b = $question->c;
                $question->option_c = $question->d;
                $question->option_d = $question->a;
                $question->option_e = $question->e;
            }

            if($dynamic == 1){
                $question->option_a = $question->a;
                $question->option_b = $question->b;
                $question->option_c = $question->c;
                $question->option_d = $question->d;
                $question->option_e = $question->e;
            }

            return $question;
    }

     public function new_answer($answer,$dynamic)
     {
     
        if(!$dynamic)
            return $answer;

        

        if(strpos($answer,',')!== false){
            $ans =explode(',', $answer);
            foreach($ans as $k=>$a){
                $ans[$k]=$this->new_ans_str($a,$dynamic);
            }
            $new_ans = implode(',', $ans);
        }else if(strlen($answer)==1){
            $new_ans = $this->new_ans_str($answer,$dynamic);
        }

        if(!isset($new_ans))
            return $answer;

        return $new_ans;
    }

    public function new_ans_str($answer,$dynamic){
        $new_ans = $answer;
        if($answer == 'A'){
            if($dynamic == 1) $new_ans = 'A';
            if($dynamic == 2) $new_ans = 'D';
            if($dynamic == 3) $new_ans = 'C';
            if($dynamic == 4) $new_ans = 'B';
        }

        if($answer == 'B'){
            if($dynamic == 1) $new_ans = 'B';
            if($dynamic == 2) $new_ans = 'A';
            if($dynamic == 3) $new_ans = 'D';
            if($dynamic == 4) $new_ans = 'C';
        }
          
        if($answer == 'C'){
            if($dynamic == 1) $new_ans = 'C';
            if($dynamic == 2) $new_ans = 'B';
            if($dynamic == 3) $new_ans = 'A';
            if($dynamic == 4) $new_ans = 'D';
        } 

        if($answer == 'D'){
            if($dynamic == 1) $new_ans = 'D';
            if($dynamic == 2) $new_ans = 'C';
            if($dynamic == 3) $new_ans = 'B';
            if($dynamic == 4) $new_ans = 'A';
        }

        if($answer == 'E'){
            return $answer;
        } 

        return $new_ans;
    }

    public function solutions($slug,$id=null,Request $request)
    {

        $exam = Cache::get('test_'.$slug);

        if(!$exam)
        $exam = Exam::where('slug',$slug)->with('sections')->first();


        if($request->get('student'))
            $student = User::where('username',$request->get('student'))->first();
        else
            $student = \auth::user();

        if(!$student)
            $student = \auth::user();

        $test_responses = Cache::remember('resp_'.$student->id.'_'.$exam->id,240,function() use ($exam,$student){
            return Test::where('test_id',$exam->id)
                        ->where('user_id',$student->id)->get();
        });


        //dd($test_responses);
        if($id==null){
            $view ='questions';
            $response = $test_responses->first();
            $id = $response->question_id;
        }else{
            $response = $test_responses->where('question_id',$id)->first();
            $view = 'q';
        }

        if(request()->get('slug')){
            $response->mark = request()->get('score');
            $response->comment = request()->get('comment');
            $response->save();
            $exam->updateScore($test_responses,$response);
        }

      
        
        if($id){
            $question = Question::where('id',$id)->first()->dynamic_variable_replacement($response->dynamic);

            $question = $this->option_swap($question,$response->dynamic);
            $question->answer = $this->new_answer($question->answer,$response->dynamic);


            if($question){
            
                if($question->passage_id)
                $passage = Passage::where('id',$question->passage_id)->first();
                else
                    $passage = [];
                
                $questions = array();
                $sections  = array();
                $i=0;

                $details = ['curr'=>null,'prev'=>null,'next'=>null,'qno'=>null,'display_type'=>'tag']; 

                $test = $response;

                if($test){
                    $details['code'] = $test->code;
                    $details['response'] = $test->response;
                    $details['accuracy'] = $test->accuracy;
                    $details['time'] = $test->time;
                    $details['mark'] = $test->mark;
                    $details['status'] = $test->status;
                    if(isset($test->comment))
                    $details['comment'] = $test->comment;
                    else
                    $details['comment'] = '';

                    if(isset($test->section))
                    $details['section'] = $test->section;
                    else
                    $details['section'] = '';  
                }else{
                    $details['code'] = null;
                    $details['response'] = null;
                    $details['accuracy'] = null;
                    $details['time'] = null;
                    $details['mark'] = null;
                    $details['comment'] = null;
                    $details['section'] = null;
                    $details['status'] = null;
                }
            
                $details['curr'] = route('assessment.solutions.q',[$exam->slug,$question->id]);
                
                $tests = ['test1','test2','test3','test4','test5'];
                foreach($test_responses as $key=>$q){

                    if($q->question_id == $question->id){

                        if($key!=0)
                            $details['prev'] = route('assessment.solutions.q',[$exam->slug,$test_responses[$key-1]->question_id]).'?student='.$student->username;

                        if(count($test_responses) != $key+1)
                            $details['next'] = route('assessment.solutions.q',[$exam->slug,$test_responses[$key+1]->question_id]).'?student='.$student->username;

                        $details['qno'] = $key + 1 ;
                    }else{

                    }
                    
                    $details['q'.$q->id] = null;

                } 

                //dd('here');


                if($exam->status==2)
                    $view = 'solutions_private';
                else
                    $view = 'solutions';

                $user_id = $student->id;

                $jsonname = $slug.'_'.$user_id;

                if(Storage::disk('s3')->exists('urq/'.$jsonname.'.json'))
                    $images = json_decode(Storage::disk('s3')->get('urq/'.$jsonname.'.json'),true);
                else
                    $images = [];

                return view('appl.exam.assessment.'.$view)
                        ->with('mathjax',true)
                        ->with('question',$question)
                        ->with('passage',$passage)
                        ->with('details',$details)
                        ->with('exam',$exam)
                        ->with('student',$student)
                        ->with('images',$images)
                        ->with('highlight',true)
                        ->with('section_questions',$test_responses->groupBy('section_id'))
                        ->with('questions',$test_responses);
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
        $section = $question->sections()->first();

        $t = Test::where('question_id',$id)->where('test_id',$exam->id)
                ->where('user_id',$request->get('user_id'))->first();

        
        if(!$t){
            $t = new Test();
            $t->answer = $question->answer;
        }
        


        $t->question_id = $request->get('question_id');
        $t->test_id = $exam->id;
        $t->user_id = $request->get('user_id');
        if($request->get('response'))
        $t->response = strtoupper($request->get('response'));

        if($request->get('time'))
        $t->time = $t->time+$request->get('time');

        if($t->response == $t->answer)
            $t->accuracy =1;
        else
            $t->accuracy=0;

        $t->save();
    }


    public function clear($slug,$id,Request $request)
    {

        $exam = Exam::where('slug',$slug)->first();
        $question = Question::where('id',$id)->first();
        $section = $question->sections()->first();

        $t= Test::where('question_id',$id)->where('test_id',$exam->id)
                ->where('user_id',$request->get('user_id'))->first();
        if(!$t)
        $t = new Test();

        $t->question_id = $request->get('question_id');
        $t->test_id = $exam->id;
        $t->user_id = $request->get('user_id');
        $t->time = $t->time+$request->get('time');
        $t->response = strtoupper($request->get('response'));
        $t->accuracy=0;

        $t->save();



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

    public function savetest($slug,Request $request){
        $resp = json_decode($request->get('responses'));
        $user_id = $resp->user_id;
        $exam_id = $resp->test_id;
        $responses = $resp->responses;

       

        Cache::put('responses_'.$user_id.'_'.$exam_id,$responses,240);


        Storage::disk('s3')->put('responses/responses_'.$user_id.'_'.$exam_id.'.json',json_encode($responses),'public');
            
        exit();
    }


    public function submission($slug,Request $request)
    {

        $code_ques_flag =0;
        $test = $slug;
        if($request->get('admin')){
            $user = User::where('id',$request->get('user_id'))->first();
        }else{
            $user = \auth::user();
        }
        $user_id = $request->get('user_id');
        $test_id = $request->get('test_id');
        $code = $request->get('code');
        $exam = Cache::get('test_'.$test);

        //dd($request->all());
        $filename = $test.'.json';
        $filepath = $this->cache_path.$filename;

        
        if(!$exam)
        if(file_exists($filepath))
        {
            $exam = json_decode(file_get_contents($filepath));
        }else{
            $exam = Exam::where('slug',$test)->first();
        }

        if(!$request->get('admin')){
            $test_taken = $user->attempted($exam->id);

            if($test_taken)
                return redirect()->route('assessment.analysis',$slug);
        }else{

            Test::where('test_id',$test_id)->where('user_id',$user_id)->delete();
            Tests_Section::where('test_id',$test_id)->where('user_id',$user_id)->delete();
            Tests_Overall::where('test_id',$test_id)->where('user_id',$user_id)->delete(); 

        }
        

        $qcount =0;
        foreach($exam->sections as $section){
            $qset = $section->questions;

            foreach( $qset as $q){
                $questions[$q->id] = $q;
                $secs[$section->id] = $section;
                $answers[$q->id] = $q->answer;
                if(!isset($sections_max[$section->id]))
                    $sections_max[$section->id] = 0;
                if($q->mark)
                $sections_max[$section->id] = $sections_max[$section->id] + $q->mark;  
                else
                $sections_max[$section->id] = $sections_max[$section->id] + $section->mark;
                $qcount++;
            }
        }

        $date_time = new \DateTime();
        $data = array();
        $d =array();
        for($i=1;$i<=$qcount;$i++){
            $item = array();
            if($request->exists($i.'_time')){
                $item['question_id'] = $request->get($i.'_question_id');
                $item['user_id'] = $request->get('user_id');
                $item['section_id'] = $request->get($i.'_section_id');
                $item['time'] = $request->get($i.'_time');
                $item['test_id'] = $request->get('test_id');

                if(is_array($request->get($i))){
                    $item['response'] = strtoupper(implode(',',$request->get($i)));
                }else{
                    $item['response'] = strtoupper($request->get($i)); 
                }
                
                $item['answer'] = $this->new_answer(strtoupper($answers[$request->get($i.'_question_id')]),$request->get($i.'_dynamic'));

                if(strlen($item['answer'])==1){
                   if($item['response'] == $item['answer'])
                    $item['accuracy'] =1;
                    else
                    $item['accuracy'] =0; 
                }elseif(strpos($item['answer'],',')!==false){
                    
                    $ans = explode(',',$item['response']);
                    $flag = false;
                    foreach($ans as $an)
                    if($an)
                    if(strpos($item['answer'],$an)!==false){

                    }else{
                        $flag = true;
                        break;
                    }

                    if(!$flag){
                        if(strlen($item['response']) != strlen($item['answer']))
                            $flag = true;
                    }

                    if($flag)
                        $item['accuracy'] =0;
                    else
                        $item['accuracy'] =1;
                }else{

                    if(strpos($item['answer'],'/')!==false){
                        $ans = explode('/',$item['answer']);
                        
                        $flag = false;
                        $item['accuracy'] =0;
                        foreach($ans as $an){
                            $an = str_replace(' ', '', $an);
                            if($an==trim(str_replace(' ','',$item['response'])))
                                $item['accuracy'] =1;
                        }
                       
                    }else{
                        if($item['response']){
                            if(trim($item['response']) == $item['answer'])
                            $item['accuracy'] =1;
                            else
                            $item['accuracy'] =0; 
                        }else{
                            $item['accuracy'] =0; 
                        }
                    }
                    

                }

                if($item['accuracy']==1){
                    if($questions[$item['question_id']]->mark)
                        $item['mark'] = $questions[$item['question_id']]->mark;
                    elseif($secs[$item['section_id']]->mark)
                        $item['mark'] = $secs[$item['section_id']]->mark;
                    else
                        $item['mark'] = 1;
                }else{
                    if($secs[$item['section_id']]->negative)
                        $item['mark'] = 0 - $secs[$item['section_id']]->negative;
                    else
                        $item['mark'] = 0;
                }


                $item['status'] = 1;
                $item['dynamic'] = $request->get($i.'_dynamic');
                $item['code'] = $request->get('dynamic_'.$i);

                if(strip_tags(trim($item['code']))){
                    $code_ques_flag =1;
                    $item['status'] = 2;
                }

                $type = $questions[$item['question_id']]->type;

                if($type=='sq' || $type=='urq'){
                    $code_ques_flag =1;
                    $item['status'] = 2;
                }

                $item['created_at'] = $date_time;
                $item['updated_at'] = $date_time;
                array_push($data,$item);
                array_push($d, json_decode(json_encode($item)));
               
            }

            
        }

        if(!$request->get('admin')){
            $tests_cache = new Test();
            $tests_cache = collect($d);
            Cache::put('responses_'.$user_id.'_'.$test_id,$tests_cache,240);
        }
       

        
        $details = ['user_id'=>$request->get('user_id'),'test_id'=>$request->get('test_id')];

        //update sections
        $sections = array();
        $sec = array();
        foreach($data as $item){
            if(!isset($sec[$item['section_id']]['unattempted'])){
                $sec[$item['section_id']]['unattempted'] = 0;
                $sec[$item['section_id']]['correct'] = 0;
                $sec[$item['section_id']]['incorrect'] = 0;
                $sec[$item['section_id']]['score'] =0;
                $sec[$item['section_id']]['time'] = 0;
                $sec[$item['section_id']]['max'] = 0;
                $sec[$item['section_id']]['user_id'] = $details['user_id'];
                $sec[$item['section_id']]['test_id'] = $details['test_id'];
                $sec[$item['section_id']]['section_id'] = $item['section_id'];
                $sec[$item['section_id']]['created_at'] = $date_time;
                $sec[$item['section_id']]['updated_at'] = $date_time;

            }
          
            if(!$item['response'])
                $sec[$item['section_id']]['unattempted']++;

            if($item['accuracy']){
                $sec[$item['section_id']]['correct']++;
                $sec[$item['section_id']]['score'] = $sec[$item['section_id']]['score'] + $item['mark'];
            }
            else if($item['response'] && $item['accuracy']==0){
                $sec[$item['section_id']]['incorrect']++;
                $sec[$item['section_id']]['score'] = $sec[$item['section_id']]['score'] - $item['mark'];
            }
                
            $sec[$item['section_id']]['time'] = $sec[$item['section_id']]['time'] + $item['time'];

            $sec[$item['section_id']]['max'] = $sections_max[$item['section_id']];

        }


        //update tests overall
        $test_overall = array();
        $test_overall['unattempted'] = 0;
        $test_overall['correct'] = 0;
        $test_overall['incorrect'] = 0;
        $test_overall['score'] =0;
        $test_overall['time'] = 0;
        $test_overall['max'] = 0;
        $test_overall['user_id'] = $details['user_id'];
        $test_overall['test_id'] = $details['test_id'];
        $test_overall['created_at'] = $date_time;
        $test_overall['updated_at'] = $date_time;
        $test_overall['code'] = $code;
        $test_overall['status'] =0;
        $test_overall['window_change'] =$request->get('window_change');
        $test_overall['face_detect'] = 0;
        $test_overall['cheat_detect'] = 0;
        $test_overall_cache = new Tests_Overall();
        $test_overall_cache->user_id = $details['user_id'];
        $test_overall_cache->test_id = $details['test_id'];
        $test_overall_cache->window_change = $request->get('window_change');
        $test_overall_cache->created_at = date('Y-m-d H:i:s');
        $test_overall_cache->updated_at = date('Y-m-d H:i:s');
        $test_overall_cache->code = $code;
        $test_overall_cache->status = 0;
        $test_overall_cache->face_detect = 0;
        $test_overall_cache->cheat_detect = 0;

        if($code_ques_flag){
            $test_overall['status'] = 1;
            $test_overall_cache->status =1;
        }

        foreach($sec as $s){
            $test_overall['unattempted'] = $test_overall['unattempted'] + $s['unattempted'];
            $test_overall['correct'] = $test_overall['correct'] + $s['correct'];
            $test_overall['incorrect'] = $test_overall['incorrect'] + $s['incorrect'];
            $test_overall['score'] = $test_overall['score'] + $s['score'];
            $test_overall['time'] = $test_overall['time'] + $s['time'];
            $test_overall['max'] = $test_overall['max'] + $s['max'];

            $test_overall_cache->unattempted = $test_overall['unattempted'];
            $test_overall_cache->correct = $test_overall['correct'];
            $test_overall_cache->incorrect = $test_overall['incorrect'];
            $test_overall_cache->score = $test_overall['score'];
            $test_overall_cache->time = $test_overall['time'];
            $test_overall_cache->max = $test_overall['max'];
        }

        if($test_overall['window_change']>3){
            $test_overall['cheat_detect'] = 1;
            $test_overall_cache->cheat_detect = 1;
        }

        $pat = Storage::disk('local')->getDriver()->getAdapter()->getPathPrefix();
        $json_file =  $pat.'public/tests/json/'.\auth::user()->username.'_'.$exam->id.'.json';
        if(file_exists($json_file)){
            $json = json_decode(file_get_contents($json_file));
            $zero =$one = $two =$three = $total = $snaps = 0;
            foreach($json as $i => $j){
                $j = intval($j);
                if($j==0)
                    $zero++;
                if($j==1)
                    $one++;
                if($j==2)
                    $two++;
                if($j>2)
                    $three++;
                $snaps++;
                $total = $total + $j;
            }

            if($three){
                    $test_overall['face_detect'] = 3;
                }else if($two)
                    $test_overall['face_detect'] = 2;
                else if($one)
                    $test_overall['face_detect'] = 1;
                else
                    $test_overall['face_detect'] = 0;

            $test_overall_cache->face_detect = $test_overall['face_detect'];

            if($total==$snaps){
                $test_overall['cheat_detect'] = 0;
            }else if( $total < $snaps)
            {
                $test_overall['cheat_detect'] = 2;
            }else{
                $test_overall['cheat_detect'] = 1;
            }



        }

        if($test_overall['window_change']>3)
            $test_overall['cheat_detect'] = 1;

        $test_overall_cache->cheat_detect = $test_overall['cheat_detect'];
        
        if(!$request->get('admin')){
            Cache::put('attempt_'.$user_id.'_'.$test_id,$test_overall_cache,240);
            Cache::forget('attempts_'.$user_id);
        }

        Test::insert($data); 
        Tests_Section::insert($sec);
        Tests_Overall::insert($test_overall); 

        if(!$request->get('admin')){
            $test_oa = Tests_Overall::where('user_id', $user->id)
                    ->orderBy('id','desc')
                    ->get();

            Cache::put('attempts_'.$user_id,$test_oa, 240);
        }

        //$this->dispatch(new ProcessAttempts($data,$sec,$test_overall));

        if(!$request->get('admin'))
            return redirect()->route('assessment.analysis',$slug);
        else
            return redirect()->route('test.report',$slug);


    }

    public function delete_image($slug){

        $user_id = request()->get('user_id');
        $qid = request()->get('qid');

        $name = $slug.'_'.$user_id.'_'.$qid;
        $jsonname = $slug.'_'.$user_id;

        if(Storage::disk('s3')->exists('urq/'.$jsonname.'.json')){
            $json = json_decode(Storage::disk('s3')->get('urq/'.$jsonname.'.json'),true);

            foreach($json as $q=>$ques){
                if($qid == $q){
                    foreach($ques as $filename=>$img){
                        Storage::disk('s3')->delete('urq/'.$filename);
                    }
                    unset($json[$qid]);
                }
            }
            Storage::disk('s3')->put('urq/'.$jsonname.'.json', json_encode($json));
        }

        echo 1;
        exit();

    }

    public function upload_image($slug){


         /* If image is given upload and store path */
            if(request()->all()['file']){
                
                 $request = request();
                 $file      = request()->get('file');
                 $user_id = request()->get('user_id');
                 $qid = request()->get('qid');
                 $k = request()->get('i');



                if(strtolower($request->file->getClientOriginalExtension()) == 'jpeg')
                    $extension = 'jpg';
                else
                    $extension = strtolower($request->file->getClientOriginalExtension());

                $name = $slug.'_'.$user_id.'_'.$qid.'_'.$k;
                $jsonname = $slug.'_'.$user_id;
                $jsonfile = $jsonname.'.json';

                if(Storage::disk('s3')->exists('urq/'.$jsonfile)){
                    $json = json_decode(Storage::disk('s3')->get('urq/'.$jsonfile),true);


                    if(!$json){
                        $json = array();
                    }
                }else{
                    $json = array();
                }


                $filename = $name.'.'.$extension;
                $folder = public_path('../public/storage/urq/');
                if (!Storage::exists($folder)) {
                    Storage::makeDirectory($folder, 0775, true, true);
                }

                $path = Storage::disk('public')->putFileAs('urq',$request->file,$filename);
                
                

                //Storage::disk('s3')->putFileAs('urq',$request->file,$filename_org);
                
                $image= jpg_resize('urq/'.$name,$path,1000);


                Storage::disk('s3')->put('urq/'.$name.'.jpg', (string)$image,'public');
                



                //Storage::disk('s3')->putFileAs('urq', new File($newpath), $filename);
                $path = Storage::disk('s3')->url('urq/'.$name.'.jpg');

                $json[$qid]['urq/'.$name.'.jpg'] = $path;
                Storage::disk('s3')->put('urq/'.$jsonfile, json_encode($json));

                echo  $path;
                exit();
            }else{
                echo 1;
                exit();
            }
    }

    public function show($id)
    {
        $filename = $id.'.json';
        $filepath = $this->cache_path.$filename; 
        



        $exam = Cache::get('test_'.$id);
        if(!$exam)
        if(file_exists($filepath))
        {
            $exam = json_decode(file_get_contents($filepath));
           
        }else{
            $exam = Exam::where('slug',$id)->first();  
            $exam->sections = $exam->sections;
            $exam->products = $exam->products;
            $exam->product_ids = $exam->products->pluck('id')->toArray();
            foreach($exam->sections as $m=>$section){
                $exam->sections->questions = $section->questions;
            }
            file_put_contents($filepath, json_encode($exam,JSON_PRETTY_PRINT));
        }
        //precheck for auto activation
        $exam = $this->precheck_auto_activation($exam);
        //dd($exam);
        $entry=null;
        $attempt = null;
        $user = \Auth::user();
        $products = $exam->product_ids;
        $product = null;

        if($exam->active){
            return view('appl.exam.assessment.inactive')->with('exam',$exam); 
        }else if($exam->status==0){
            abort(403,'Test is in draft state');
        }
        
        if($products){
            $product = $exam->products[0];
        }
        if($user){
            if($products){
                $entry = DB::table('product_user')
                    ->whereIn('product_id', $products)
                    ->where('user_id', $user->id)
                    ->first(); 
                $product = $exam->products[0];
                
            }
            
            $attempt = $user->attempted($exam->id);//Test::where('test_id',$exam->id)->where('user_id',$user->id)->first();
            if($attempt)
            $entry = 1;
        }

        if($user)
            $responses = Cache::get('responses_'.$user->id.'_'.$exam->id);
        else
            $responses = null;

        //dd($exam->product_ids);


        if($exam)
            return view('appl.exam.assessment.show')
                    ->with('exam',$exam)
                    ->with('entry',$entry)
                    ->with('cameratest',$exam->camera)
                    ->with('product',$product)
                    ->with('responses',$responses)
                    ->with('attempt',$attempt);
        else
            abort(404);
            
    }

    public function precheck_auto_activation($exam){

      if(!$exam->auto_activation && !$exam->auto_deactivation)
        return $exam;

      $auto_activation  = \carbon\carbon::parse($exam->auto_activation);
      $auto_deactivation  = \carbon\carbon::parse($exam->auto_deactivation);
   
      $e = $exam;


      if(!$exam->auto_activation && !$exam->auto_deactivation)
        return $exam;
      if($auto_activation->lt(\carbon\carbon::now()) && $auto_deactivation->gt(\carbon\carbon::now())){
        
          if($exam->active){
            $exam->active = 0;
            $e = Exam::where('id',$exam->id)->first();
            $e->active = 0;
            $e->save();
            $e->cache();
          }
      }else{
        
          if(!$exam->active){
            $exam->active = 1;
            $e = Exam::where('id',$exam->id)->first();
            $e->active = 1;
            $e->save();
            $e->cache();
          }
      }
      return $e;
    }

    public function access($id)
    {
        $exam= Exam::where('slug',$id)->first();
        
        if($exam)
            return view('appl.exam.assessment.access')
                    ->with('exam',$exam);
        else
            abort(404);
            
    }

    public function updateTestRecords($exam,$user){

        // tests overall and section update

        $tests = Test::where('test_id',$exam->id)->where('user_id',$user->id)->get();

        $tests_overall = Tests_Overall::where('test_id',$exam->id)->where('user_id',$user->id)->first();


        $i=0;
        if(!$tests_overall)
        foreach($tests as $k=>$t){

            $tests_section = Tests_Section::where('section_id',$t->section_id)->where('user_id',$t->user_id)->first();

            
            $section = Section::where('id',$t->section_id)->first();

            if(!$tests_overall ){
                $tests_overall = new Tests_Overall;
            }


            if(!$tests_section ){
                $tests_section = new Tests_Section;
            }

            $tests_section->user_id = $t->user_id;
            $tests_overall->user_id = $t->user_id;

            $tests_section->test_id = $t->test_id;
            $tests_overall->test_id = $t->test_id;
            $tests_section->section_id = $t->section_id;

            if(!$t->response){

                $tests_section->unattempted++;
                $tests_overall->unattempted++;

                
            }else{

                if($t->accuracy){
                    $tests_section->correct++;
                    $tests_overall->correct++;


                    $tests_section->score += $section->mark;
                    $tests_overall->score += $section->mark;
                }else
                {
                    $tests_section->incorrect++;
                    $tests_overall->incorrect++;

                    $tests_section->score -= $section->negative;
                    $tests_overall->score -= $section->negative;
                }

            }

            $tests_section->max += $section->mark;
            $tests_overall->max += $section->mark;
            

            $tests_section->time += $t->time;
            $tests_overall->time += $t->time;
        
            $i++;
            $tests_section->save();
            $tests_overall->save();
        }

    }

    public function analysis($slug,Request $request)
    {
        $exam = Exam::where('slug',$slug)->first();

        $questions = array();
        $i=0;


        $student = User::where('username',$request->get('student'))->first();

        if(!$student)
            $student = \auth::user();

        
        $details = ['correct'=>0,'incorrect'=>'0','unattempted'=>0,'attempted'=>0,'avgpace'=>'0','testdate'=>null,'marks'=>0,'total'=>0];
        $details['course'] = $exam->name;
        $sum = 0;
        $c=0; $i=0; $u=0;

        $tests = Test::where('test_id',$exam->id)
                        ->where('user_id',$student->id)->get();

        //dd($tests);
        if(!count($tests))
            return redirect()->route('assessment.instructions',$slug);            

        $this->updateTestRecords($exam,$student);

        $sections = array();
        foreach($exam->sections as $section){
            foreach($section->questions as $q){
                $questions[$i] = $q;
                $sections[$section->name] = Tests_Section::where('section_id',$section->id)->where('user_id',$student->id)->first();
                    $i++;
            }
        }

        if(count($sections)==1)
            $sections = null;

        $details['correct_time'] =0;
        $details['incorrect_time']=0;
        $details['unattempted_time']=0;
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
                    $details['c'][$c]['category'] = $t->question->categories->first();
                    $details['c'][$c]['question'] = $t->question;
                    $c++;
                    $details['correct'] = $details['correct'] + 1;
                    $details['correct_time'] = $details['correct_time'] + $t->time;
                    $details['marks'] = $details['marks'] + $t->section->mark;
                }
                else{
                    $details['i'][$i]['category'] = $t->question->categories->first();
                    $details['i'][$i]['question'] = $t->question;
                    $i++;
                    $details['incorrect'] = $details['incorrect'] + 1; 
                    $details['incorrect_time'] = $details['incorrect_time'] + $t->time;
                    $details['marks'] = $details['marks'] - $t->section->negative; 
                }

                
            }else{
                $details['u'][$u]['category'] = $t->question->categories->last();
                $details['u'][$u]['question'] = $t->question;
                    $u++;
                $details['unattempted'] = $details['unattempted'] + 1;  
                $details['unattempted_time'] = $details['unattempted_time'] + $t->time;
            }

            $details['total'] = $details['total'] + $t->section->mark;

        } 
        $success_rate = $details['correct']/count($questions);
        if($success_rate > 0.7)
            $details['performance'] = 'Excellent';
        elseif(0.3 < $success_rate && $success_rate <= 0.7)
            $details['performance'] = 'Average';
        else
            $details['performance'] = 'Need to Improve';

        $details['avgpace'] = round($sum / count($questions),2);
        
        if($details['correct_time'] && $details['correct_time']>59)
            $details['correct_time'] =round($details['correct_time']/60,2).' min';
        else
            $details['correct_time'] = $details['correct_time'].' sec';
            

        if($details['incorrect_time'] && $details['incorrect_time'] > 59)
            $details['incorrect_time'] =round($details['incorrect_time']/60,2).' min';
        else
            $details['incorrect_time'] = $details['incorrect_time'].' sec';


        if($details['unattempted_time'] && $details['unattempted_time']>59)
            $details['unattempted_time'] =round($details['unattempted_time']/60,2).' min';
        else 
            $details['unattempted_time'] = $details['unattempted_time'].' sec';   
            
        $tests_overall = Tests_Overall::where('test_id',$exam->id)->where('user_id',$student->id)->first();
       

        return view('appl.exam.assessment.analysis')
                        ->with('exam',$exam)
                        ->with('test_overall',$tests_overall)
                        ->with('sections',$sections)
                        ->with('details',$details)
                        ->with('user',$student)
                        ->with('chart',true);

    }

    public function analysis2($slug,Request $request)
    {
        $filename = $slug.'.json';
        $filepath = $this->cache_path.$filename;

        $exam = Cache::get('test_'.$slug);
        if(!$exam)
        if(file_exists($filepath))
        {
            $exam = json_decode(file_get_contents($filepath));
        }else{
            if(is_int($slug))
                $exam = Exam::where('id',$slug)->first();
            else  
                $exam = Exam::where('slug',$slug)->first();
        }

        $questions = array();
        $i=0;

        if($request->get('student'))
            $student = User::where('username',$request->get('student'))->first();
        else
            $student = \auth::user();

        if(!$student)
            $student = \auth::user();

        $user_id = $student->id;
        $test_id = $exam->id;

        $jsonname = $slug.'_'.$user_id;

        if(Storage::disk('s3')->exists('urq/'.$jsonname.'.json'))
            $images = json_decode(Storage::disk('s3')->get('urq/'.$jsonname.'.json'),true);
        else
            $images = [];


        $details = ['correct'=>0,'incorrect'=>'0','unattempted'=>0,'attempted'=>0,'avgpace'=>'0','testdate'=>null,'marks'=>0,'total'=>0,'evaluation'=>1];
        $details['course'] = $exam->name;
        $sum = 0;
        $c=0; $i=0; $u=0;

        $tests = Cache::remember('responses_'.$user_id.'_'.$test_id,240,function() use ($exam,$student){
            return Test::where('test_id',$exam->id)
                        ->where('user_id',$student->id)->get();
        });
        $tests_overall = Cache::remember('attempt_'.$user_id.'_'.$test_id, 60, function() use ($exam,$student){
            return Tests_Overall::where('test_id',$exam->id)->where('user_id',$student->id)->first();
        });


        //dd($tests->where('status',1));
        $evaluation = $tests->where('status',2);
        if(count($evaluation))
            $details['evaluation'] = 0;

        $tests_section = Cache::remember('attempt_section_'.$user_id.'_'.$test_id,60,function() use($exam,$student){
            return Tests_Section::where('test_id',$exam->id)->where('user_id',$student->id)->get();
        });
        $secs = $tests_section->groupBy('section_id');


        //dd($secs);

        //dd($tests[0]->time);
        if(!count($tests))
            abort('404','Test not attempted');
        $subjective = false; 
        $sections = array();
        foreach($exam->sections as $section){
            if(isset($secs[$section->id][0]))
                $sections[$section->name] = $secs[$section->id][0];
                else
                $sections[$section->name] ='';
            $secs[$section->id] = $section;
            foreach($section->questions as $q){

                if(isset($images)){
                    if(isset($images[$q->id]))
                        $q->images = $images[$q->id];
                    else
                        $q->images = [];
                }else{
                    $q->images = [];
                }

                $questions[$i] = $q;
                $ques[$q->id] = $q;
                $ques_keys[$q->id]['topic'] = $q->topic;
                $ques_keys[$q->id]['section'] = $section->name;
                $i++;

                if($q->type=='sq' || $q->type=='urq')
                    $subjective= true;
            }
            
        }



        if(count($sections)==1)
            $sections = null;
        

        $details['correct_time'] =0;
        $details['incorrect_time']=0;
        $details['unattempted_time']=0;
        $topics = false;
        $review=false;

        $i=0;
        if($exam->slug=='psychometric-test')
        {
            $d['extroversion'] = 20;
            $d['agreeableness'] = 14;
            $d['conscientiousness'] = 14;
            $d['neuroicism'] = 38;
            $d['openness'] = 8;

            $mc['extroversion'] = "Extroversion (E) is the personality trait of seeking fulfillment from sources outside the self or
                in community. High scorers tend to be very social while low scorers prefer to work on their
                projects alone.";
            $mc['agreeableness'] = "Agreeableness (A) reflects much individuals adjust their behavior to suit others. High scorers
                are typically polite and like people. Low scorers tend to 'tell it like it is'.";
            $mc['conscientiousness'] = "Conscientiousness (C) is the personality trait of being honest and hardworking. High scorers
                tend to follow rules and prefer clean homes. Low scorers may be messy and cheat others.";
            $mc['neuroicism'] = "Neuroticism (N) is the personality trait of being emotional.";
            $mc['openness'] = "Openness to Experience (O) is the personality trait of seeking new experience and intellectual
                pursuits. High scores may day dream a lot. Low scorers may be very down to earth.";

            $cc['extroversion']['high'] = "High Extroverts are characterized by excitability, sociability, talkativeness, assertiveness, and expressiveness. They are outgoing and work well in social situations. Working in a team helps them feel energized and excited.";
            $cc['extroversion']['mid'] = "This range of extroversion indicates more detailed assessment of the candidate in this area.";
            $cc['extroversion']['low'] = "Low Extroverts or introverts are reserved and prefer not to socialise, unless absolutely necessary. Social events can be draining often requiring a period of quiet in order to 'recharge.'";

            $cc['conscientiousness']['high'] = "Conscientious people are thoughtful, prepared, and self-motivated. They are also concerned about the well-being of those around them. They are good at meeting deadlines.";
            $cc['conscientiousness']['mid'] = "This range of conscientiousness indicates more detailed assessment of the candidate in this area.";
            $cc['conscientiousness']['low'] = "Low conscientious people have difficulty in following schedules and are prone  to procrastinate. They might also be disorganised and avoid responsibility.";

            $cc['agreeableness']['high'] = "Agreeable people are prosocial, kind, and altruistic. They might not always flourish in highly competitive environments. They are empathetic and enjoy helping people.";
            $cc['agreeableness']['mid'] = "This range of agreeableness indicates more detailed assessment of the candidate in this area.";
            $cc['agreeableness']['low'] = "People with low agreeability are focused on their tasks and completing them despite the social cost. They could be competitive, manipulative, and condescending of others.";

            $cc['neuroicism']['high'] = "Emotionally Stable people are often good at dealing with stress, and can work well in a variety of areas. They are emotionally resilient and bounce back  fast from failures.
                ";
            $cc['neuroicism']['mid'] = "This range of emotional stability indicates more detailed assessment of the candidate in this area.";
            $cc['neuroicism']['low'] = "Those scoring low on emotional stability find it hard to deal with failure and rejection. They experience anxiety and dramatic shifts in mood.";

             $cc['openness']['high'] = "Highly open people are usually creative and can tackle change and new environments with ease. Tackling abstract concepts and new challenges is their forte.";
            $cc['openness']['mid'] = "This range of openness indicates more detailed assessment of the candidate in this area.";
            $cc['openness']['low'] = "Low open people prefer the comfort or established routines, and traditional values. They are good at following rules but may lack imagination and the ability to handle sudden change.";

            $calc['extroversion'] = [1=>'1',6=>'-6',11=>'11',16=>'-16',21=>'21',26=>'-26',31=>'31',36=>'-36',41=>'41',46=>'-46'];
            $calc['agreeableness'] = [2=>'-2',7=>'7',12=>'-12',17=>'17',22=>'-22',27=>'27',32=>'-32',37=>'37',42=>'-42',47=>'47'];
            $calc['conscientiousness'] = [3=>'3',8=>'-8',13=>'13',18=>'-18',23=>'23',28=>'-28',33=>'33',38=>'-38',43=>'43',48=>'48'];
            $calc['neuroicism'] = [4=>'-4',9=>'9',14=>'-14',19=>'19',24=>'-24',29=>'29',34=>'-34',39=>'-39',44=>'-44',49=>'-49'];
            $calc['openness'] = [5=>'5',10=>'-10',15=>'15',20=>'-20',25=>'25',30=>'-30',35=>'35',40=>'40',45=>'45',50=>'50'];

            $resp =array();$ques=array();
            foreach($tests as $t){
                $resp[$t->question_id]= $t->response;
            }

            foreach($questions as $m=>$q){
                $num = ["A"=>1,"B"=>2,"C"=>3,"D"=>4,"E"=>5];
                if($resp[$q->id])
                $questions[$m]->response = $num[$resp[$q->id]];
                else
                $questions[$m]->response = 0;
                 
                $questions[$m]->qno = substr($q->reference,1,3);
                if($resp[$q->id])
                $ques[$questions[$m]->qno] = $num[$resp[$q->id]];
                else
                $ques[$questions[$m]->qno] = 0;  
            }
            foreach($calc as $a=>$b){
                foreach($b as $i=>$k)
                if($k<0)
                    $d[$a] = $d[$a]-$ques[$i];
                else
                    $d[$a] = $d[$a]+$ques[$i];

                if($a=='neuroicism')
                    $d[$a] = 40 - $d[$a];
            }

            return view('appl.exam.assessment.analysis')
                        ->with('exam',$exam)
                        ->with('sections',$sections)
                        ->with('details',$details)
                        ->with('d',$d)
                        ->with('m',$mc)
                        ->with('c',$cc)
                        ->with('student',$student)
                        ->with('chart',true);
        }
        foreach($tests as $key=>$t){

            //dd($t->section->negative);
            if(isset($t)){
                $sum = $sum + $t->time;
                
                if(isset($t->created_at->date))
                $details['testdate'] = \carbon\carbon::parse($t->created_at->date)->diffForHumans();
                else
                $details['testdate'] = $t->created_at->diffForHumans(); 
            }
            
            if($t->status==2)
                $review = true;
            //$ques = Question::where('id',$q->id)->first();
            //dd($secs[$t->section_id]);
            if($ques_keys[$t->question_id]['topic'])
                $topics = true;

            if($t->response){
                $details['attempted'] = $details['attempted'] + 1;  
                if($t->accuracy==1){
                    $details['c'][$c]['topic'] = $ques_keys[$t->question_id]['topic'];
                    $details['c'][$c]['section'] = $ques_keys[$t->question_id]['section'];
                    $c++;
                    $details['correct'] = $details['correct'] + 1;
                    $details['correct_time'] = $details['correct_time'] + $t->time;
                    if($ques[$t->question_id]->type=='sq' || $ques[$t->question_id]->type=='urq')
                        $details['marks'] = $details['marks'] + $t->mark;
                    else
                        $details['marks'] = $details['marks'] + $secs[$t->section_id]->mark;
                }
                else{
                    $details['i'][$i]['topic'] = $ques_keys[$t->question_id]['topic'];
                    $details['i'][$i]['section'] = $ques_keys[$t->question_id]['section'];
                    $i++;
                    $details['incorrect'] = $details['incorrect'] + 1; 
                    $details['incorrect_time'] = $details['incorrect_time'] + $t->time;
                    $details['marks'] = $details['marks'] - $secs[$t->section_id]->negative; 
                }

                
            }else if($t->code){
                    $details['attempted'] = $details['attempted'] + 1; 
                    $details['i'][$i]['topic'] = $ques_keys[$t->question_id]['topic'];
                    $details['i'][$i]['section'] = $ques_keys[$t->question_id]['section'];
                    $i++;
                    $details['incorrect'] = $details['incorrect'] + 1; 
                    $details['incorrect_time'] = $details['incorrect_time'] + $t->time;
                    $details['marks'] = $details['marks'] - $secs[$t->section_id]->negative; 
            }
            else{
                $details['u'][$u]['topic'] = $ques_keys[$t->question_id]['topic'];
                $details['u'][$u]['section'] = $ques_keys[$t->question_id]['section'];
                $u++;
                $details['unattempted'] = $details['unattempted'] + 1;  
                $details['unattempted_time'] = $details['unattempted_time'] + $t->time;
                if($ques[$t->question_id]->type=='sq' || $ques[$t->question_id]->type=='urq')
                        $details['marks'] = $details['marks'] + $t->mark;
            }

            $details['total'] = $details['total'] + $secs[$t->section_id]->mark;
            //dd();

        } 
        $success_rate = $details['correct']/count($questions);
        if($success_rate > 0.7)
            $details['performance'] = 'Excellent';
        elseif(0.3 < $success_rate && $success_rate <= 0.7)
            $details['performance'] = 'Average';
        else
            $details['performance'] = 'Need to Improve';

        $details['avgpace'] = round($sum / count($questions),2);
        
        if($details['correct_time'] && $details['correct_time']>59)
            $details['correct_time'] =round($details['correct_time']/60,2).' min';
        else
            $details['correct_time'] = $details['correct_time'].' sec';
            

        if($details['incorrect_time'] && $details['incorrect_time'] > 59)
            $details['incorrect_time'] =round($details['incorrect_time']/60,2).' min';
        else
            $details['incorrect_time'] = $details['incorrect_time'].' sec';


        if($details['unattempted_time'] && $details['unattempted_time']>59)
            $details['unattempted_time'] =round($details['unattempted_time']/60,2).' min';
        else 
            $details['unattempted_time'] = $details['unattempted_time'].' sec';   
            
        

        if($request->get('cheat_detect')){
            $tests_overall = Tests_Overall::where('test_id',$exam->id)->where('user_id',$student->id)->first();
            if($request->get('cheat_detect')==3)
                $tests_overall->cheat_detect = 0;
            else
                $tests_overall->cheat_detect = $request->get('cheat_detect');
            $tests_overall->save();
        }

        if(!$topics)
        unset($details['c']);
        //dd($details);

        //dd($sections);
        $mathjax = false;
        if($subjective){
            $mathjax = true;
            $view = "analysis_subjective";
        }
        else if($exam->status==2)
            $view = "analysis_private";
        else
            $view = "analysis";

        if(request()->get('images'))
            $view = 'images';

        return view('appl.exam.assessment.'.$view)
                        ->with('exam',$exam)
                        ->with('questions',$ques)
                        ->with('sections',$sections)
                        ->with('details',$details)
                        ->with('student',$student)
                        ->with('user',$student)
                        ->with('tests',$tests)
                        ->with('test_overall',$tests_overall)
                        ->with('review',true)
                        ->with('mathjax',$mathjax)
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


    public function delete($slug,Request $request){

        if($request->get('user_id') && $request->get('test_id')){
            $user_id = $request->get('user_id');
            $test_id = $request->get('test_id');

            $attempts = Test::where('test_id',$test_id)->where('user_id',$user_id)->get();
            
            $jsonname = $slug.'_'.$user_id;

            if(Storage::disk('s3')->exists('urq/'.$jsonname.'.json')){
                $json = json_decode(Storage::disk('s3')->get('urq/'.$jsonname.'.json'),true);

                foreach($json as $q=>$ques){
                        foreach($ques as $filename=>$img){
                            echo $filename.'<br>';
                            Storage::disk('s3')->delete('urq/'.$filename);
                        }
                }
                Storage::disk('s3')->delete('urq/'.$jsonname.'.json');
            }

            

            Cache::forget('attempt_'.$user_id.'_'.$test_id);
            Cache::forget('attempts_'.$user_id);
            Cache::forget('responses_'.$user_id.'_'.$test_id);    
            Test::where('test_id',$test_id)->where('user_id',$user_id)->delete();
            Tests_Section::where('test_id',$test_id)->where('user_id',$user_id)->delete();
            Tests_Overall::where('test_id',$test_id)->where('user_id',$user_id)->delete(); 
            flash('Test attempt delete')->success();
            if($request->get('url'))
                return redirect($request->get('url'));
            else
                return redirect()->route('assessment.show',$slug);
        }
        flash('Test attempt NOT DELETED')->success();
        return redirect()->route('assessment.show',$slug);
        

    }
}
