<?php

namespace PacketPrep\Http\Controllers\Exam;

use Illuminate\Http\Request;
use PacketPrep\Http\Controllers\Controller;
use PacketPrep\Models\Exam\Exam;
use PacketPrep\User;
use PacketPrep\Models\Course\Course;
use PacketPrep\Models\Exam\Section;
use PacketPrep\Models\Exam\Examtype;
use PacketPrep\Models\Exam\Tests_Overall;
use PacketPrep\Models\Exam\Tests_Section;
use PacketPrep\Models\Dataentry\Category;
use PacketPrep\Models\Dataentry\Question;
use Illuminate\Support\Facades\Storage;
use PacketPrep\Exports\TestReport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Cache;

class ExamController extends Controller
{
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
                //update redis cache
                $obj->updateCache();

                file_put_contents($filepath, json_encode($obj,JSON_PRETTY_PRINT));

            }
           
            flash('Exams Cache Updated')->success();
        }

        if(\auth::user()->isAdmin())
        $exams = $exam->where('name','LIKE',"%{$item}%")->orderBy('created_at','desc ')->paginate(config('global.no_of_records'));
        else  
        $exams = $exam->where('user_id',\auth::user()->id)->where('name','LIKE',"%{$item}%")->orderBy('created_at','desc ')->paginate(config('global.no_of_records')); 

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
        $courses = Course::all();
        $this->authorize('create', $exam);
        $slug = rand(10000,100000);

        $e = Exam::where('slug',$slug)->first();

        if($e){
            $slug = rand(10000,100000);
        }


        return view('appl.exam.exam.createedit')
                ->with('stub','Create')
                ->with('jqueryui',true)
                ->with('editor',true)
                ->with('exam',$exam)
                ->with('slug',$slug)
                ->with('courses',$courses)
                ->with('examtypes',$examtypes);
    }


    public function sample(){
        $green = "rgba(60, 120, 40, 0.8)";
        $red = "rgba(219, 55, 50, 0.9)";
        $yellow = "rgba(255, 206, 86, 0.9)";
        $blue ="rgba(60, 108, 208, 0.8)";

        $section = new Exam;
        $section->section_id = 1;
        $section->one = 95;$section->one_color = $green;
        $section->two = 70;$section->two_color = $blue;
        $section->three = 60;$section->three_color = $yellow;
        $section->four = 90;$section->four_color = $green;
        $section->five = 90;$section->five_color = $green;
        $section->labels = ["Listening","Speaking","Reading","Writing","Grammar"];
        $section->average = 79;
        $section->suggestion = "- The Candidate is <b><span class='text-success'>Excellent</span></b> in Listening.<br> - The speaking skills are however <b><span class='text-danger'>not upto mark</span></b>.<br> - In reading <span class='text-info'>paraphrase</span> & <span class='text-info'>understanding details</span> are the areas that <b><span class='text-warning'>need attention</span></b>.<br> - Writing shows promise in <b><span class='text-success'>Grammatical accuracy</span></b> but is <b><span class='text-danger'>poor</span></b> in <span class='text-info'>spellings</span>, <span class='text-info'>parallel structures</span> and <span class='text-info'>referents</span>";
        $secs['Communication Skills'] = $section;

         $section = new Exam;
        $section->section_id = 5;
        $section->one = 85;$section->one_color = $green;
        $section->two = 90;$section->two_color = $green;
        $section->three = 70;$section->three_color = $blue;
        $section->four = 60;$section->four_color = $yellow;
        $section->five = 80;$section->five_color = $green;
        $section->labels = ["Spelling","Vocabulary","Use of English","Idiomatic Expression","Sentence Structure"];
        $section->average = 65;
        $section->suggestion = "- 
        The candidate's communicative skills are by and large <b><span class='text-success'>Excellent</span></b>. <br>
        - The <b><span class='text-warning'>average score</span></b> indicates that the candidate can communicate comfortably in a wide variety of situations in all forms of communication.<br>
        - Advanced writing and communicating in detail about technical aspects of a particular domain might cause some <b><span class='text-danger'>difficulty</span></b>.";
        $secs['Language Skills'] = $section;

        /*
        $section = new Exam;
        $section->section_id = 2;
        $section->one = 30;$section->one_color = $red;
        $section->two = 90;$section->two_color = $green;
        $section->three = 70;$section->three_color = $blue;
        $section->four = 50;$section->four_color = $yellow;
        $section->average = 50;
        $section->suggestion = "- The Candidate is <b><span class='text-success'>Excellent</span></b> in Reasoning.<br> - The qunatitative skills are however <b><span class='text-danger'>not upto mark</span></b>.<br> - In programming <span class='text-info'>code logic</span> & <span class='text-info'>syntax errors</span> are the areas that <b><span class='text-warning'>need attention</span></b>.<br> - Verbal shows promise in <b><span class='text-success'>Vocabulary </span></b> but is <b><span class='text-info'>average</span></b> in <span class='text-info'>sentence completion</span> and <span class='text-info'>reading comprehension</span> ";
        $section->labels = ["Quantitative","Reasoning","Verbal","Programming"];
        $secs['Aptitude'] = $section;

        $section = new Exam;
        $section->section_id = 3;
        $section->one = 80;$section->one_color = $blue;
        $section->two = 95;$section->two_color = $green;
        $section->three = 75;$section->three_color = $blue;
        $section->four = 85;$section->four_color = $blue;
        $section->average = 65;
        $section->suggestion = "- The Candidate is <b><span class='text-success'>Excellent</span></b> in Tech Support.<br> - However  marketing, frontdesk and operations are <b><span class='text-primary'>Good</span></b>.";
        $section->labels = ["Marketing","Tech Support","Frontdesk","Operations"];
        $secs['Domain Knowledge'] = $section;

       
     


        $section = new Exam;
        $section->section_id = 4;
        $section->one = 90;$section->one_color = $green;
        $section->two = 85;$section->two_color = $blue;
        $section->three = 30;$section->three_color = $red;
        $section->four = 70;$section->four_color = $blue;
        $section->average = 65;
        $section->suggestion = "- The candidate shows great tendency towards <b><span class='text-info'>Commitment</span></b> and <b><span class='text-info'>Time Management</span></b> .<br> - While integrity is <b><span class='text-success'>Great</span></b>, discipline  might <b><span class='text-danger'>need some attention </span></b>.";
        $section->labels = ["Integrity","Commitment","Discipline","Time Management"];
        $secs['Attitude'] = $section;
        */
        


        return view('appl.product.test.sample')->with('secs',$secs);
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


    public function owner(Request $r){

       
        $exam_id = $r->exam_id;
        $exam = Exam::where('id',$exam_id)->first();
         $this->authorize('create', $exam);
        if($r->user_id){
            $exam->user_id = $r->user_id; 
            $exam->client = User::where('id',$r->user_id)->first()->client_slug; 
            $exam->save();
            flash('Test Ownership changed')->success();
        }
      
        return redirect()->route('exam.show',$exam->slug);
 

    }

    public function copy(Request $r){
        $exam_id = $r->exam_id;
        $exam_name = $r->exam_name;
        $exam = Exam::where('id',$exam_id)->first();
        $user_id = $r->user_id;

        $this->authorize('create', $exam);

        $eslug = substr(time(),4);
        
        while(1){
            $eslug = substr(time(),4);
            $e_exists = Exam::where('slug',$eslug)->first();
            if(!$e_exists){
               break; 
            }
        }
        // create exam
        $enew = $exam->replicate();
        $enew->slug = $eslug;
        if($exam_name)
        $enew->name = $exam_name;
        $enew->user_id = $user_id;
        $enew->save();

        // create sections
        foreach($exam->sections as $s)
        {
            $snew = $s->replicate();
            $snew->user_id = $user_id;
            $snew->exam_id = $enew->id;
            $snew->save();

            //attach questions
            foreach($s->questions as $q){
                if(!$snew->questions->contains($q->id))
                    $snew->questions()->attach($q->id);
            }

        }

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
            
           
            flash('Exams Successfully Replicated')->success();
      
            return redirect()->route('exam.show',$enew->slug);


        
          

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


            
             /* If image is given upload and store path */
            if(isset($request->all()['file_'])){
                $file      = $request->all()['file_'];
                $filename = $request->get('slug').'.'.$file->getClientOriginalExtension();
                $path = Storage::disk('public')->putFileAs('articles', $request->file('file_'),$filename);

                $request->merge(['image' => $path]);
            }else{
                $request->merge(['image' => '']);
            }


            if(isset($request->all()['file2_'])){
                $file      = $request->all()['file2_'];

                $filename = $request->get('slug').'_banner.'.$file->getClientOriginalExtension();
                $path = Storage::disk('public')->putFileAs('articles', $request->file('file2_'),$filename);
            }


            $exam->name = $request->name;
            $exam->slug = $request->slug;
            $exam->user_id = $request->user_id;
            if($request->course_id)
            $exam->course_id = $request->course_id;
            $exam->examtype_id = $request->examtype_id;
            $exam->description = ($request->description) ? $request->description: null;
            $exam->instructions = ($request->instructions) ? $request->instructions : null;

            $exam->emails = ($request->emails) ? $request->emails : null;
            $exam->active = $request->active;
            $exam->camera = $request->camera;
            $exam->status = $request->status;
            $exam->solutions = $request->solutions;
            $exam->calculator = $request->calculator;
            $exam->capture_frequency = $request->capture_frequency;
            $exam->window_swap = $request->window_swap;
            $exam->auto_terminate = $request->auto_terminate;
            $exam->client = $request->client;
            if($request->auto_activation)
                $exam->auto_activation = \carbon\carbon::parse($request->auto_activation)->format('Y-m-d H:i:s');
            else
                $exam->auto_activation = null;
            if($request->auto_deactivation)
                $exam->auto_deactivation = \carbon\carbon::parse($request->auto_deactivation)->format('Y-m-d H:i:s');
            else
                $exam->auto_deactivation = null;

            $exam->code = strtoupper($request->code);


            $exam->save(); 


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
            //update redis cache
            $exam->updateCache();
           
            flash('Exams Cache Updated')->success();
      

            flash('A new exam('.$request->name.') is created!')->success();
            return redirect()->route('exam.show',$obj->slug);
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
        $exam->precheck_auto_activation();
        
        if(!\auth::user()->checkRole(['administrator','hr-manager','tpo'])){
            return redirect()->route('assessment.show',$id);
        }
        $this->authorize('view', $exam);

        if(request()->get('delete')=='banner'){
            if(Storage::disk('public')->exists('articles/'.$exam->slug.'_banner.jpg')){
                Storage::disk('public')->delete('articles/'.$exam->slug.'_banner.jpg');
             flash('Banner is deleted.')->error();
            }

        }

        if($exam)
            return view('appl.exam.exam.show')
                    ->with('exam',$exam);
        else
            abort(404);
    }

    public function accesscode($id,Request $r){
        $exam= Exam::where('slug',$id)->first();
        
        $this->authorize('create', $exam);

        $codes = explode(',',$exam->code);
        $user=array();
        foreach($codes as $k=>$code){
            $users[$k] = Tests_Overall::where('test_id',$exam->id)->where('code',$code)->count();
        }
        


        if($exam)
            return view('appl.exam.exam.reports')
                    ->with('codes',$codes)
                    ->with('user',$users)
                    ->with('exam',$exam);
        else
            abort(404);
    }

    

    public function psyreport(Request $r)
    {
        $exam= Exam::where('slug','psychometric-test')->first();

        $this->authorize('create', $exam);

        $userids =[];
        $user = \auth::user();
        foreach($user->exams as $ex){
            $ids = $ex->getUserIds()->toArray();
            foreach($ids as $i){
                array_push($userids, $i);
            }
        }
        $userids = array_unique($userids);

        $elist = $user->exams()->pluck('id')->toArray();

        $item = $r->get('item');
        $result = Tests_Overall::where('test_id',$exam->id)->whereIn('user_id',$userids)->orderby('id','desc')->get();
              
        $users = $result->pluck('user_id');
        $exam_sections = Section::where('exam_id',$exam->id)->get();
        
        $sections = Tests_Section::whereIn('user_id',$users)->where('test_id',$exam->id)->orderBy('section_id')->get()->groupBy('user_id');
        

        $search = $r->search;
        if($item){
            $users = User::whereIn('id',$users)->where('name','LIKE',"%{$item}%")
                    ->orderBy('created_at','desc ')
                    ->pluck('id');  

            $result = Tests_Overall::where('test_id',$exam->id)->whereIn('user_id',$users)->orderby('score','desc')->get();
            $exam_sections = Section::where('exam_id',$exam->id)->get();
            $sections = Tests_Section::whereIn('user_id',$users)->where('test_id',$exam->id)->orderBy('section_id')->get()->groupBy('user_id');

            
           
        }
         
        $view = $search ? 'analytics_list': 'analytics_psy';
        


        if($exam)
            return view('appl.exam.exam.'.$view)
                    ->with('report',$result)
                    ->with('exam_sections',$exam_sections)
                    ->with('sections',$sections)
                    ->with('exam',$exam);
        else
            abort(404);
    }

    public function analytics($id,Request $r)
    {
        $exam= Exam::where('slug',$id)->first();
        $this->authorize('create', $exam);
        
        $code = $r->get('code');
        $item = $r->get('item');
        $data = $r->get('score');
        if($code){
            if($data)
            $result = Tests_Overall::where('code',$code)->where('test_id',$exam->id)->orderby('score','desc')->get();
            else
            $result = Tests_Overall::where('code',$code)->where('test_id',$exam->id)->orderby('id','desc')->get();
              
            $users = $result->pluck('user_id');
            $exam_sections = Section::where('exam_id',$exam->id)->get();
            $sections = Tests_Section::whereIn('user_id',$users)->where('test_id',$exam->id)->orderBy('section_id')->get()->groupBy('user_id');

        }else{
            if($data)
            $result = Tests_Overall::where('test_id',$exam->id)->orderby('score','desc')->get();
            else
            $result = Tests_Overall::where('test_id',$exam->id)->orderby('id','desc')->get();
              
            $users = $result->pluck('user_id');
            $exam_sections = Section::where('exam_id',$exam->id)->get();
            $sections = Tests_Section::whereIn('user_id',$users)->where('test_id',$exam->id)->orderBy('section_id')->get()->groupBy('user_id');
        }



        $search = $r->search;
        if($item){
            $users = User::whereIn('id',$users)->where('name','LIKE',"%{$item}%")
                    ->orderBy('created_at','desc ')
                    ->pluck('id');  

            $result = Tests_Overall::where('test_id',$exam->id)->whereIn('user_id',$users)->orderby('score','desc')->get();
            $exam_sections = Section::where('exam_id',$exam->id)->get();
            $sections = Tests_Section::whereIn('user_id',$users)->where('test_id',$exam->id)->orderBy('section_id')->get()->groupBy('user_id');

            
           
        }
         
        $view = $search ? 'analytics_list': 'analytics';
        

        if(request()->get('export')){
            $u = User::whereIn('id',$users)->get();
            request()->session()->put('result',$result);
            request()->session()->put('sections',$sections);
            request()->session()->put('exam_sections',$exam_sections);
            request()->session()->put('users',$u);
            $ename = str_replace('/', '-', $exam->name);
            $ename = str_replace(' ', '_', $ename);
            $ename = str_replace('\\', '-', $ename);
            $name = "Report_".$ename.".xlsx";
            ob_end_clean(); // this
            ob_start(); 
            return Excel::download(new TestReport, $name);

        }


        if($exam)
            return view('appl.exam.exam.'.$view)
                    ->with('report',$result)
                    ->with('exam_sections',$exam_sections)
                    ->with('sections',$sections)
                    ->with('exam',$exam);
        else
            abort(404);
    }

    public function analyticsdeep($id,Request $r)
    {
        $exam= Exam::where('slug',$id)->first();
        $this->authorize('create', $exam);
        
        $code = $r->get('code');
        $item = $r->get('item');
        $data = $r->get('score');
        $cheat = $r->get('cheat_detect');
        if($code){
            if($data)
            $result = Tests_Overall::where('code',$code)->where('test_id',$exam->id)->orderby('score','desc')->get();
            else if($cheat)
             $result = Tests_Overall::where('code',$code)->where('test_id',$exam->id)->where('cheat_detect',$cheat)->get();   
            else
            $result = Tests_Overall::where('code',$code)->where('test_id',$exam->id)->orderby('id','desc')->get();
              
            $users = $result->pluck('user_id');
            $exam_sections = Section::where('exam_id',$exam->id)->get();
            $sections = Tests_Section::whereIn('user_id',$users)->where('test_id',$exam->id)->orderBy('section_id')->get()->groupBy('user_id');

        }else{
            if($data)
            $result = Tests_Overall::where('test_id',$exam->id)->orderby('score','desc')->get();
            else if($cheat)
            $result = Tests_Overall::where('test_id',$exam->id)->where('cheat_detect',$cheat)->get();
            else
            $result = Tests_Overall::where('test_id',$exam->id)->orderby('id','desc')->get();
              
            $users = $result->pluck('user_id');
            $exam_sections = Section::where('exam_id',$exam->id)->get();
            $sections = Tests_Section::whereIn('user_id',$users)->where('test_id',$exam->id)->orderBy('section_id')->get()->groupBy('user_id');
        }



        $search = $r->search;
        if($item){
            $users = User::whereIn('id',$users)->where('name','LIKE',"%{$item}%")
                    ->orderBy('created_at','desc ')
                    ->pluck('id');  

            $result = Tests_Overall::where('test_id',$exam->id)->whereIn('user_id',$users)->orderby('score','desc')->get();
            $exam_sections = Section::where('exam_id',$exam->id)->get();
            $sections = Tests_Section::whereIn('user_id',$users)->where('test_id',$exam->id)->orderBy('section_id')->get()->groupBy('user_id');

            
           
        }
         
        $view = $search ? 'analytics_list2': 'analytics2';
        

        if(request()->get('export')){
            $u = User::whereIn('id',$users)->get();
            request()->session()->put('result',$result);
            request()->session()->put('sections',$sections);
            request()->session()->put('exam_sections',$exam_sections);
            request()->session()->put('users',$u);
            $name = "Report_".$exam->name.".xlsx";
            ob_end_clean(); // this
            ob_start(); 
            return Excel::download(new TestReport, $name);

        }


        if($exam)
            return view('appl.exam.exam.'.$view)
                    ->with('report',$result)
                    ->with('exam_sections',$exam_sections)
                    ->with('sections',$sections)
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
        $courses = Course::all();

        $this->authorize('update', $exam);

        if($exam)
            return view('appl.exam.exam.createedit')
                ->with('stub','Update')
                ->with('jqueryui',true)
                ->with('editor',true)
                ->with('examtypes',$examtypes)
                ->with('courses',$courses)
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

            /* If image is given upload and store path */
            if(isset($request->all()['file_'])){
                $file      = $request->all()['file_'];
                $filename = $request->get('slug').'.'.$file->getClientOriginalExtension();
                $path = Storage::disk('public')->putFileAs('articles', $request->file('file_'),$filename);
                $request->merge(['image' => $path]);
            }
           
           if(isset($request->all()['file2_'])){
                Storage::disk('public')->delete('articles/'.$exam->slug.'_banner.jpg');
                Storage::disk('public')->delete('articles/'.$exam->slug.'_banner.png');
                $file      = $request->all()['file2_'];
                $filename = $request->get('slug').'_banner.'.$file->getClientOriginalExtension();
                $path = Storage::disk('public')->putFileAs('articles', $request->file('file2_'),$filename);
            }


            //dd($request->all());
            $exam->name = $request->name;
            $exam->slug = $request->slug;
            if($request->course_id)
            $exam->course_id = $request->course_id;
            $exam->examtype_id = $request->examtype_id;
            $exam->description = ($request->description) ? $request->description: null;
            $exam->instructions = ($request->instructions) ? $request->instructions : null;
            $exam->status = $request->status;
            if($request->image)
            $exam->image = $request->image;
            $exam->solutions = $request->solutions;
            $exam->emails = ($request->emails) ? $request->emails : null;
            $exam->active = $request->active;
            $exam->camera = $request->camera;
            $exam->calculator = $request->calculator;
            $exam->client = $request->client;
            if(!$request->camera)
                $exam->capture_frequency = 0;
            else
                $exam->capture_frequency = $request->capture_frequency;
            $exam->window_swap = $request->window_swap;
            if(!$request->window_swap)
                $exam->auto_terminate = 0;
            else
                $exam->auto_terminate = $request->auto_terminate;
            
            if($request->auto_activation)
                $exam->auto_activation = \carbon\carbon::parse($request->auto_activation)->format('Y-m-d H:i:s');
            else
                $exam->auto_activation = null;
            if($request->auto_deactivation)
                $exam->auto_deactivation = \carbon\carbon::parse($request->auto_deactivation)->format('Y-m-d H:i:s');
            else
                $exam->auto_deactivation = null;
            $exam->code = strtoupper($request->code);
            $exam->save(); 

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

            //update redis cache
            $exam->updateCache();


            
            file_put_contents($filepath, json_encode($obj,JSON_PRETTY_PRINT));
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
        foreach($exam->sections as $section){
            $section->questions()->detach();
            $section->delete();
        }

        $this->authorize('update', $exam);

        
        $exam->delete();

        flash('Exam Successfully deleted!')->success();
        return redirect()->route('exam.index');
    }
}
