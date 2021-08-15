<?php

namespace PacketPrep\Http\Controllers\Exam;

use Illuminate\Http\Request;
use PacketPrep\Http\Controllers\Controller;
use PacketPrep\Models\Exam\Exam;
use PacketPrep\User;
use PacketPrep\Models\Course\Course;
use PacketPrep\Models\Exam\Section;
use PacketPrep\Models\Exam\Examtype;
use PacketPrep\Models\Product\Test;
use PacketPrep\Models\Exam\Tests_Overall;
use PacketPrep\Models\Exam\Tests_Section;
use PacketPrep\Models\Dataentry\Category;
use PacketPrep\Models\Dataentry\Question;
use Illuminate\Support\Facades\Storage;
//use PacketPrep\Exports\TestReport;
use PacketPrep\Exports\TestReport2;
use PacketPrep\Exports\SectionExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Cache;
use PacketPrep\Models\College\Branch;
use PacketPrep\Models\College\College;

use PacketPrep\Jobs\SendEmail;
use PacketPrep\Jobs\writing;
use PacketPrep\Jobs\PdfDownload;
use PacketPrep\Mail\EmailForQueuing;

use Illuminate\Support\Facades\Input;
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;

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
        $user = \auth::user();
        $testtype = $request->get('testtype');

        $examtype = Examtype::where('slug',$testtype)->first();
        if($request->Get('refresh')){
            Cache::forget('examtypes_'.subdomain());
        }
        $examtypes = Cache::get('examtypes_'.subdomain());
    
        if(!$examtypes){
            $examtypes = Examtype::where('client',subdomain())->withCount('exams')->get();
            Cache::forever('examtypes_'.subdomain(),$examtypes);
        }

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

        if($examtype){
             if(\auth::user()->isAdmin())
            $exams = $exam->where('name','LIKE',"%{$item}%")->where('examtype_id',$examtype->id)->orderBy('created_at','desc ')->withCount('users')->with('user')->paginate(config('global.no_of_records'));
            elseif(subdomain()==strtolower(env('APP_NAME'))){
                if($user->role==10 || $user->role==11 || $user->role==12 || $user->role==13){
                    $exams = $exam->where('name','LIKE',"%{$item}%")->where('examtype_id',$examtype->id)->where('user_id',$user->id)->orderBy('created_at','desc ')->withCount('users')->with('user')->paginate(config('global.no_of_records'));
                }
            }
            elseif($user->role==10 || $user->role==11 || $user->role==12 || $user->role==13){
            $exams = $exam->where('name','LIKE',"%{$item}%")->where('examtype_id',$examtype->id)->where('client',subdomain())->orderBy('created_at','desc ')->withCount('users')->with('user')->paginate(config('global.no_of_records'));
            }
            else
            $exams = $exam->where('user_id',\auth::user()->id)->where('examtype_id',$examtype->id)->where('name','LIKE',"%{$item}%")->with('user')->withCount('users')->orderBy('created_at','desc ')->paginate(config('global.no_of_records'));

        }else{

            if(\auth::user()->isAdmin())
            $exams = $exam->where('name','LIKE',"%{$item}%")->orderBy('created_at','desc ')->withCount('users')->with('user')->paginate(config('global.no_of_records'));
             elseif(subdomain()==strtolower(env('APP_NAME'))){
                if($user->role==10 || $user->role==11 || $user->role==12 || $user->role==13){
                    $exams = $exam->where('name','LIKE',"%{$item}%")->where('user_id',$user->id)->orderBy('created_at','desc ')->withCount('users')->with('user')->paginate(config('global.no_of_records'));
                }
            }
            elseif($user->role==10 || $user->role==11 || $user->role==12 || $user->role==13){
            $exams = $exam->where('name','LIKE',"%{$item}%")->where('client',subdomain())->orderBy('created_at','desc ')->withCount('users')->with('user')->paginate(config('global.no_of_records'));
            }
            else
            $exams = $exam->where('user_id',\auth::user()->id)->where('name','LIKE',"%{$item}%")->with('user')->withCount('users')->orderBy('created_at','desc ')->paginate(config('global.no_of_records'));
        }

        



        $view = $search ? 'list': 'index';

        return view('appl.exam.exam.'.$view)
        ->with('exams',$exams)->with('exam',$exam)->with('examtypes',$examtypes);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $exam = new Exam();
        $examtypes = Examtype::where('client',subdomain())->get();

        $hr_managers = \auth::user()->getRole('hr-manager');

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
                ->with('hr_managers',$hr_managers)
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


       if($slug == 'general-english' || $slug =='programming-concepts-2' || $slug=='data-structures')
       foreach($siblings as $s){
            $inner = $s->descendants()->get();

            $result[$s->name] = $s->questions->pluck('id')->toArray();
                if(count($result[$s->name])!=0){
                   $id = array_rand($result[$s->name],1);
                   $ques[++$k] = $result[$s->name][$id];
                }
       }

       if($slug == 'logical-reasoning' || $slug == 'mental-ability' || $slug == 'verbal-ability-1'  )
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


        $section_sequence = $r->get('section_sequence');
        if($section_sequence){
            $seq = explode(',',$section_sequence);


            if(count($seq)!=count($exam->sections))
            {
                flash('Mismatch in the number of sections ')->success();
                return redirect()->route('exam.show',$exam->slug);
            }else{
                foreach($seq as $a=>$sq)
                    $sections[$a] =  $exam->sections[$sq];
            }

        }else{
            $sections = $exam->sections;
        }

        // create sections
        foreach($sections as $s)
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

                //file_put_contents($filepath, json_encode($obj,JSON_PRETTY_PRINT));
            $obj->updateCache();

            flash('Exams Successfully Replicated')->success();

            return redirect()->route('exam.show',$enew->slug);





    }

    public function createExamLoop($request,$n)
    {
        //create exam
        $exam = new Exam();
        $exam->name = $request->name;

        $random = substr(md5(mt_rand()), 0, 7);
        $exam->slug = $request->slug.$random;
        $exam->user_id = \auth::user()->id;
        $exam->instructions = $request->instructions;
        $exam->description= $request->description;
        $exam->status = $request->status;
        $exam->examtype_id = $request->examtype_id;//general
        $count = 15;
        $e = Exam::where('slug',$exam->slug)->first();

        if(!$e)
            $exam->save();
        else
            $exam =$e;


        //create sections
        for($k=1;$k<6;$k++){

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


                   $count = intval(count($ques_set)/3);

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
                if(strtolower($file->getClientOriginalExtension()) == 'jpeg')
                    $extension = 'jpg';
                else
                    $extension = strtolower($file->getClientOriginalExtension());
                $filename = $request->get('slug').'.'.$extension;

                $path = Storage::disk('s3')->putFileAs('articles', $request->file('file_'),$filename,'public');

                $request->merge(['image' => $path]);
            }else{
                $request->merge(['image' => '']);
            }


            if(isset($request->all()['file2_'])){
                $file      = $request->all()['file2_'];

                if(strtolower($file->getClientOriginalExtension()) == 'jpeg')
                    $extension = 'jpg';
                else
                    $extension = strtolower($file->getClientOriginalExtension());

                $filename = $request->get('slug').'_banner.'.$extension;
                $path = Storage::disk('s3')->putFileAs('articles', $request->file('file2_'),$filename,'public');
            }

            $exam->extra = $request->get('extra');
            $viewers = $request->get('viewers');
            if($viewers){
                $exam->viewers()->wherePivot('role','viewer')->detach();
                foreach($viewers as $v){
                    if(!$exam->viewers->contains($v))
                        $exam->viewers()->attach($v,['role'=>'viewer']);
                }
            }else{
                $exam->viewers()->detach();
            }

            $evaluators = $request->get('evaluators');
            if($evaluators){
                $exam->evaluators()->wherePivot('role','evaluator')->detach();
                foreach($evaluators as $ev){
                    if(!$exam->evaluators->contains($ev))
                        $exam->evaluators()->attach($ev,['role'=>'evaluator']);
                }
            }else{
                $exam->evaluators()->detach();
            }

            //add owner
            if(!$exam->viewers->contains($exam->user_id))
                $exam->viewers()->attach($exam->user_id,['role'=>'owner']);

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
            $exam->shuffle = $request->shuffle;
            $exam->message = $request->message;
            $exam->save = $request->save;
            $exam->extra = $request->extra;

            $settings = array();
            $settings['chat'] = $request->get('chat');
            $settings['manual_approval'] = $request->get('manual_approval');
            $settings['section_timer'] = $request->get('section_timer');
            $settings['section_marking'] = $request->get('section_marking');
            $settings['fullscreen'] = $request->get('fullscreen');
            $settings['upload_time'] = $request->get('upload_time');
            $settings['camera360'] = $request->get('camera360');
            $settings['videosnaps'] = $request->get('videosnaps');
            $settings['totalmarks'] = $request->get('totalmarks');
            $settings['reattempt'] = $request->get('reattempt');
            $settings['system_check'] = $request->get('system_check');
            $settings['email_verified'] = $request->get('email_verified');
            $settings['form_fields'] = $request->get('form_fields');

            

            $exam->settings = json_encode($settings);
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

                //file_put_contents($filepath, json_encode($obj,JSON_PRETTY_PRINT));
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



    public function pdfupload($id,Request $request){

        $exam= Cache::remember('exam_'.$id,30, function() use ($id){
            return Exam::where('slug',$id)->with('user')->with('sections')->first();
        });
        $user = \auth::user();
        if(request()->get('student')){
            $this->authorize('view', $exam);
            $user = User::where('username',request()->get('student'))->first();
        }
        


        $filepath = 'pdfuploads/'.$exam->slug.'/'.$exam->slug.'_'.$user->username.'.pdf';

        $file = 0;
        if(Storage::disk('s3')->exists($filepath)){
            $file = Storage::disk('s3')->url($filepath);
        }

        $url  = \App::call('PacketPrep\Http\Controllers\AwsController@getAwsUrl',[$filepath]);

        $ua = strtolower($_SERVER['HTTP_USER_AGENT']);
        $isMob = is_numeric(strpos($ua, "mobile"));

        if($exam)
            return view('appl.exam.exam.pdfupload')
                    ->with('file',$file)
                    ->with('url',$url)
                    ->with('user',$user)
                    ->with('ismob',$isMob)
                    ->with('exam',$exam);
        else
            abort(404);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        $exam= Cache::remember('exam_admin_'.$id,30, function() use ($id){
            return Exam::where('slug',$id)->with('user')->with('sections')->withCount('users')->first();
        });

        $exam->precheck_auto_activation();

        if(!\auth::user()->checkRole(['administrator','hr-manager','tpo'])){
            return redirect()->route('assessment.show',$id);
        }
        $this->authorize('view', $exam);

        if(request()->get('refresh')){
            flash('Cache data refreshed.')->success();
            Cache::forget('users_'.$exam->slug.'_'.subdomain());
            Cache::forget('latest_users_admin'.$id);
            Cache::forget('hr_managers_'.$id);
            Cache::forget('examtype_obj_'.$id);
            Cache::forget('exam_sections_'.$id);
            foreach(explode(',',$exam->code) as $code)
                Cache::forget('exam_code_'.$code);
            foreach($exam->sections as $section)
                Cache::forget('exam_ques_'.$section->id);

            $exam->changeImageUrls();
            //update redis cache
            $exam->updateCache();
        }

        if(request()->get('delete')=='banner'){
            if(Storage::disk('public')->exists('articles/'.$exam->slug.'_banner.jpg')){
                Storage::disk('public')->delete('articles/'.$exam->slug.'_banner.jpg');
             flash('Banner is deleted.')->error();
            }

        }
        $emails = implode(',',explode("\n", $exam->emails));
        $emails =str_replace("\r", '', $emails);
        $emails = array_unique(explode(',',$emails));


        if(request()->get('sendemail')){
            $this->mailer($emails);
        }

        // if($exam->extra){
        //   $extra = json_decode($exam->extra,true);
        //   $exam->viewers = User::whereIn('id',$extra['viewers'])->get();
        //   $exam->evaluators = User::whereIn('id',$extra['evaluators'])->get();
        // }


        $email_stack['total'] =[];
        if($exam->emails){

            $users = Cache::remember('users_'.$exam->slug.'_'.subdomain(),240, function() use($emails){
                return User::where('client_slug',subdomain())->whereIn('email',$emails)->get();
            });
             $inusers = array_unique($users->pluck('email')->toArray());

            $email_stack['total'] = [];
            $email_stack['registered'] =$email_stack['not_registered'] =[];
            $count = $count2=0;
            foreach($emails as $e){
                if(in_array($e, $inusers)){
                    array_push($email_stack['registered'], $e);
                }else{
                    array_push($email_stack['not_registered'], $e);
                }
                array_push($email_stack['total'], $e);

            }

            // foreach($users as $ux)
            // if(request()->get('refresh2')){
            //     $cache_data =  Cache::get('responses_'.$ux->id.'_'.$exam->id);
            //     if($cache_data)
            //     Storage::disk('s3')->put('cache_attempts_'.$exam->slug.'/'.'attempt_'.$ux->id.'_'.$exam->id.'.json',json_encode($cache_data));
            //     else{
            //         Storage::disk('s3')->put('cache_attempts_none_'.$exam->slug.'/'.'attempt_'.$ux->id.'_'.$exam->id.'.json',json_encode($cache_data));
            //     }
            // }
        }else{
            $email_stack['registered'] = [];
            $email_stack['not_registered'] =  [];
        }

        $data['attempt_count'] = $exam->users_count;
        if($data['attempt_count'])
            $data['users'] = Cache::remember('latest_users_admin'.$id, 60, function() use ($exam) {
                return $exam->latestUsers();
            });
        else
            $data['users'] = 0;

        $data['hr-managers'] = Cache::remember('hr_managers_'.$id, 60, function()  {
                return \auth::user()->getRole('hr-manager');
            });

     

        $data['examtype'] = Cache::remember('examtype_obj_'.$id, 60, function()use ($exam)   {
                return $exam->examtype;
            });

        $data['sections'] = Cache::remember('exam_sections_'.$id, 60, function()use ($exam)   {
                return $exam->sections()->with('questions')->get();
            });
        foreach(explode(',',$exam->code) as $code)
            $data['code_'.$code] = Cache::remember('exam_code_'.$code, 60, function()use ($exam,$code)   {
                return $exam->getAttemptCount($code);
            });

       $exam_cache = Cache::get('exam_cache_'.$exam->id);

       $settings = json_decode($exam->getOriginal('settings'),true);



        if(isset($settings['chat']))
            $exam->chat = $settings['chat'];
        else
            $exam->chat = 'no';

        if(isset($settings['manual_approval']))
            $exam->manual_approval = $settings['manual_approval'];
        else
            $exam->manual_approval = 'no';

        if(isset($settings['section_timer']))
            $exam->section_timer = $settings['section_timer'];
        else
            $exam->section_timer = 'no';

        if(isset($settings['section_marking']))
            $exam->section_marking = $settings['section_marking'];
        else
            $exam->section_marking = 'no';

        $set_name = 'set_'.$exam->slug.'_0';
        $sets = Cache::get($set_name);


        if(count($exam->sections)==3)
            $exam->mid = 1;
        else
            $exam->mid = 0;

        if($sets){
            $exam->qcount = 0;
            foreach($sets as $s)
                $exam->qcount = $exam->qcount + count($s);

            $exam->sets = 1;
        }
        else
            $exam->sets = 0;

        if(isset($settings['invigilation']))
            $exam->invigilation = 1;
        else
            $exam->invigilation = 0;


        if($exam)
            return view('appl.exam.exam.show')
                    ->with('exam',$exam)
                    ->with('cache',$exam_cache)
                    ->with('data',$data)
                    ->with('select',1)
                    ->with('email_stack',$email_stack);
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


    public function mailer($emails){

        foreach($emails as $i=>$email){
            $details['email'] = $email;

            $subject = 'JNET Round 1 Result & Round 2 Test Link';
            $content = '<p>The cut off for Round 1 is 53 marks. You can check your score at <a href="https://xplore.co.in/test/084682/analysis">https://xplore.co.in/test/084682/analysis</a> </p>
              <p>Students who have crossed cut off can attempt any one of the following tests </p>
              <p><div>.NET & React Test URL: <a href="https://xplore.co.in/test/481567 ">https://xplore.co.in/test/481567</a> <br>
                Access Code: JNETRJFSD <br>

                Link Expires on : 13th May 2021, 10AM </div></p>
                <p><div>.NET & Angular Test URL: <a href="https://xplore.co.in/test/481567 ">https://xplore.co.in/test/481567</a> <br>
                Access Code: JNETRJFSD <br>

                Link Expires on : 13th May 2021, 10AM </div></p>
                <div class="default-style">
                    <br>Note : 1)You can take test only in<strong>&nbsp;Laptop/desktop&nbsp;.</strong>
                   </div>
                   <div class="default-style">
                    &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; 2) Please register at&nbsp;<a href="https://xplore.co.in/register">Xplore.co.in/register&nbsp;</a>&nbsp;before taking the test
                   </div>
                   <div class="default-style">
                    <br>&nbsp; &nbsp; &nbsp;
                    <br>Instructions:
                    <ul>
                     <li>Each question carries 1 mark and no negative marking</li>
                     <li><strong>Mandatory</strong>: This is a AI proctored examination and you are required to keep your web-camera on in the entire duration of the examination failing which, you might not get selected</li>
                     <li>The test should be taken only from&nbsp;<strong>desktop/laptop with webcam</strong>&nbsp;facilities. Mobile Phones and Tabs are restricted</li>
                     <li>Please make sure that you&nbsp;<strong>disable all desktop notifications</strong>. Else, the test will be terminated in between</li>
                     <li>Please make sure that you have uninterrupted power and internet facility (minimum 2 MBPS required)</li>
                     <li>Please make sure that your camera is switched on and you are facing the light source</li>
                    </ul>For step by step process of Xplore assessment please click the below link
                    <br>
                    <br><a href="https://xplore.co.in/files/User_Manual_ZenQ_Assessment.pdf">https://xplore.co.in/files/User_Manual_ZenQ_Assessment.pdf</a>
                    <br>
                    <br>
                ';

            //Mail::to($details['email'])->send(new EmailForQueuing($details,$subject,$content));
            SendEmail::dispatch($details,$subject,$content)->delay(now()->addSeconds($i*3));
        }

        dd('Email Queued - '.count($emails));
        return view('home');
    }


    public function proctorlist($id, Request $r){
        $exam= Exam::where('slug',$id)->first();


         $this->authorize('update', $exam);
         
        $item = $r->get('item');

        $settings = $exam->getOriginal('settings');

        $candidates = array();
        $students = array();
        if($settings){
            $settings = json_decode($settings,true);
            if(isset($settings['invigilation']))
            $candidates = $settings['invigilation'];

            foreach($candidates as $id=>$e){
                foreach($e as $em){
                    $it = explode('@',$em);
                    $students[$it[0]] = $id;
                }
            }
        }


        if($item){
            $uids = $exam->viewers()->wherePivot('role','viewer')->pluck('id')->toArray();
            $viewers = User::whereIn('id',$uids)->where('name','LIKE',"%{$item}%")->get();

            if(!count($viewers)){
                $uids=$students[$item];
                $viewers = User::where('id',$uids)->get();
            }
        }
        else
            $viewers = $exam->viewers()->wherePivot('role','viewer')->get();




        if(count($candidates))
        foreach($viewers as $m=>$u){
            $viewers[$m]->candidates = $candidates[$u->id];

            if(request()->get('refresh'))
            Cache::forget('candidates_'.$exam->slug.'_'.$viewers[$m]->username);

            if(isset($viewers[$m]->username))
                Cache::forget('candidates_'.$exam->slug.'_'.$viewers[$m]->username);
        }
        else
            foreach($viewers as $m=>$u){
            $viewers[$m]->candidates = array();
        }


        if($viewers)
         return view('appl.exam.exam.proctorlist')
                    ->with('exam',$exam)
                    ->with('data',$viewers);
        else
            abort('403','Proctors not assigned');
        //foreach($exam->viewers()->wherePivot('role','viewer')->get())

    }


    public function questionlist($id, Request $r){
        $exam= Exam::where('slug',$id)->first();
        $this->authorize('create', $exam);

        $questions = [];
        $i=0;
        $data = array("level1"=>0,"level2"=>0,"level3"=>0,'no_level'=>0,'total'=>0,"mark_1"=>0,"mark_2"=>0,"mark_3"=>0,"mark_4"=>0,"mark_5"=>0);
        $data['time'] = 0;
        foreach($exam->sections as $section){
            
            if($r->get('set'))
            $qset = $exam->getQuestionsSection($section->id,$r->get('set'));
            else if( $r->get('set')!=null)
            $qset = $exam->getQuestionsSection($section->id,$r->get('set'));
            else
            $qset = $section->questions;


            $k=0;
            foreach( $qset as $q){
                if($i==0){
                    $id = $q->id;
                }



                if($r->get('fix_topic')){
                    $q->topic = str_replace(' ','',strtolower($q->topic));
                    $q->save();
                }

                $q->section_name = $section->name;
                $questions[$i] = $q;
                $data['time'] = $data['time'] + $section->time;

                $i++;
            }
        }


        foreach($questions as $q){
            if($q->level==3)
                    $data['level3']++;
                elseif($q->level==2)
                    $data['level2']++;
                elseif($q->level==1)
                    $data['level1']++;
                else
                    $data['no_level']++;


                if($q->mark==5)
                    $data['mark_5']++;
                 if($q->mark==4)
                    $data['mark_4']++;
                 if($q->mark==3)
                    $data['mark_3']++;
                 if($q->mark==2)
                    $data['mark_2']++;
                 if($q->mark==1)
                    $data['mark_1']++;



                if(!isset($data['topic'][$q->topic])){
                    $data['topic'][$q->topic] = 1;
                }
                else{
                    $data['topic'][$q->topic]++;
                }

                if(!$q->topic){
                    if(!isset($data['topic']['no_topic']))
                    $data['topic']['no_topic'] =0;
                    else
                    $data['topic']['no_topic']++;
                }
                $data['total']++;
        }


        if(request()->get('paper'))
            return view('appl.exam.exam.questionlist2')
                    ->with('mathjax',true)
                    ->with('highlight',true)
                    ->with('exam',$exam)
                    ->with('qdata',$data)
                    ->with('set',$r->get('set'))
                    ->with('data',$questions);

        else if($questions)
         return view('appl.exam.exam.questionlist')
                    ->with('mathjax',true)
                    ->with('highlight',true)
                    ->with('exam',$exam)
                    ->with('qdata',$data)
                    ->with('set',$r->get('set'))
                    ->with('data',$questions);
        else
            abort('403','No questions created');


    }

    public function candidatelist($id, Request $r){
        $exam= Exam::where('slug',$id)->first();

        $emails = implode(',',explode("\n", $exam->emails));
        $emails =str_replace("\r", '', $emails);
        $emails = array_unique(explode(',',$emails));

        $item = $r->get('item');

        if(count($emails)==1)
        if($emails[0]==""){
            return view('appl.exam.exam.nofile')
                    ->with('exam',$exam)
                    ->with('active',1)
                    ->with('message',"Candidates emails are not assigned");
        }



        if($item)
        $users = User::where('client_slug',subdomain())->whereIn('email',$emails)->where('username','LIKE',"%{$item}%")->get()->keyBy('username');
        else
        $users = User::where('client_slug',subdomain())->whereIn('email',$emails)->orderby('roll_number','asc')->get()->keyBy('username');




        $viewers = $exam->viewers()->wherePivot('role','viewer')->get()->keyBy('id');
        $settings = $exam->getOriginal('settings');

        $candidates = null;
        if($settings){
            $settings = json_decode($settings,true);
            $candidates = $settings['invigilation'];
        }


        $proctors = array();
        if($candidates)
        {
            foreach($candidates as $ids=>$emails){

                foreach($emails as $e){
                    $it = explode('@',$e);
                    $proctors[$e] = $ids;

                    //$users->$it = $ids;

                }

            }

            //$proctors[]
        }

        $files = Storage::disk('s3')->allFiles('testlog/'.$exam->id.'/log/');
        $candidates = [];



        foreach($files as $f){
            $p = explode('/',$f);
            if(isset($p[3])){
                $id_p = explode('_',$p[3]);

                if(isset($id_p[0])){
                    $uid = $id_p[0];
                    $cache = Cache::get('exam_candidates_'.$exam->id.'_'.$uid);


                    $candidates[$uid] = $f;
                    if(!$cache){
                        $data = json_decode(Storage::disk('s3')->get($f),true);
                        $items = [];
                        $item['os_details'] = null;
                        if(isset($data['os_details']))
                        $item['os_details'] =$data['os_details'];

                        $first_activity = 0;
                        $item['time'] = 0;
                        foreach($data['activity'] as $m=>$dt){
                            $first_activity = $m;
                            $item['time'] = date("m/d/Y h:i:s A T",$first_activity);
                            break;
                        }


                        $cache = Cache::remember('exam_candidates_'.$exam->id.'_'.$uid,240,function() use($item){
                            return $item;
                        });
                        $candidates[$uid] = $item;
                    }else{
                        $candidates[$uid] = $cache;
                    }

                }
            }
        }



        if($users)
         return view('appl.exam.exam.candidatelist')
                    ->with('exam',$exam)
                    ->with('proctors',$viewers)
                    ->with('emails',$proctors)
                    ->with('candidates',$candidates)
                    ->with('data',$users);
        else
            abort('403','Candidates not assigned');
        //foreach($exam->viewers()->wherePivot('role','viewer')->get())

    }


    public function user_roles($id, Request $r){

        $data = array('invigilation'=>0);
        $exam= Exam::where('slug',$id)->with('sections')->first();
        $candidates = null;

         $this->authorize('update', $exam);

        if($r->get('_token')){

            Cache::forget('test_'.$exam->slug);
            $viewers = $r->get('viewers');
            if($viewers){
                $exam->viewers()->wherePivot('role','viewer')->detach();
                foreach($viewers as $v){

                    Cache::forget('userexamroles_'.$v);
                    if(!$exam->viewers()->wherePivot('role','viewer')->find($v))
                        $exam->viewers()->attach($v,['role'=>'viewer']);
                }
            }

            if($exam->viewers()->wherePivot('role','viewer')->get()){
                if($exam->emails){
                    $emails = implode(',',explode("\n", $exam->emails));
                    $emails =str_replace("\r", '', $emails);
                    $emails = array_unique(explode(',',$emails));
                    $candidates = count($emails);
                    //shuffle($emails);


                    $viewers = $exam->viewers()->wherePivot('role','viewer')->get();
                    if(count($viewers))
                    $count = intval(ceil(count($emails)/count($viewers)));
                    else
                        $count = 0;




                    $set = [];
                    foreach($viewers as $m=>$v){
                        $set[$v->id] = array_slice($emails,$m*$count,$count);
                        //var_dump($count);


                        // if(count($viewers)-1==$m){
                        //     $mod = count($emails)% $count;
                        //     $leftout = array_slice($emails,-$mod,$mod);
                        //     $set[$v->id] = array_merge($set[$v->id],$leftout);
                        // }

                    }
                    $settings = json_decode($exam->settings,true);

                    //dd($settings);
                    $settings['invigilation'] = $set;
                    $exam->settings = json_encode($settings);
                    //dd($exam->settings);
                    $exam->save();


                }
            }



            $evaluators = $r->get('evaluators');

            if($evaluators){
                //dd($exam);
                $exam->evaluators()->wherePivot('role','evaluator')->detach();
                foreach($evaluators as $ev){

                    Cache::forget('userexamroles_'.$ev);
                    if(!$exam->evaluators()->wherePivot('role','evaluator')->find($ev)){

                        $exam->evaluators()->attach($ev,['role'=>'evaluator']);
                    }
                }
            }

            //dd($viewers);
            Cache::forever('test_'.$exam->slug,$exam);



        }

        //dd($exam->settings);


        $exam_settings = json_decode($exam->settings,true);
        if(isset($exam_settings['invigilation']))
            $data['invigilation'] = $exam_settings['invigilation'];

        if($exam->emails && !$candidates){
            $emails = implode(',',explode("\n", $exam->emails));
            $emails =str_replace("\r", '', $emails);
            $emails = array_unique(explode(',',$emails));
            $candidates = count($emails);
        }

        //dd($data);
        $data['viewers'] = $exam->viewers()->wherePivot('role','viewer')->where('status','<>',2)->pluck('id')->toArray();
        $data['evaluators'] = $exam->viewers()->wherePivot('role','evaluator')->where('status','<>',2)->pluck('id')->toArray();


        $data['hr-managers'] = \auth::user()->getRole('hr-manager');



        $data['candidates'] = $candidates;

        if($r->get('evaluator')){
            //return redirect()->to('test.user_roles',['test'=>$exam->slug])->with('evaluator',1);
            $view = 'evaluators';
        }
        else
            $view = 'viewers';

        if($exam)
            return view('appl.exam.exam.'.$view)
                    ->with('exam',$exam)

                    ->with('data',$data);
        else
            abort(404);
    }

    public function set_creator($id,Request $r){
        $exam= Exam::where('slug',$id)->with('sections')->first();


         if($r->get('delete')){

            foreach($exam->sections as $sec){
                    $sec->instructions = '';
                    $sec->save();
            }

            for($i=0;$i<10;$i++){
                $name = 'set_'.$exam->slug.'_'.$i;
                Storage::disk('s3')->delete('paper_set/'.$exam->id.'/'.$name.'.json');
                Cache::forget($name);
            }
        }

        if($r->get('_token')){


            foreach($exam->sections as $sec){
                    $sec->instructions = $r->get($sec->id);
                    $sec->save();
            }

            for($i=0;$i<10;$i++){
                foreach($exam->sections as $sec){
                        $formula = json_decode($r->get($sec->id));
                        $qset = $sec->questions;

                        $ques[$sec->id] = $exam->pool_qset($qset,$formula);
                        //
                }


                $name = 'set_'.$exam->slug.'_'.$i;
                Storage::disk('s3')->put('paper_set/'.$exam->id.'/'.$name.'.json',json_encode($ques));
                Cache::forever($name,$ques);
            }



        }

        $questions = [];$data = array('no_topic'=>0,'level'=>0,'qcount'=>0);
        foreach($exam->sections as $sec){
            foreach($sec->questions as $q){
                $questions[$q->id] = $q;
                $data['qcount']++;
                if(!$q->topic)
                    $data['no_topic']++;

                if(!$q->level)
                    $data['level']++;
            }
        }

        $paper_sets = [];$paper_count= [];
        for($i=0;$i<10;$i++){
            $name = 'set_'.$exam->slug.'_'.$i;
            $s3 = 'paper_set/'.$exam->id.'/'.$name.'.json';
            if(Cache::get($name)){
                $paper_sets[$i] = Cache::get($name);
                $paper_count[$i] = 0;
                foreach($paper_sets[$i] as $s=>$qid){
                    $paper_count[$i] = $paper_count[$i] + count($qid);
                }

            }else if(Storage::disk('s3')->exists($s3)){
                $paper_sets[$i] = json_decode(Storage::disk('s3')->get($s3),true);
                Cache::forever($name,$paper_sets[$i]);
                $paper_count[$i] = 0;
                foreach($paper_sets[$i] as $s=>$qid){
                    $paper_count[$i] = $paper_count[$i] + count($qid);
                }
            }

        }

        if($exam)
            return view('appl.exam.exam.set_creator')
                    ->with('exam',$exam)
                    ->with('paper_sets',$paper_sets)
                    ->with('paper_count',$paper_count)
                    ->with('data',$data);
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

    protected function paginateAnswers(array $answers, $perPage = 10)
    {
        $page = Input::get('page', 1);

        $offset = ($page * $perPage) - $perPage;

        $paginator = new LengthAwarePaginator(
            array_slice($answers, $offset, $perPage, true),
            count($answers),
            $perPage,
            $page,
            ['path' => request()->url(), 'query' => request()->query()]
        );

        return $paginator;
    }

    public function analytics($id,Request $r)
    {

        $exam = Cache::get('test_'.$id);
        if(!$exam)
         $exam= Exam::where('slug',$id)->first();
        $this->authorize('create', $exam);

        $code = $r->get('code');
        $item = $r->get('item');
        $data = $r->get('score');

        if($r->get('refresh')){
            Cache::forget('exam_sections_'.$exam->id);
            Cache::forget('tests_overall_'.$exam->id.'_'.$data);
            Cache::forget('sections_'.$exam->id.'_data');
            Cache::forget('users_'.$exam->id.'_data');
            flash('Reports refreshed')->success();
        }

        if($r->get('removeduplicates')){

            $exam->removeDuplicates();
            return redirect()->back();
        }

        if($r->get('imagerollback')){
            $rep =  Tests_Overall::where('test_id',$exam->id)->with('user')->orderby('score','desc')->get();
            
            foreach($rep as $rx){
                $student = $rx->user;
                $user_id = $student->id;
                $jsonname = $exam->slug.'_'.$user_id;

                if(Storage::disk('s3')->exists('urq/'.$jsonname.'.json'))
                    $images = json_decode(Storage::disk('s3')->get('urq/'.$jsonname.'.json'),true);
                else
                    $images = [];
                $exam->image_rollback($images,$jsonname,$student);
                

            }
            return redirect()->back();
        }

       if($r->get('writing')){
            $rep =  Tests_Overall::where('test_id',$exam->id)->with('user')->orderby('score','desc')->get();
            foreach($rep as $rx){
                writing::dispatch($rx->user,$exam,'writing',null)->delay(now()->addMinutes(1));
            }
            flash('Wrting Evaluation is queued! Will be completed in sometime!')->success();
            return redirect()->back();
        }

        if($r->get('audio')){
            $rep =  Tests_Overall::where('test_id',$exam->id)->with('user')->orderby('score','desc')->get();
            foreach($rep as $rx){
                foreach($exam->sections as $section){
                    //$qset = $section->questions;
                    $qset = $exam->getQuestionsSection($section->id,$rx->user->id);
                    foreach($qset as $q)
                    {
                        if($q->type=='aq')
                          writing::dispatch($rx->user,$exam,'audio',$q->id);
                      
                    }
                }
                
            }
            flash('Audio Evaluation is queued! Will be completed in sometime!')->success();
            return redirect()->back();
        }

        if($code){
            if($data)
            $result = Tests_Overall::where('code',$code)->where('test_id',$exam->id)->with('user')->orderby('score','desc')->get();
            else
            $result = Tests_Overall::where('code',$code)->where('test_id',$exam->id)->with('user')->orderby('id','desc')->get();

            $res = $result;
            $users = $result->pluck('user_id');
            $result = $this->paginateAnswers($result->toArray(),30);

            $exam_sections = Section::where('exam_id',$exam->id)->get();
            $sections = Tests_Section::whereIn('user_id',$users)->where('test_id',$exam->id)->orderBy('section_id')->get()->groupBy('user_id');

        }else{

          $result =  Cache::get('tests_overall_'.$exam->id.'_'.$data);

          if(!$result){
            if($data)
            $result = Tests_Overall::where('test_id',$exam->id)->with('user')->orderby('score','desc')->get();
            else
            $result = Tests_Overall::where('test_id',$exam->id)->with('user')->orderby('id','desc')->get();
            Cache::put('tests_overall_'.$exam->id.'_'.$data,$result,120);
          }


            $res =$result;
            $users = $result->pluck('user_id');
            $result = $this->paginateAnswers($result->toArray(),30);
            $exam_sections = Cache::remember('exam_sections_'.$exam->id,240,function() use($exam){
                return Section::where('exam_id',$exam->id)->get();
            });

            $sections =  Cache::get('sections_'.$exam->id.'_data');
            if(!$sections){
                $sections = Tests_Section::whereIn('user_id',$users)->where('test_id',$exam->id)->orderBy('section_id')->get()->groupBy('user_id');
                Cache::put('sections_'.$exam->id.'_data',$sections,120);
            }


        }


       


        if($r->get('pdf')){
            foreach($res as $m=>$rx){

                PdfDownload::dispatch($exam->slug,$rx->user->username)->delay(now()->addSeconds($m+2));
                
            }
        }

        if($r->get('refresh')){
            foreach($res as $m=>$rx){
                Cache::forget('resp_'.$rx->user->id.'_'.$exam->id);
            }
        }


        $search = $r->search;
        if($item){
            $users = User::whereIn('id',$users)->where('name','LIKE',"%{$item}%")->orWhere('roll_number','LIKE',"%{$item}%")
                    ->orderBy('created_at','desc ')
                    ->pluck('id');

            $result = Tests_Overall::where('test_id',$exam->id)->whereIn('user_id',$users)->with('user')->orderby('score','desc')->paginate(30);
            $exam_sections = Section::where('exam_id',$exam->id)->get();
            $sections = Tests_Section::whereIn('user_id',$users)->where('test_id',$exam->id)->orderBy('section_id')->get()->groupBy('user_id');
        }

        $ux =  Cache::get('users_'.$exam->id.'_data');
        if(!isset($ux[0])){
          $ux = User::whereIn('id',$users)->get()->keyBy('id');
          Cache::put('users_'.$exam->id.'_data',$ux,120);
        }


        $view = $search ? 'analytics_list': 'analytics';

        $ename = str_replace('/', '-', $exam->name);
        $ename = str_replace(' ', '_', $ename);
        $ename = str_replace('\\', '-', $ename);
        $filename ="exports/Report_".$ename.".xlsx";

        $email_stack = array();
        $data_ques =null;
        if(request()->get('export')){

            if(isset($exam->settings->form_fields)){
                if($exam->settings->form_fields){
                    $extra = $exam->settings->form_fields;
                    $data_ques = $exam->questions($extra);
                   
                }
            }

           

            if($code)
                $result = Tests_Overall::where('test_id',$exam->id)->where('code',$code)->orderby('score','desc')->get();
            else
                $result = Tests_Overall::where('test_id',$exam->id)->orderby('score','desc')->with('user')->get();

            if(request()->get('rollnumber')){
                foreach($result as $g => $f){
                    if($result[$g]->user->roll_number)
                    $result[$g]['rollnumber'] = $result[$g]->user->roll_number;
                    else
                    $result[$g]['rollnumber'] = 0; 
                }
                $result = $result->sortBy(function($it)
                        {
                          return $it->rollnumber;
                        });
            }
            
           
            $usrs = $result->pluck('user_id');
            $exam_sections = Section::where('exam_id',$exam->id)->get();
            $sections = Tests_Section::whereIn('user_id',$usrs)->where('test_id',$exam->id)->orderBy('section_id')->get()->groupBy('user_id');
            $colleges = College::all()->keyBy('id');
            $branches = Branch::all()->keyBy('id');
            request()->session()->put('colleges',$colleges);
            request()->session()->put('branches',$branches);
            request()->session()->put('data_ques',$data_ques);

            if(!Storage::disk('s3')->exists($filename))
                Storage::disk('s3')->delete($filename);

           // dd($sections);

            if($exam->emails){
                $emails = implode(',',explode("\n", $exam->emails));
                $emails =str_replace("\r", '', $emails);
                $emails = array_unique(explode(',',$emails));
               

                $users_result = User::whereIn('id',$usrs->toArray())->get()->keyBy('id');
                $result_users = $users_result->pluck('email')->toArray();
                $result_users_ids = $users_result->pluck('id')->toArray();

                $subdomain = $exam->client;

                $users = User::where('client_slug',$subdomain)->whereIn('email',$emails)->get()->keyBy('id');

                $inusers = array_unique($users->pluck('email')->toArray());
                // $email_stack['registered'] = array_unique($users->pluck('email')->toArray());

                $email_stack['total'] = [];
                $email_stack['registered'] =$email_stack['not_registered'] =[];
                $count = $count2=0;
                foreach($emails as $e){

                    if(in_array($e ,$inusers)){
                        array_push($email_stack['registered'], $e);
                    }else{
                        array_push($email_stack['not_registered'], $e);
                    }
                    array_push($email_stack['total'], $e);

                }



                // $uids = array_unique($users->pluck('id')->toArray());
                // $attempted = [];//array_unique($result->pluck('user_id')->toArray());

                // $notattempted =  [];//array_diff($email_stack['registered'],$result_users);
                // $nonusers = array_diff($emails,$email_stack['registered']);

                // foreach($email_stack['registered'] as $em){
                //     if(!in_array($em, $result_users)){
                //         array_push($notattempted,$em);
                //     }else{
                //         array_push($attempted,$em);

                //     }
                // }

                $attemptedby = User::whereIn('email',$email_stack['registered'])->get()->pluck('id')->toArray();


                $res = $result->whereIn('user_id',$attemptedby);


                //dd($count);
                foreach($attemptedby as $k=>$u){
                    if(!in_array($u, $result_users_ids)){
                        $rs = new Tests_Overall();
                        $rs->created_at = now();
                        $rs->user_id = $u;
                        $rs->test_id = $exam->id;
                        $rs->window_change = '-';
                        $rs->cheat_detect = 3;
                        $rs->score = 'ABSENT';
                        $result->push($rs);
                    }

                }



            }else{
                $email_stack['registered'] = [];
                $email_stack['not_registered'] =  [];
            }




            // foreach($notattempted as $k=>$u){
            //     if(!in_array($u, $attemptedby)){
            //         $rs = new Tests_Section();
            //         $rs->user_id = $u;
            //         $rs->test_id = $exam->id;
            //         $rs->score = '';
            //         $sections->push($rs);
            //     }
            // }


            // foreach($users as $u){

            //     if()
            // }

            $usr = \auth::user();
            if(count($users)>0){
                $exam->total = 0;
                foreach($exam_sections as $k=>$s){
                    $exam_sections[$k]->total = 0;
                }

                foreach($exam_sections as $k=>$s){
                    $qset = $exam->getQuestionsSection($s->id,$usr->id);
                    if($exam->settings->section_marking=='no'){
                        foreach($qset as $q)
                            $exam_sections[$k]->total = $exam_sections[$k]->total + intval($q->mark);
                        $exam->total = $exam->total + $exam_sections[$k]->total;
                    }else{
                        $exam_sections[$k]->total = count($s->questions) * $s->mark;
                        $exam->total = $exam->total + $exam_sections[$k]->total;
                    } 
                }

                request()->session()->put('exam',$exam);
                request()->session()->put('result',$result);
                request()->session()->put('sections',$sections);
                request()->session()->put('exam_sections',$exam_sections);
                request()->session()->put('email_stack',$email_stack);

                ob_end_clean(); // this
                ob_start();
                $filename ="Report_".$ename.".xlsx";
                return Excel::download(new TestReport2, $filename);
            }else{

                // request()->session()->put('result',$result);
                // request()->session()->put('sections',$sections);
                // request()->session()->put('exam_sections',$exam_sections);
                // request()->session()->put('users',$usrs);
                // //ini_set('memory_limit', '1024M');
                // Excel::store(new TestReport, $filename,'s3');
                // flash('Export is queued, it will be ready for download in 5min.')->success();
                // dd('Export is queued, it will be ready for download in 5min.');
            }

        }


        if(request()->get('downloadsection')){
            if($code)
              $result = Tests_Overall::where('test_id',$exam->id)->where('code',$code)->orderby('score','desc')->get();
            else
              $result = Tests_Overall::where('test_id',$exam->id)->orderby('score','desc')->get();

            $usrs = $result->pluck('user_id');
            $exam_sections = Test::whereIn('user_id',$usrs)->where('test_id',$exam->id)->where('section_id',request()->get('downloadsection'))->with('user')->get();  



            $q = $exam_sections->pluck('question_id');
            $ques = Question::whereIn('id',$q)->get()->keyBy('id');

            request()->session()->put('sections',$exam_sections);
            request()->session()->put('questions',$ques);

            ob_end_clean(); // this
            ob_start();
            $filename ="section_".request()->get('downloadsection')."_".$ename.".xlsx";
            return Excel::download(new SectionExport, $filename);
        }

        if(request()->get('downloadexport')){
            if(!Storage::disk('s3')->exists($filename))
                flash('Report is not available. Re-queue the data after 5 mins.')->success();
            else{
                $file = Storage::disk('s3')->get($filename);

                $headers = [
                    'Content-Type' => 'text/csv',
                    'Content-Description' => 'File Transfer',
                    'Content-Disposition' => "attachment; filename={$filename}",
                    'filename'=> $filename
                ];
                return response($file, 200, $headers);
            }
        }

        // return view('appl.pages.about')->with('url',1)->with('report',$result)
        // ->with('r',$res)
        // ->with('exam_sections',$exam_sections)
        // ->with('sections',$sections)
        // ->with('exam',$exam)
        // ->with('users',$ux);
        if($exam)
            return view('appl.exam.exam.'.$view)
                    ->with('report',$result)
                    ->with('r',$res)
                    ->with('exam_sections',$exam_sections)
                    ->with('sections',$sections)
                    ->with('exam',$exam)
                    ->with('users',$ux);
        else
            abort(404);
    }


     public function analytics4($id,Request $r)
    {
        $exam= Exam::where('slug',$id)->first();
        $this->authorize('create', $exam);

        $code = $r->get('code');
        $item = $r->get('item');
        $data = $r->get('score');


        if($data)
            $result = Tests_Overall::where('test_id',$exam->id)->orderby('score','desc')->paginate(100);
            else
            $result = Tests_Overall::where('test_id',$exam->id)->orderby('id','desc')->paginate(100);

            $res = Tests_Overall::where('test_id',$exam->id)->get();

            $users = $result->pluck('user_id');
            $exam_sections = Section::where('exam_id',$exam->id)->get();
            $sections = Tests_Section::whereIn('user_id',$users)->where('test_id',$exam->id)->orderBy('section_id')->get()->groupBy('user_id');



        $search = $r->search;


        $ux = User::whereIn('id',$users)->get()->keyBy('id');

        $view = $search ? 'analytics_list2': 'analytics2';






        if($exam)
            return view('appl.exam.exam.'.$view)
                    ->with('report',$result)
                    ->with('r',$res)
                    ->with('exam_sections',$exam_sections)
                    ->with('sections',$sections)
                    ->with('exam',$exam)
                    ->with('liveimage',1)
                    ->with('users',$ux);
        else
            abort(404);
    }


     public function analytics3($slug,Request $request)
    {

        $search = $request->search;
        $item = $request->item;
        $obj = Exam::where('slug',$slug)->first();


        $this->authorize('view', $obj);

        $u = $obj->users->pluck('user_id')->toArray();

        $users = User::whereIn('id',$u)->get();

        $data['colleges'] = Cache::remember('college',240,function(){
                    return College::orderBy('name')->get()->keyBy('id');
                });

        $data['branches'] = Cache::remember('branche',240,function(){
                    return Branch::orderBy('name')->get()->keyBy('id');
                });
        $data['total'] = count($users);
        $data['college_group'] = $users->groupBy('college_id');
        $data['branch_group'] = $users->groupBy('branch_id');
        $data['yop_group'] = $users->groupBy('year_of_passing');
        $data['no_video'] = count($users->where('video',''));
        $data['video'] = $data['total'] - $data['no_video'];

        // if(request()->get('sendmail_video')){
        //     $this->mailer($users);
        // }


        $view ='analytics3';

        return view('appl.'.$this->app.'.'.$this->module.'.'.$view)
                ->with('users',$users)
                ->with('data',$data)
                ->with('obj',$obj)
                ->with('app',$this);
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


        $examtypes = Examtype::where('client',subdomain())->get();
        $hr_managers = \auth::user()->getRole('hr-manager');
        $courses = Course::all();

        $settings = json_decode($exam->getOriginal('settings'),true);

        if(isset($settings['chat']))
            $exam->chat = $settings['chat'];
        else
            $exam->chat = 'no';

        if(isset($settings['manual_approval']))
            $exam->manual_approval = $settings['manual_approval'];
        else
            $exam->manual_approval = 'no';

        if(isset($settings['section_timer']))
            $exam->section_timer = $settings['section_timer'];
        else
            $exam->section_timer = 'no';

        if(isset($settings['section_marking']))
            $exam->section_marking = $settings['section_marking'];
        else
            $exam->section_marking = 'no';

         if(isset($settings['fullscreen']))
            $exam->fullscreen = $settings['fullscreen'];
        else
            $exam->fullscreen = 'yes';

        if(isset($settings['upload_time']))
            $exam->upload_time = $settings['upload_time'];
        else
            $exam->upload_time = 0;
         if(isset($settings['camera360']))
            $exam->camera360 = $settings['camera360'];
        else
            $exam->camera360 = 0;
        if(isset($settings['videosnaps']))
            $exam->videosnaps = $settings['videosnaps'];
        else
            $exam->videosnaps = 0;

        if(isset($settings['totalmarks']))
            $exam->totalmarks = $settings['totalmarks'];
        else
            $exam->totalmarks = null;

         if(isset($settings['reattempt']))
            $exam->reattempt = $settings['reattempt'];
        else
            $exam->reattempt = null;

        if(isset($settings['system_check']))
            $exam->system_check = $settings['system_check'];
        else
            $exam->system_check = null;

        if(isset($settings['email_verified']))
            $exam->email_verified = $settings['email_verified'];
        else
            $exam->email_verified = null;

        if(isset($settings['form_fields']))
            $exam->form_fields = $settings['form_fields'];
        else
            $exam->form_fields = null;

        // if($exam->extra){
        //     $exam->viewers = json_decode($exam->extra,true)['viewers'];
        //     $exam->evaluators = json_decode($exam->extra,true)['evaluators'];
        // }

        $this->authorize('update', $exam);

        if($exam)
            return view('appl.exam.exam.createedit')
                ->with('stub','Update')
                ->with('jqueryui',true)
                ->with('editor',true)
                ->with('examtypes',$examtypes)
                ->with('courses',$courses)
                ->with('hr_managers',$hr_managers)
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
            $exam = Exam::where('slug',$slug)->with('examtype')->first();

            $this->authorize('update', $exam);

            /* If image is given upload and store path */
            if(isset($request->all()['file_'])){
                $file      = $request->all()['file_'];

                if(strtolower($file->getClientOriginalExtension()) == 'jpeg')
                    $extension = 'jpg';
                else
                    $extension = strtolower($file->getClientOriginalExtension());

                $filename = $request->get('slug').'.'.$extension;
                $path = Storage::disk('s3')->putFileAs('articles', $request->file('file_'),$filename,'public');
                $request->merge(['image' => $path]);
            }

           if(isset($request->all()['file2_'])){
                Storage::disk('s3')->delete('articles/'.$exam->slug.'_banner.jpg');
                Storage::disk('s3')->delete('articles/'.$exam->slug.'_banner.png');
                $file      = $request->all()['file2_'];

                if(strtolower($file->getClientOriginalExtension()) == 'jpeg')
                    $extension = 'jpg';
                else
                    $extension = strtolower($file->getClientOriginalExtension());
                $filename = $request->get('slug').'_banner.'.$extension;
                $path = Storage::disk('s3')->putFileAs('articles', $request->file('file2_'),$filename,'public');
            }


            $exam->extra = $request->get('extra');
            $viewers = $request->get('viewers');
            if($viewers){
                $exam->viewers()->wherePivot('role','viewer')->detach();
                foreach($viewers as $v){
                    Cache::forget('userexamroles_'.$v);
                    if(!$exam->viewers()->wherePivot('role','evaluator')->find($v))
                        $exam->viewers()->attach($v,['role'=>'viewer']);
                }
            }

            $evaluators = $request->get('evaluators');
            if($evaluators){
                //dd($exam);
                $exam->evaluators()->wherePivot('role','evaluator')->detach();
                foreach($evaluators as $ev){
                    Cache::forget('userexamroles_'.$ev);
                    if(!$exam->evaluators()->wherePivot('role','evaluator')->find($ev)){
                        $exam->evaluators()->attach($ev,['role'=>'evaluator']);
                    }
                }
            }

            //add owner
            if(!$exam->viewers->contains($exam->user_id))
                $exam->viewers()->attach($exam->user_id,['role'=>'owner']);


            $settings = json_decode($exam->getOriginal('settings'),true);
            $settings['chat'] = $request->get('chat');
            $settings['manual_approval'] = $request->get('manual_approval');
            $settings['section_timer'] = $request->get('section_timer');
            $settings['section_marking'] = $request->get('section_marking');
            $settings['fullscreen'] = $request->get('fullscreen');
            $settings['upload_time'] = $request->get('upload_time');
            $settings['camera360'] = $request->get('camera360');
            $settings['videosnaps'] = $request->get('videosnaps');
            $settings['totalmarks'] = $request->get('totalmarks');
            $settings['reattempt'] = $request->get('reattempt');
            $settings['system_check'] = $request->get('system_check');
            $settings['email_verified'] = $request->get('email_verified');
            $settings['form_fields'] = $request->get('form_fields');




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
            $exam->client =  $exam->user->client_slug;
            $exam->shuffle = $request->shuffle;
            $exam->message = $request->message;
            $exam->save = $request->save;
            $exam->extra = $request->extra;
            $exam->settings = json_encode($settings);

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
            $exam->updateCache();

            //file_put_contents($filepath, json_encode($obj,JSON_PRETTY_PRINT));
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



        $Tests_Overall = Tests_Overall::where('test_id',$id)->with('user')->get();
        foreach($Tests_Overall as $t){
            $user = $t->user;
            $user_id = $user->id;
            $username =$user->username;
            $test_id = $id;


            // $attempts = Test::where('test_id',$test_id)->where('user_id',$user_id)->get();

            // $jsonname = $slug.'_'.$user_id;
            // $user = User::where('id',$user_id)->first();

            // if(Storage::disk('s3')->exists('urq/'.$jsonname.'.json')){
            //     $json = json_decode(Storage::disk('s3')->get('urq/'.$jsonname.'.json'),true);

            //     foreach($json as $q=>$ques){
            //             foreach($ques as $filename=>$img){
            //                 echo $filename.'<br>';
            //                 Storage::disk('s3')->delete('urq/'.$filename);
            //             }
            //     }
            //     Storage::disk('s3')->delete('urq/'.$jsonname.'.json');
            // }

            // if(Storage::disk('s3')->exists('testlog/'.$test_id.'/'.$user->username.'.json')){
            //     Storage::disk('s3')->delete('testlog/'.$test_id.'/'.$user->username.'.json');
            // }

            //  if(Storage::disk('s3')->exists('testlog/'.$test_id.'/log/'.$user->username.'_log.json')){
            //     Storage::disk('s3')->delete('testlog/'.$test_id.'/log/'.$user->username.'_log.json');
            // }

            // if(Storage::disk('s3')->exists('testlog/'.$test_id.'/chats/'.$user->username.'.json')){
            //     Storage::disk('s3')->delete('testlog/'.$test_id.'/chats/'.$user->username.'.json');
            // }

            // if(Storage::disk('s3')->exists('testlog/approvals/'.$test_id.'/'.$user->username.'.json')){
            //     Storage::disk('s3')->delete('testlog/approvals/'.$test_id.'/'.$user->username.'.json');
            // }


            // $name = 'testlog/pre-message/'.$exam->id.'/'.$user->username.'.json';
            // if(Storage::disk('s3')->exists($name)){
            //     Storage::disk('s3')->delete($name);
            // }




            Cache::forget('attempt_'.$user_id.'_'.$test_id);
            Cache::forget('attempts_'.$user_id);
            Cache::forget('responses_'.$user_id.'_'.$test_id);

            Test::where('test_id',$test_id)->where('user_id',$user_id)->delete();
            Tests_Section::where('test_id',$test_id)->where('user_id',$user_id)->delete();
            Tests_Overall::where('test_id',$test_id)->where('user_id',$user_id)->delete();

        }

        foreach($exam->sections as $section){
            $section->questions()->detach();
            $section->delete();
        }



        $exam->delete();

        flash('Exam Successfully deleted!')->success();
        return redirect()->route('exam.index');
    }
}
