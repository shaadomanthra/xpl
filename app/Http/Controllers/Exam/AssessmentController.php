<?php

namespace PacketPrep\Http\Controllers\Exam;

use Illuminate\Http\Request;
use PacketPrep\Http\Controllers\Controller;
use PacketPrep\Models\Dataentry\Tag;
use PacketPrep\Models\Product\Client;
use PacketPrep\Models\Dataentry\Question;
use PacketPrep\Models\Dataentry\Passage;

use PacketPrep\Models\College\College;
use PacketPrep\Models\College\Branch;

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
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;
use PDF;

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

        // if(\auth::user())
        //     $user = \auth::user();
        // else
        //     $user = User::where('username','krishnateja')->first();

        $examtypes = Examtype::where('client',subdomain())->withCount('exams')->get();

        $filter = $request->get('filter');
        $search = $request->search;
        $item = $request->item;

        $client = (subdomain())?subdomain():'xplore';

        if($filter){

            $examtype = $examtypes->where('slug',$filter)->first();

            if($examtype){
                $exams = $exam->where('name','LIKE',"%{$item}%")->where('examtype_id',$examtype->id)->orderBy('created_at','desc ')->where('client',$client)->with('sections')->paginate(config('global.no_of_records'));
            }else{
                $exams = null;
            }


        }
        else
            $exams = $exam->where('name','LIKE',"%{$item}%")->where('client',$client)->with('sections')->paginate(config('global.no_of_records'));

        $view = $search ? 'list': 'index';

        return view('appl.exam.assessment.'.$view)
            ->with('exams',$exams)->with('exam',$exam)->with('examtypes',$examtypes);


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

        $user = \auth::user();

        $data['branches'] = Cache::get('branches');
       $data['colleges'] = Cache::get('colleges');

        if($user)
            $responses = Cache::get('responses_'.$user->id.'_'.$exam->id);
        else
            $responses = null;
        if($exam->active){
            if(!$responses)
                return view('appl.exam.assessment.inactive')->with('exam',$exam);
        }else if($exam->status==0){
            abort(403,'Test is in draft state');
        }

        $time=0;
        foreach($exam->sections as $sec){
            $time = $time  + $sec->time;
        }
        $exam->time = $time;


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
        else{
            //dd(count($exam->products));
            if(count($exam->products)){
                 $products = $exam->products->pluck('id')->toArray();
            }else
                $products = null;
        }
        $product = null;

        

        $test_taken = $user->attempted_test($exam->id);//Test::where('test_id',$exam->id)->where('user_id',$user->id)->first();

        if($test_taken)
            return redirect()->route('assessment.analysis',$exam->slug);

        if(!$code){
           if($exam->status == 2){

            $entry=null;
            if($user){
                if($products){
                    $entry = Cache::remember('entry_'.$exam->id.'_'.$user->id, 240, function() use($products,$user){
                        return DB::table('product_user')
                    ->whereIn('product_id', $products)
                    ->where('user_id', $user->id)
                    ->first();
                    });
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
        $username = \auth::user()->username;
        if($exam->camera){
            $folder = 'webcam/'.$exam->id.'/';
            $name_prefix = $folder.\auth::user()->username.'_'.$exam->id.'_';
            $url['selfie'] = \App::call('PacketPrep\Http\Controllers\AwsController@getAwsUrl',[$name_prefix.'selfie.jpg']);
            $url['idcard'] = \App::call('PacketPrep\Http\Controllers\AwsController@getAwsUrl',[$name_prefix.'idcard.jpg']);

            $url['approval']  = '';
            $url['pre_message'] = '';
            if(true){
                $name = 'testlog/approvals/'.$exam->id.'/'.$username.'.json';
                $url['approval'] = \App::call('PacketPrep\Http\Controllers\AwsController@getAwsUrl',[$name]);
                $name = 'testlog/pre-message/'.$exam->id.'/'.$username.'.json';
                $url['pre_message'] = \App::call('PacketPrep\Http\Controllers\AwsController@getAwsUrl',[$name]);

                $jsonfile = 'testlog/approvals/'.$exam->id.'/'.$username.'.json';
                if(Storage::disk('s3')->exists($jsonfile)){
                  $candidate  = json_decode(Storage::disk('s3')->get($jsonfile),true);

                }else{
                    $candidate = [];
                    $candidate['approved'] = 0;
                    $candidate['terminated'] = 0;
                    $candidate['status'] = 0;
                    $candidate['message']='';
                }




                $candidate['name'] =  \auth::user()->name;
                $candidate['username'] =  \auth::user()->username;
                $candidate['rollnumber'] =  \auth::user()->roll_number;
                $candidate['college'] = "";

                if(\auth::user()->college_id)
                    if(isset($data['colleges'][\auth::user()->college_id]))
                        $candidate['college'] = $data['colleges'][\auth::user()->college_id]->name;


                $candidate['branch'] =  '';

                if(\auth::user()->branch_id)
                    if(isset($data['colleges'][\auth::user()->college_id]))
                     $candidate['branch'] = $data['colleges'][\auth::user()->college_id]->name;


                $candidate['image'] =   \auth::user()->getImage();
                $candidate['selfie'] = '';
                $candidate['idcard'] = '';
                $candidate['time'] = strtotime(now());
                Storage::disk('s3')->put($jsonfile, json_encode($candidate),'public');


            }

        }else{
            $url = null;
        }




        $responses = Cache::get('responses_'.$user->id.'_'.$exam->id);





        return view('appl.exam.assessment.instructions')
                ->with('exam',$exam)->with('responses',$responses)
                ->with('camera',$exam->camera)->with('terms',1)
                ->with('data',$data)
                ->with('url',$url);
    }





    public function try2($test,$id=null, Request $request)
    {
        $filename = $test.'.json';
        $filepath = $this->cache_path.$filename;
        $json_log =null;



       $exam = Cache::get('test_'.$test);
       $data['branches'] = Cache::get('branches');
       $data['colleges'] = Cache::get('colleges');
       $data['sid'] = null;
       $data['qid'] = null;
       $data['sno'] = 1;
       $data['last'] = null;
       $data['first'] = null;
       $data['stopswap'] = 0;
       $data['slast'] = 'mcq';
       $data['vcount'] = 0;
       $data['upload_urls'] = [];
       $cc = 0 ;




        if(!$exam)
        if(file_exists($filepath))
        {
            $exam = json_decode(file_get_contents($filepath));
        }else{
            $exam = Exam::where('slug',$test)->first();
        }

        if(!$exam)
            abort('404','Test not found');

        $user = \auth::user();

        if($user)
            $responses = Cache::get('responses_'.$user->id.'_'.$exam->id);
        else
            $responses = null;


        $section_timer =  false;

        if(isset($exam->settings->section_timer))
            if($exam->settings->section_timer=='yes')
                $section_timer = true;
        

        if($exam->active){
            if(!$responses)
                return view('appl.exam.assessment.inactive')->with('exam',$exam);
        }else if($exam->status==0){
            abort(403,'Test is in draft state');
        }

        if($request->get('student') && $request->get('admin')){
            $user = User::where('username',$request->get('student'))->first();
            $responses = Test::where('test_id',$exam->id)->where('user_id',$user->id)->get();

        }else{

            $user = \auth::user();


            if(Storage::disk('s3')->exists('testlog/'.$exam->id.'/'.$user->username.'.json')){
                $json = json_decode(Storage::disk('s3')->get('testlog/'.$exam->id.'/'.$user->username.'.json'),true);

                $responses = $json['responses'];

                if(isset($json['qid'])){
                    $data['qid'] = $json['qid'];
                    $data['sno'] = $json['qno'];
                }

                if(isset($json['c']))
                $cc = $json['c'];

                if(is_array($responses))
                {
                    $responses = collect($responses);
                }
            }else{
                    $responses = null;
            }

             if(Storage::disk('s3')->exists('testlog/'.$exam->id.'/log/'.$user->username.'_log.json')){
                $json_log = Storage::disk('s3')->get('testlog/'.$exam->id.'/log/'.$user->username.'_log.json');
            }


        }


        if($request->get('dump')){
            dd($json);
        }


        $jsonname = $test.'_'.$user->id;


        if(Storage::disk('s3')->exists('urq/'.$jsonname.'.json'))
            $images = json_decode(Storage::disk('s3')->get('urq/'.$jsonname.'.json'),true);

        else{
            $images = [];
            Storage::disk('s3')->put('urq/'.$jsonname.'.json',json_encode($images),'public');
        }

        $window_change = true;

        if(!$request->get('admin'))
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

        $test_taken = false;
        if(!$request->get('admin')){
        $test_taken = $user->attempted_test($exam->id);
        if($test_taken)
            return redirect()->route('assessment.analysis',$exam->slug);
        }

        if(!$code){
           if($exam->status == 2){
            $entry=null;
            if($user){
                if($products){
                     $entry = Cache::remember('entry_'.$exam->id.'_'.$user->id, 240, function() use($products,$user){
                        return DB::table('product_user')
                    ->whereIn('product_id', $products)
                    ->where('user_id', $user->id)
                    ->first();
                    });
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
        $url3 = null;
        $time_used = 0;
        $code_ques =[];
        $csq=0;
        $passages = array();
        $dynamic =array();
        $section_questions = array();
        $imgs=[];
        foreach($exam->sections as $section){
            $qset = $exam->getQuestionsSection($section->id,$user->id);//$section->questions;

            //shuffle($qset);
            if($exam->shuffle){
                if(!$responses){
                    $qset = $qset->shuffle();
                }else{
                    
                    $ids = array_keys($responses->keyBy('question_id')->toArray());
                    $ids_ordered = implode(',', $ids);
                    
                    $qset = $section->questions()->whereIn('id', $ids)
                         ->orderByRaw("FIELD(id, $ids_ordered)")
                         ->get();
                }
            }


            $k=0;
            foreach($qset as $e=>$q){

                if($data['qid']){
                    if($q->id == $data['qid']){
                        $data['sid'] = $section->id; 
                        $data['stime'] = $section->time;
                        if(count($qset)==$e+1){
                            $data['last'] = 1;
                        }else if($e==0){
                            $data['first'] = 1;

                        }
                    } 
                }
                if($exam->shuffle){
                    if(!$responses){
                        $q->dynamic = rand(1,4);
                        $q->response = null;
                        $q->time = 0;

                    }else{

                        $keys = $responses->keyBy('question_id');

                        if($request->get('dump'))
                            dd($keys);
                        if(is_array($keys[$q->id])){
                            $q->dynamic = $keys[$q->id]['dynamic'];
                            //dd($keys[$q->id]['response']);
                            if(!isset($keys[$q->id]['response']))
                                $q->response = null;
                            else

                            $q->response = $keys[$q->id]['response'];
                            $q->time = $keys[$q->id]['time'];
                            if(isset($keys[$q->id]['code']))
                                $q->code = $keys[$q->id]['code'];

                            
                        }else{
                            $q->dynamic = $keys[$q->id]->dynamic;
                            if(!isset($keys[$q->id]->response))
                                $q->response = null;
                            else
                                $q->response = $keys[$q->id]->response;
                            $q->time = $keys[$q->id]->time;
                            if(isset($keys[$q->id]->code))
                            $q->code = $keys[$q->id]->code;


                        }

                        if(!$section_timer)
                         $time_used = $time_used + intval($q->time);
                        else{
                            if($data['sid']==$section->id)
                                $time_used = $time_used + intval($q->time);
                        }


                    }
                }
                else{
                    $q->dynamic = 1;
                    if(!$responses){
                        $q->response = null;
                        $q->time =0;
                    }else{
                        $keys = $responses->keyBy('question_id');

                        if($request->get('dump'))
                            dd($keys);
                        if(is_array($keys[$q->id])){
                            $q->dynamic = $keys[$q->id]['dynamic'];
                            //dd($keys[$q->id]['response']);
                            if(!isset($keys[$q->id]['response']))
                                $q->response = null;
                            else

                            $q->response = $keys[$q->id]['response'];
                            $q->time = $keys[$q->id]['time'];
                            if(isset($keys[$q->id]['code']))
                            $q->code = $keys[$q->id]['code'];

                            $time_used = $time_used + intval($q->time);
                        }else{
                            $q->dynamic = $keys[$q->id]->dynamic;
                            if(!isset($keys[$q->id]->response))
                                $q->response = null;
                            else
                                $q->response = $keys[$q->id]->response;
                            $q->time = $keys[$q->id]->time;
                            if(isset($keys[$q->id]->code))
                            $q->code = $keys[$q->id]->code;

                            $time_used = $time_used + intval($q->time);

                        }

                    }
                }


                if(isset($images)){
                    if(isset($images[$q->id])){
                        $q->images = $images[$q->id];
                        foreach($q->images as $ids=>$qe){
                            $imgs[$q->id]['c'] = str_replace('a','',$ids);
                        }
                    }
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
                if($q->type=='code' || $q->type=='csq'){
                    $code_ques[$i]=1;
                    //$window_change = false;
                    if($q->type=='csq')
                        $csq=1;
                }
                elseif($q->type=='vq'){
                    $folder = 'webcam/'.$exam->id.'/';
                    $name_prefix = $folder.\auth::user()->username.'_'.$exam->id.'_';
                    $url3['video_'.$q->id] = \App::call('PacketPrep\Http\Controllers\AwsController@getAwsUrl',[$name_prefix.'video_'.$q->id.'.webm']);
                    $data['slast'] = $q->type;
                    $data['vcount']++;
                }elseif($q->type=='urq'){
                    $folder = 'urq/';
                    for($k=1;$k<6;$k++){
                        $name = $folder.$exam->slug.'_'.\auth::user()->id.'_'.$q->id.'_'.$k;
                        $filename_ = $name.'.jpg';
                        $url3['urq_'.$q->id.'_'.$k] = \App::call('PacketPrep\Http\Controllers\AwsController@getAwsUrl',[$filename_]);
                        
                    }

                    if(!isset($images[$q->id])){
                        $images[$q->id] =[];
                    }
                    
                }

                
            }

        }

        if($images){
             Storage::disk('s3')->put('urq/'.$jsonname.'.json',json_encode($images),'public');
        }

        $url3['urq_user'] = Storage::disk('s3')->url('urq/'.$jsonname.'.json');
        $url3['urq_userpost'] = \App::call('PacketPrep\Http\Controllers\AwsController@getAwsUrl',['urq/'.$jsonname.'.json']);

        // time
        foreach($exam->sections as $k=>$section){
            $time = $time + $section->time;

            if($k==1)
                $exam->section_next = $section->id;

           
            if(count($exam->sections) == ($k+1))
            {
                $section->next =null;
            }else{
                $section->next = $exam->sections[$k+1]->id;
            }
        }


        // access code based timer
        $settings = json_decode($exam->getOriginal('settings'),true);


        if(isset($settings['timer']))
        foreach($settings['timer'] as $cd=>$tm){
            if(strtoupper($cd)==strtoupper($code)){
                $time = $tm;
            }
        }


        $url =$url2=  $images = null;
        if($exam->camera){
            $folder = 'webcam/'.$exam->id.'/';
            $name_prefix = $folder.\auth::user()->username.'_'.$exam->id.'_';
            $name_prefix2 = $folder.'screens/'.\auth::user()->username.'_'.$exam->id.'_';

            if($exam->capture_frequency){
                $count = ($time*60)/$exam->capture_frequency;
            }else{
                $count = 30;
            }

            for($i=0;$i<$count;$i++){
                $nm = $i;
                if(strlen($i)==1)
                    $nm ="00".$nm;
                else if(strlen($i)==2)
                    $nm ="0".$nm;
                $url[$nm] = \App::call('PacketPrep\Http\Controllers\AwsController@getAwsUrl',[$name_prefix.$nm.'.jpg']);
                $url2[$nm] = \App::call('PacketPrep\Http\Controllers\AwsController@getAwsUrl',[$name_prefix2.$nm.'.jpg']);
            }
            


            $folder = 'testlog/'.$exam->id.'/';
            $name = $folder.\auth::user()->username.'.json';
            $name_log = $folder.'log/'.\auth::user()->username.'_log.json';




            if(Storage::disk('s3')->exists($exam->image)){
                $base64_code = base64_encode(file_get_contents(Storage::disk('s3')->url($exam->image)));
                $base64_str = 'data:image/jpeg;base64,' . $base64_code;
                $images['logo'] = $base64_str;
            }


            if(\auth::user()->getImage()){
                $base64_code = base64_encode(file_get_contents(\auth::user()->getImage()));
                $base64_str = 'data:image/jpeg;base64,' . $base64_code;
                $images['user'] = $base64_str;

            }


        }else{

            $folder = 'testlog/'.$exam->id.'/';
            $name = $folder.\auth::user()->username.'.json';
            $name_log = $folder.'log/'.\auth::user()->username.'_log.json';



            if(Storage::disk('s3')->exists($exam->image)){
                //$base64_code = base64_encode(file_get_contents(Storage::disk('s3')->url($exam->image)));
                //$base64_str = 'data:image/jpeg;base64,' . $base64_code;
                //$images['logo'] = $base64_str;
                $images['logo'] =Storage::disk('s3')->url($exam->image);
            }


            if(\auth::user()->getImage()){
                // $base64_code = base64_encode(file_get_contents(\auth::user()->getImage()));
                // $base64_str = 'data:image/jpeg;base64,' . $base64_code;
                // $images['user'] = $base64_str;
                $images['user'] =\auth::user()->getImage();

            }
        }

         $settings = json_decode($exam->getOriginal('settings'),true);
         $url['testlog'] = \App::call('PacketPrep\Http\Controllers\AwsController@getAwsUrl',[$name]);
         $url['testlog_log'] = \App::call('PacketPrep\Http\Controllers\AwsController@getAwsUrl',[$name_log]);
         $approval_link_name = 'testlog/approvals/'.$exam->id.'/'.$user->username.'.json';
         $url['approval'] = Storage::disk('s3')->url($approval_link_name);


         if(!Storage::disk('s3')->exists($approval_link_name) && !isset($settings['manual_approval'])){
            $item = array($user->username=>0);
            $item[$user->username] = ["approved"=> 1,"terminated"=>0];
            Storage::disk('s3')->put($approval_link_name,json_encode($item),'public');
         }else if(!Storage::disk('s3')->exists($approval_link_name) && $settings['manual_approval']=='no'){
            $item = array($user->username=>0);
            $item[$user->username] = ["approved"=> 1,"terminated"=>0];
            Storage::disk('s3')->put($approval_link_name,json_encode($item),'public');
         }



         $invigilation = (isset($settings->invigilation))?$settings->invigilation:null;
         if($invigilation){

         }else{
            $proctor = $exam->user;
         }
         $chatname = 'testlog/'.$exam->id.'/chats/'.$user->username.'.json';
         $url['chat'] = Storage::disk('s3')->url($chatname);
         $url['chat_post'] = \App::call('PacketPrep\Http\Controllers\AwsController@getAwsUrl',[$chatname]);


         $activity = [strtotime(now())=>"Exam Link Opened"];
         $userdata = ['username'=>$user->username,'uname'=>$user->name,'rollnumber'=>$user->roll_number,"completed"=>0,"activity"=>$activity,"last_photo"=>"",'window_change'=>0];
         $json_d = json_encode($userdata);

         if(!$json_log)
         if(!Storage::disk('s3')->exists($name_log)){
            Storage::disk('s3')->put($name_log,$json_d,'public');
            $json_log = $json_d;
         }


         if(!Storage::disk('s3')->exists($chatname)){
            $activity = [strtotime(now())=> array("name"=>"proctor","username"=>"","message"=>"For queries, you can send me a message.")];

            Storage::disk('s3')->put($chatname,json_encode($activity),'public');
         }



         $url['testlog_log_get'] = Storage::disk('s3')->url($name_log);


         if(isset($settings['upload_time']))
         if($settings['upload_time']){
            $data['stopswap'] = $time - $settings['upload_time'];
         }

        if(!$request->get('student') && !$request->get('admin')){
            $time = round(($time * 60 - $time_used)/60,2);
            if(isset($settings['upload_time']))
            $data['stopswap'] = $time - $settings['upload_time'];
        }

       

        if(!count($questions))
            abort(403,'No questions found');

        if($section_timer){
            $view = 'test_sections';
            $time = $exam->sections[0]->time;
            if(!$data['sid'])
                $time = round(($time * 60 - $time_used)/60,2);
            else
                $time = round(($data['stime'] * 60 - $time_used)/60,2);
        }
        else
            $view = 'test';


      

        return view('appl.exam.assessment.blocks.'.$view)
                        ->with('mathjax',true)
                        ->with('highlight',true)
                        ->with('exam',$exam)
                        ->with('imgs',$imgs)
                        ->with('code',true)
                        ->with('csq',$csq)
                        ->with('test_section',$section_timer)
                        ->with('c',$cc)
                        ->with('urls',$url)
                        ->with('urls2',$url2)
                        ->with('urls3',$url3)
                        ->with('json_log',$json_log)
                        ->with('user',$user)
                        ->with('code_ques',$code_ques)
                        ->with('timer2',true)
                        ->with('camera',$exam->camera)
                        ->with('window_change',$window_change)
                        ->with('time',$time)
                        ->with('sections',$sections)
                        ->with('settings',$settings)
                        ->with('passages',$passages)
                        ->with('questions',$questions)
                        ->with('dynamic',$dynamic)
                        ->with('images',$images)
                        ->with('data',$data)
                        ->with('noback',1)
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
                     $entry = Cache::remember('entry_'.$exam->id.'_'.$user->id, 240, function() use($products,$user){
                        return DB::table('product_user')
                    ->whereIn('product_id', $products)
                    ->where('user_id', $user->id)
                    ->first();
                    });
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

    public function old_answer($answer,$dynamic)
    {

        if(!$dynamic)
            return $answer;



        if(strpos($answer,',')!== false){
            $ans =explode(',', $answer);
            foreach($ans as $k=>$a){
                $ans[$k]=$this->old_ans_str($a,$dynamic);
            }
            $new_ans = implode(',', $ans);
        }else if(strlen($answer)==1){
            $new_ans = $this->old_ans_str($answer,$dynamic);
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

    public function old_ans_str($answer,$dynamic){
        $new_ans = $answer;

        $answer = strtoupper($answer);

        if($dynamic ==1){
            return $answer;
        }elseif($dynamic==2){
            if($answer == 'A') $new_ans = 'B';
            if($answer == 'B') $new_ans = 'C';
            if($answer == 'C') $new_ans = 'D';
            if($answer == 'D') $new_ans = 'A';
            if($answer == 'E') $new_ans = 'E';
        }
        elseif($dynamic==3){
            if($answer == 'A') $new_ans = 'C';
            if($answer == 'B') $new_ans = 'D';
            if($answer == 'C') $new_ans = 'A';
            if($answer == 'D') $new_ans = 'B';
            if($answer == 'E') $new_ans = 'E';
        }elseif($dynamic==4){
            if($answer == 'A') $new_ans = 'D';
            if($answer == 'B') $new_ans = 'A';
            if($answer == 'C') $new_ans = 'B';
            if($answer == 'D') $new_ans = 'C';
            if($answer == 'E') $new_ans = 'E';
        }


        return $new_ans;
    }

    public function responses($slug,$id=null,$student=null,$pdf2=null,Request $request)
    {
        $filename = $slug.'.json';
        $filepath = $this->cache_path.$filename;


        $exam = Cache::get('test_'.$slug);



        if(!$pdf2)
        if(!\auth::user()->isAdmin())
         $this->authorize('view', $exam);


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
        else if($student)
            $student = User::where('username',$student)->first();
        else
            $student = \auth::user();

        if(!$student)
            $student = \auth::user();

        $user_id = $student->id;
        $test_id = $exam->id;
        $user = $student;

        $jsonname = $slug.'_'.$user_id;

        if(Storage::disk('s3')->exists('urq/'.$jsonname.'.json'))
            $images = json_decode(Storage::disk('s3')->get('urq/'.$jsonname.'.json'),true);
        else
            $images = [];

        $keys = [];




        if(Storage::disk('s3')->exists('webcam/json/'.$student->username.'_'.$exam->id.'.json')){
            $json = json_decode(Storage::disk('s3')->get('webcam/json/'.$student->username.'_'.$exam->id.'.json'),true);
            $count = count($json);
        }
        else{
            $json = null;
            $count = 0;
        }

        if(request()->get('images')){
            $json = json_decode(Storage::disk('s3')->get('webcam/json/'.$student->username.'_'.$exam->id.'.json'),true);

            return view('appl.exam.assessment.images')->with('exam',$exam)->with('user',$student)->with('count',$count);
        }


        $details = ['correct'=>0,'incorrect'=>'0','unattempted'=>0,'attempted'=>0,'avgpace'=>'0','testdate'=>null,'marks'=>0,'total'=>0,'evaluation'=>1];
        $details['course'] = $exam->name;
        $sum = 0;
        $c=0; $i=0; $u=0;

        if($request->get('forget')){
            Cache::forget('resp_'.$user_id.'_'.$test_id);
            Cache::forget('attempt_'.$user_id.'_'.$test_id);
        }

        
        $tests = Cache::remember('resp_'.$user_id.'_'.$test_id,240,function() use ($exam,$student){
            return Test::where('test_id',$exam->id)
                        ->where('user_id',$student->id)->with('question')->get();
        });
       

        

        $test_overall = Cache::remember('attempt_'.$user_id.'_'.$test_id, 60, function() use ($exam,$student){
            return Tests_Overall::where('test_id',$exam->id)->where('user_id',$student->id)->first();
        });



        if($request->get('pdf2')){
            
        
            ini_set('max_execution_time', 300); //300 seconds = 5 minutes
            $view = 'responses-pdf';
             //$pdf = PDF::loadView('appl.exam.assessment.'.$view,compact('tests','student','exam','test_overall'));
             //     $pdf->save('sample.pdf');
           
             // 
           
        }
        $tests_overall = $test_overall;

        $tests_keys = $tests->keyBy('question_id');





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

            $qset = $exam->getQuestionsSection($section->id,$user->id);
            foreach($qset as $q){

                if(isset($images)){
                    if(isset($images[$q->id]))
                        $q->images = $images[$q->id];
                    else
                        $q->images = [];
                }else{
                    $q->images = [];
                }


                if(isset($keys[$q->id]['dynamic'])){
                    $dynamic = $keys[$q->id]['dynamic'];
                    $q = $this->option_swap2($q,$dynamic);
                }

                $questions[$i] = $q;
                $ques[$q->id] = $q;
                $ques_keys[$q->id]['topic'] = $q->topic;
                $ques_keys[$q->id]['section'] = $section->name;
                $i++;

                if($q->type=='sq' || $q->type=='urq' || $q->type=='csq')
                    $subjective= true;
            }

        }



        if(count($sections)==1)
            $sections = null;


        $details['correct_time'] =0;
        $details['incorrect_time']=0;
        $details['unattempted_time']=0;
        $details['review'] = 0;
        $details['auto_max'] = 0;
        $topics = false;
        $review=false;

        $i=0;$cx=0;

        foreach($tests as $key=>$t){


            //dd($t->section->negative);
            if(isset($t)){
                $sum = $sum + $t->time;

                if(isset($t->created_at->date))
                $details['testdate'] = \carbon\carbon::parse($t->created_at->date)->diffForHumans();
                else
                $details['testdate'] = $t->created_at->diffForHumans();
            }

            if(isset($ques[$t->question_id])){
                $qd = $ques[$t->question_id];
                $qd->answer = $this->new_answer(strtoupper($qd->answer),$t->dynamic);
                $ques[$t->question_id] = $this->option_swap2($qd,$t->dynamic);
                $tests[$key]->question = $ques[$t->question_id];

                //dd($tests[$key]);
            }


             if($t->status==2){
                    $details['review'] = $details['review'] + 1; 
                    $review = true;
            }else{

                $cx = $cx+intval($ques[$t->question_id]->mark);
                
            }
            //$ques = Question::where('id',$q->id)->first();
            //dd($secs[$t->section_id]);
            if(isset($ques_keys[$t->question_id])){
                if($ques_keys[$t->question_id]['topic'])
                $topics = true;

            }else{
                 $ques_keys[$t->question_id]['topic'] = null;
                 $ques_keys[$t->question_id]['section'] = null;
                 $ques[$t->question_id] = $t->question;
                 //$ques[$t->question_id]->type = $t->question->type;
            }

            if($t->response){
                $details['attempted'] = $details['attempted'] + 1;
                if($t->accuracy==1){
                    $details['c'][$c]['topic'] = $ques_keys[$t->question_id]['topic'];
                    $details['c'][$c]['section'] = $ques_keys[$t->question_id]['section'];
                    $c++;
                    $details['correct'] = $details['correct'] + 1;
                    $details['correct_time'] = $details['correct_time'] + $t->time;
                    if($ques[$t->question_id]->type=='sq' || $ques[$t->question_id]->type=='urq'||$ques[$t->question_id]->type=='csq')
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
                if($ques[$t->question_id]->type=='sq' || $ques[$t->question_id]->type=='urq' || $ques[$t->question_id]->type=='csq')
                        $details['marks'] = $details['marks'] + $t->mark;
            }



            $details['total'] = $details['total'] + $secs[$t->section_id]->mark;
            //dd();

        }

        $details['auto_max'] = $cx;

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
        
       // dd($details);

        //dd($sections);
        $mathjax = false;
        $view = 'responses';

        if($request->get('pdf2') || $pdf2){
            ini_set('max_execution_time', 300); //300 seconds = 5 minutes
            $view = 'responses-pdf';

            $data['tests'] = $tests;
            $data['student'] = $student;
            $data['exam'] = $exam;
            $data['test_overall'] = $test_overall;
            $pdf = PDF::loadView('appl.exam.assessment.'.$view,$data);
            // $pdf->save('sample.pdf');
            $folder = 'testlog/'.$exam->id.'/pdf/';

            $uuname = str_replace(' ', '-', $student->name);
            $name = $folder.$uuname.'_'.$student->roll_number.'.pdf';
            Storage::disk('s3')->put($name, $pdf->output(), 'public');

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
                        ->with('sketchpad',1)
                        ->with('count',$count)
                        ->with('highlight',true)
                        ->with('chart',false);
             // 
           
        }else{
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
                        ->with('sketchpad',1)
                        ->with('count',$count)
                        ->with('highlight',true)
                        ->with('chart',false);

        }
       


        
    }


    public function solutions($slug,$id=null,Request $request)
    {


        $exam = Cache::get('test_'.$slug);

        if(!$exam)
        $exam = Exam::where('slug',$slug)->with('sections')->first();




        if($request->get('student')){
            $sketchpad = true;
            $student = User::where('username',$request->get('student'))->first();
        }
        else{
            $sketchpad =  false;
            $student = \auth::user();
        }

        if(!$student)
            $student = \auth::user();


        if($request->get('name') && !$request->get('rotate')){
            $this->update_image($request);
        }
        if($request->get('rotate')){
            return $this->rotate_image($slug,$student->id,$request);
        }

        Cache::forget('resp_'.$student->id.'_'.$exam->id);

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
            $response->status = 1;


            $response->save();

            $test_responses = $exam->updateScore($test_responses,$response);




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


                   if(isset($q->id))
                    $details['q'.$q->id] = null;
                    else
                    $details['q'.$q->question_id] = null;

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

                $details['coder'] = json_decode($details['comment'],true);
               

                return view('appl.exam.assessment.'.$view)
                        ->with('mathjax',true)
                        ->with('question',$question)
                        ->with('passage',$passage)
                        ->with('details',$details)
                        ->with('exam',$exam)
                        ->with('student',$student)
                        ->with('images',$images)
                        ->with('highlight',true)
                        ->with('sketchpad',$sketchpad)
                        ->with('section_questions',$test_responses->groupBy('section_id'))
                        ->with('questions',json_decode(json_encode($test_responses),true));
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
        //$username = $resp->username;
        $qno = $resp->qno;
        // if(isset($resp->get('qno')))
        //     $qno = $resp->get('qno');
        // else
        //     $qno = '';


        echo 1;

        //echo json_encode($request->all());


        $responses = $resp->responses;

        $exam_cache = Cache::get('exam_cache_'.$exam_id);
        if(!$exam_cache)
        $exam_cache = array();

        $exam_cache[$user_id] = $responses;

        Cache::put('responses_'.$user_id.'_'.$exam_id,$responses,240);
        Cache::put('exam_cache_'.$exam_id,$exam_cache,240);

        // echo 'testlogs/activity/'.$exam->id.'/'.$user_id.'.json';
        // exit();


        // echo json_encode($json);
        // exit();



        exit();
    }


    public function submission($slug,Request $request)
    {

        $code_ques_flag =0;
        $test = $slug;
        if($request->get('admin') || $request->get('api_submit')){
            $user = User::where('id',$request->get('user_id'))->first();
        }else{
            $user = \auth::user();
        }

        if(!$user)
        return 1;

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

            $test_taken = $user->attempted_test($exam->id);
            if($test_taken && request()->get('api_submit'))
                return 1;
            else if($test_taken)
                return redirect()->route('assessment.analysis',$slug);
        }else{

            Test::where('test_id',$test_id)->where('user_id',$user_id)->delete();
            Tests_Section::where('test_id',$test_id)->where('user_id',$user_id)->delete();
            Tests_Overall::where('test_id',$test_id)->where('user_id',$user_id)->delete();

        }


        $qcount =0;
        foreach($exam->sections as $section){
            //$qset = $section->questions;
            $qset = $exam->getQuestionsSection($section->id,$user->id);

            foreach( $qset as $q){
                $questions[$q->id] = $q;
                $secs[$section->id] = $section;
                $answers[$q->id] = $q->answer;
                if(!isset($sections_max[$section->id]))
                    $sections_max[$section->id] = 0;
                if($q->mark!=null)
                $sections_max[$section->id] = $sections_max[$section->id] + (int)$q->mark;
                else
                $sections_max[$section->id] = $sections_max[$section->id] + $section->mark;
                $qcount++;
            }
        }


        $date_time = new \DateTime();
        $data = array();
        $d =array();
        $typing_accuracy =  $typing_score =0;
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
                    if($questions[$request->get($i.'_question_id')]->type=='sq' || $questions[$request->get($i.'_question_id')]->type=='csq')
                        $item['response'] = $request->get($i);
                    else
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
                        $an = str_replace(' ', '', $item['answer']);
                        $rp = str_replace(' ', '', $item['response']);

                        if(trim($an)==trim($rp)){
                            $item['accuracy'] =1;
                        }else{
                            $ans = explode('/',$item['answer']);
                            $flag = false;
                            $item['accuracy'] =0;
                            foreach($ans as $an){
                                $an = str_replace(' ', '', $an);
                                if($an==trim(str_replace(' ','',$item['response'])))
                                    $item['accuracy'] =1;
                            }

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
                    if($secs[$item['section_id']]->negative && $item['response'])
                        $item['mark'] = 0 - $secs[$item['section_id']]->negative;
                    else
                        $item['mark'] = 0;
                }


                $item['status'] = 1;
                $item['dynamic'] = $request->get($i.'_dynamic');
                $item['code'] = $request->get('dynamic_'.$i);
                $item['comment'] = $request->get('out_'.$i);


                if(strip_tags(trim($item['code']))){
                    $testcases = json_decode($item['comment'],true);
                    $partialmark = 0.2;
                    if($questions[$item['question_id']]->mark)
                        $partialmark = round($questions[$item['question_id']]->mark/5,2);
                    elseif($secs[$item['section_id']]->mark)
                        $partialmark = round($secs[$item['section_id']]->mark/5,2);
                   
                   $partial_awarded  = 0;
                   if($testcases['pass_1']=='1'){
                        $partial_awarded = $partial_awarded +$partialmark;
                   }

                   if($testcases['pass_2']=='1'){
                        $partial_awarded = $partial_awarded +$partialmark;
                   }

                   if($testcases['pass_3']=='1'){
                        $partial_awarded = $partial_awarded +$partialmark;
                   }

                   if($testcases['pass_4']=='1'){
                        $partial_awarded = $partial_awarded +$partialmark;
                   }

                   if($testcases['pass_5']=='1'){
                        $partial_awarded = $partial_awarded +$partialmark;
                   }
                   $item['mark'] = $partial_awarded;

                    if($testcases['pass_1']=='1' && $testcases['pass_2']=='1' && $testcases['pass_3']=='1' && $testcases['pass_4']=='1' && $testcases['pass_5']=='1'){
                        $item['accuracy'] =1;
                    }else{
                        $item['accuracy'] =0;
                    }
                        
                    // $code_ques_flag =1;
                    // $item['status'] = 2;
                }


                $type = $questions[$item['question_id']]->type;

                if($type=='typing'){
                    $item['mark'] = $request->get($i.'_wpm');
                    $typing_score = $request->get($i.'_wpm');
                    $typing_accuracy = $request->get($i.'_accuracy');
                    $item['accuracy'] = 1;
                }

                if($type=='sq' || $type=='urq' || $type=='csq'){
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
            Cache::put('resp_'.$user_id.'_'.$test_id,$tests_cache,240);
        }else{
            Cache::forget('resp_'.$user_id.'_'.$test_id);
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

                if($typing_accuracy)
                    $sec[$item['section_id']]['score'] = $typing_accuracy;
            }
            else if($item['response'] && $item['accuracy']==0){
                $sec[$item['section_id']]['incorrect']++;
                $sec[$item['section_id']]['score'] = $sec[$item['section_id']]['score'] + $item['mark'];
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
        $test_overall['mobile_detect'] = 0;
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
        $test_overall_cache->mobile_detect = 0;

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

            if($typing_accuracy){
                $test_overall['incorrect'] = $typing_accuracy;
                $test_overall['score'] =  $typing_score ;
            }

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

        $jsonname = $user->username.'_'.$exam->id.'.json';

        if(Storage::disk('s3')->exists('testlog/'.$exam->id.'/log/'.$user->username.'_log.json')){
            $js = json_decode(Storage::disk('s3')->get('testlog/'.$exam->id.'/log/'.$user->username.'_log.json'),true);
            $js['completed'] = 1;

            Storage::disk('s3')->put('testlog/'.$exam->id.'/log/'.$user->username.'_log.json',json_encode($js),'public');
        }


        if(Storage::disk('s3')->exists('webcam/'.$exam->id.'/json/'.$jsonname)){
            $json = json_decode(Storage::disk('s3')->get('webcam/'.$exam->id.'/json/'.$jsonname));

            $zero =$one = $two =$three = $total = $snaps = $mobile=0;
            foreach($json as $i => $j){
                if($i!=='mobile'){
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
                }else{
                    $mobile= intval($j);
                    $test_overall['mobile_detect'] = $mobile;
                    
                }
               
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

            if($three){
                    $test_overall['face_detect'] = 3;
            }

            if($mobile){
                $test_overall['cheat_detect'] = 1;
            }



        }


        if($test_overall['window_change']>3)
            $test_overall['cheat_detect'] = 1;

        $test_overall_cache->cheat_detect = $test_overall['cheat_detect'];

        if(!$request->get('admin')){
            Cache::put('attempt_'.$user_id.'_'.$test_id,$test_overall_cache,240);
            Cache::forget('attempts_'.$user_id);
        }else{
            Cache::forget('attempt_'.$user_id.'_'.$test_id);
            Cache::forget('attempt_section_'.$user_id.'_'.$test_id);
        }


        Test::insert($data);
        Tests_Section::insert($sec);
        Tests_Overall::insert($test_overall);

        if(!$request->get('admin')){
            $test_oa = Tests_Overall::where('user_id', $user->id)
                    ->orderBy('id','desc')
                    ->get();

            Cache::put('attempts_'.$user_id,$test_oa, 240);
        }else{
            Cache::forget('attempts_'.$user_id);
        }

         if($request->get('api_submit'))
            return 1;

        //$this->dispatch(new ProcessAttempts($data,$sec,$test_overall));

        if(!$request->get('admin'))
            return redirect()->route('assessment.analysis',$slug);
        else
            return redirect()->route('test.report',$slug);


    }

     public function live($id,Request $r)
    {


        $exam = Cache::get('test_'.$id,function() use($id){
            return Exam::where('slug',$id)->first();
        });
        $this->authorize('create', $exam);





        // if(!$exam_cache && !$r->get('all')){
        //     abort(404,"There is no live data");
        // }

        $questions = [];
        $secs= [];
        $data['completed'] = 0;
        $data['total'] = 0;
        $data['inactive'] = 0;
        $data['ques_analysis'] = 0;

        foreach($exam->sections as $section){
            $qset = $section->questions;

            foreach( $qset as $q){
                $questions[$q->id] = $q;
                $questions[$q->id]->attempted = 0;
                $questions[$q->id]->correct = 0;
                $questions[$q->id]->opt_a = 0;
                $questions[$q->id]->opt_b = 0;
                $questions[$q->id]->opt_c = 0;
                $questions[$q->id]->opt_d = 0;
                $questions[$q->id]->opt_e = 0;
                $secs[$section->id] = $section;
                $question = $q;
            }
        }

        $test_responses = Cache::remember('test_resp_'.$exam->id,60,function() use($exam){
                    return Test::where('test_id',$exam->id)->get()->groupBy('user_id');
            });

        $c1 = count($test_responses);
        $c2 = count($questions);
        if($c1 * $c2 > 50000)
             return view('appl.exam.exam.nofile')
                    ->with('exam',$exam)
                    ->with('active',1)
                    ->with('message','Data analysis is disabled for large volume data.');


        $exam_cache = $test_responses;
        $data['ques_analysis'] = 1;

        $completion = Tests_Overall::where('test_id',$exam->id)->pluck('user_id')->toArray();

        $data['completed'] = count($completion);
        $data['total'] = $data['completed'];

        //dd($exam_cache);
        foreach($exam_cache as $u=>$r){

            foreach($r as $k=>$w){



                if(isset($w->response)){
                if(isset($questions[$w->question_id])){
                    $questions[$w->question_id]->attempted++;

                    if($this->evaluate($w->response,$questions[$w->question_id]['answer'],$w->dynamic))
                        $questions[$w->question_id]->correct++;

                    $w->response = $this->old_answer(strtoupper($w->response),$w->dynamic);

                    if(strtoupper($w->response)=='A')
                        $questions[$w->question_id]->opt_a++;
                    if(strtoupper($w->response)=='B')
                        $questions[$w->question_id]->opt_b++;
                    if(strtoupper($w->response)=='C')
                        $questions[$w->question_id]->opt_c++;
                    if(strtoupper($w->response)=='D')
                        $questions[$w->question_id]->opt_d++;
                    if(strtoupper($w->response)=='E')
                        $questions[$w->question_id]->opt_e++;
                }
                }

            }


        }

        foreach($questions as $m=>$q){
            $total =$questions[$m]->attempted;
            if($total){
            $questions[$m]->opt_a  = (round($questions[$m]->opt_a/$total*100) );
            $questions[$m]->opt_b  = (round($questions[$m]->opt_b/$total*100) );
            $questions[$m]->opt_c  = (round($questions[$m]->opt_c/$total*100) );
            $questions[$m]->opt_d = (round($questions[$m]->opt_d/$total*100) );
            $questions[$m]->opt_e  = (round($questions[$m]->opt_e/$total*100) );
            }

        }


        if($exam)
            return view('appl.exam.exam.live')
                    ->with('exam_cache',$exam_cache)
                    ->with('questions',$questions)
                    ->with('data',$data)
                    ->with('question',$question)
                    ->with('highlight',1)
                     ->with('active',1)
                    ->with('mathjax',$question)
                    ->with('exam',$exam);
        else
            abort(404);
    }


     public function logs($id,Request $r){

        $exam = Cache::get('test_'.$id,function() use($id){
            return Exam::where('slug',$id)->first();
        });

        $username = $r->get('username');
        $type = $r->get('type');
        $folder = 'webcam/'.$exam->id.'/';
        $user = User::where('username',$username)->first();

        $this->authorize('create', $exam);

        //log file
        $name = $username.'_log.json';
        $filepath = 'testlog/'.$exam->id.'/log/'.$name;



        $content = null;
        if(Storage::disk('s3')->exists($filepath)){
            $content = json_decode(Storage::disk('s3')->get($filepath),true);

            

        }

        
        //dd($content);

        if($content)
            return view('appl.exam.exam.logs')
                    ->with('content',$content)
                    ->with('exam',$exam)
                    ->with('active',1)
                    ->with('proctor',1)
                    ->with('user',$user);
        else
             return view('appl.exam.exam.nofile')
                    ->with('exam',$exam)
                    ->with('user',$user)
                    ->with('active',1)
                    ->with('message','No log recorded');


    }


    public function snaps($id,Request $r){

        $exam = Cache::get('test_'.$id,function() use($id){
            return Exam::where('slug',$id)->first();
        });

        $username = $r->get('username');
        $type = $r->get('type');
        $folder = 'webcam/'.$exam->id.'/';
        $user = User::where('username',$username)->first();

        $this->authorize('create', $exam);


        //$files = Storage::disk('s3')->allFiles($folder);

        // $mask= $username.'_'.$exam->id;

        // $files = array_where($files, function ($value, $key) use ($mask) {
        //    return starts_with(basename($value), $mask);
        // });

        //log file
        $name = $username.'.json';
        $filepath = 'testlog/'.$exam->id.'/'.$name;

        $content = null;
        if(Storage::disk('s3')->exists($filepath)){
            $content = json_decode(Storage::disk('s3')->get($filepath),true);

             if(isset($content['last_photo'])){
                if(trim($content['last_photo'])!=''){
                    $url_pieces = explode('_',$content['last_photo']);
                    $counter = explode('.',$url_pieces[2]);
                    $last_number = intval($counter[0])-1;
                }else
                {
                    $content['last_photo'] = '';
                    $last_number = 0;
                }

            }else{
                $content['last_photo'] = '';
                $last_number = 0;
            }

        }

        if($last_number==-1)
            $last_number = 0;


        $pics = [];$i=0;

        if($type=='snaps')
        $imagepath = 'webcam/'.$exam->id.'/'.$username.'_'.$exam->id.'_';
        else
        $imagepath = 'webcam/'.$exam->id.'/screens/'.$username.'_'.$exam->id.'_';

        if($content){
            for($i=0;$i<=$last_number;$i++){
                if(strlen($i)==1)
                    $nm ="00".$i;
                else if(strlen($i)==2)
                    $nm ="0".$i;
                else
                    $nm = $i;
                $pics[$i] = $imagepath.$nm.'.jpg';

            }

            if($last_number==0){

                if(!Storage::disk('s3')->exists($pics[$i-1]))
                {
                    $pics[0] = "";
                    unset($pics[0]);
                }
            }
        }

        rsort($pics);

        $pg = $this->paginateAnswers($pics,18);


        if($pg->total())
            return view('appl.exam.exam.snaps')
                    ->with('pg',$pg)
                    ->with('exam',$exam)
                    ->with('active',1)
                    ->with('proctor',1)
                    ->with('user',$user)
                    ->with('total',count($pics));
        else
             return view('appl.exam.exam.nofile')
                    ->with('exam',$exam)
                    ->with('user',$user)
                    ->with('active',1)
                    ->with('message','No pictures captured');


    }

    public function active($id,Request $r){

        $exam = Cache::get('test_'.$id,function() use($id){
            return Exam::where('slug',$id)->first();
        });

        $search = trim($r->get('search'));

        $users = array();
        $userset = [];

        $this->authorize('view', $exam);
        //$fl = collect($files);

        $user = \auth::user();

        //dd($exam->settings);
        if(!isset($exam->getOriginal('settings')->invigilation))
            $exam_settings = json_decode($exam->getOriginal('settings'),true);
        else
            $exam_settings = json_decode(json_encode($exam->getOriginal('settings')),true);

        $candidates = [];

        if(isset($exam_settings['invigilation'])){
            foreach($exam_settings['invigilation'] as $in=>$emails){
                if($user->id==$in){
                    $candidates = $emails;
                }
            }
        }


        //dd($files);
        //dd($candidates);

        $data = [];
        $data['total'] = $data['live'] = $data['completed']= $data['inactive'] =0;

        $pg=[];
        $chats = [];
        $completed_list = [];
        if(count($candidates)){
            if(request()->get('forget')){
                Cache::forget('candidates_'.$exam->slug.'_'.$user->username);
            }
            if(!$search)
                $userset = Cache::remember('candidates_'.$exam->slug.'_'.$user->username,240, function() use($candidates) {
                    return User::whereIn('email',$candidates)->where('client_slug',subdomain())->get()->keyBy('username');
                });
            else{
                $userset = User::whereIn('username',[$search])->where('client_slug',subdomain())->get()->keyBy('username');
            }

            foreach($userset as $u=>$usr){
                $users[$u] = 1;
                $chats[$u] = 1;
            }

            //$usr = User::whereIn('email',$candidates)->orderBy('username','asc')->get();
            foreach($userset as $a=> $b){
                $name = $b->username.'_log.json';
                $pg[$b->username] = 'testlog/'.$exam->id.'/log/'.$name;
            }


            $tests_overall = Tests_Overall::where('test_id',$exam->id)->whereIn('user_id',$userset->pluck('user_id')->toArray())->with('user')->get();
            $completed_list = $this->updateCompleted($pg,$tests_overall,$exam);

            $pg = $this->paginateAnswers($pg,count($pg));

            foreach($pg as $usc=>$f){
                $p = explode('/',$f);
                $u = explode('.',$p[2]);

                $content = [];
                //echo $f."<br>";
                if(Storage::disk('s3')->exists($f)){

                    $content = json_decode(Storage::disk('s3')->get($f),true);
                    $content['url'] = Storage::disk('s3')->url($f);

                    $name = 'testlog/'.$exam->id.'/'.$usc.'.json';
                    $content['url2'] = Storage::disk('s3')->url($name);

                    $chaturl = 'testlog/'.$exam->id.'/chats/'.$usc.'.json';

                    if(Storage::disk('s3')->exists($chaturl)){
                        $chat_messages = json_decode(Storage::disk('s3')->get($chaturl),true);
                        $chats[$usc] = $chat_messages;
                        $end = end($chats[$usc]);
                        $chats[$usc]['last_message'] = $end['message'];
                        $chats[$usc]['last_time'] = key($chats[$usc]);
                        $chats[$usc]['last_user'] = $end['name'];

                    }



                    $content['selfie_url'] ='';
                    $content['idcard_url'] ='';
                    $content['approval'] ='';
                    $content['chat'] ='';
                    $content['chat_post'] ='';
                    $content['approval_post'] = '';

                    if(isset($content['username'])){
                            $selfie = $content['username'].'_'.$exam->id.'_selfie.jpg';
                            $content['selfie_url'] = Storage::disk('s3')->url('webcam/'.$exam->id.'/'.$selfie);

                            $idcard = $content['username'].'_'.$exam->id.'_idcard.jpg';
                            $content['idcard_url'] = Storage::disk('s3')->url('webcam/'.$exam->id.'/'.$idcard);

                            $name = 'testlog/approvals/'.$exam->id.'/'.$content['username'].'.json';
                            $content['approval'] = Storage::disk('s3')->url($name);

                            $content['approval_post'] = \App::call('PacketPrep\Http\Controllers\AwsController@getAwsUrl',[$name]);

                            $chatname = 'testlog/'.$exam->id.'/chats/'.$content['username'].'.json';
                            $content['chat'] = Storage::disk('s3')->url($chatname);

                            $chatname = 'testlog/'.$exam->id.'/chats/'.$content['username'].'.json';
                            $content['chat_post'] = \App::call('PacketPrep\Http\Controllers\AwsController@getAwsUrl',[$chatname]);

                            //$name = 'testlog/approvals/'.$exam->id.'.json';
                            //$content['approval_post'] = \App::call('PacketPrep\Http\Controllers\AwsController@getAwsUrl',[$name]);
                    }


                    if(isset($content['last_photo'])){
                        if(!$content['last_photo']){

                        }else{
                            $url_pieces = explode('_',$content['last_photo']);
                            $name = explode('/', $url_pieces[0]);
                            if(is_array($name))
                                $name = $name[5];

                            $filepath = 'webcam/'.$exam->id.'/'.$name.'_'.$exam->id.'_'.$url_pieces[2];
                            if(!Storage::disk('s3')->exists($filepath)){
                                $counter = explode('.',$url_pieces[2]);
                                $nm = intval($counter[0])-1;
                                if(strlen($nm)==1)
                                    $nm ="00".$nm;
                                else if(strlen($nm)==2)
                                    $nm ="0".$nm;


                                $filepath =  $filepath = 'webcam/'.$exam->id.'/'.$name.'_'.$exam->id.'_'.($nm).'.jpg';
                                $last_before_url = $url_pieces[0].'_'.$url_pieces[1].'_'.($nm).'.jpg';
                                if(Storage::disk('s3')->exists($filepath)){
                                    $content['last_photo'] = $last_before_url .'?time='.strtotime(now());
                                }else{

                                }
                            }
                        }
                    }else{
                        $content['last_photo'] = '';
                    }
                }

                if(isset($content['completed'])){
                    if(!$content['completed'])
                    if($completed_list[$content['username']]==1)
                        $content['completed'] = 1;
                }else{
                    if(isset($content['username']))
                    if($completed_list[$content['username']]==1)
                        $content['completed'] = 1;
                }

                if(isset($content['username']))
                    $users[$content['username']] = $content;

                if(!isset($content['username']) && isset($content['url'])){
                    $url = $content['url'];
                    $pc = explode('/',$url);
                    $pc2 = explode('_',$pc[6]);


                    if(isset($pc2[0]))
                        $users[$pc2[0]] = $content;
                }
                //array_push($users, $content);
            }


        }else{


            if($user->role==11)
                return view('appl.exam.exam.nofile')->with('message','You are not authorized to access this data.')
                    ->with('exam',$exam)
                    ->with('user',$user)
                    ->with('active',1);



            if($search){
                $file = 'testlog/'.$exam->id.'/log/'.$search.'_log.json';
                $files = [];
                if(Storage::disk('s3')->exists($file))
                    $files = [$file];
                $pg = $this->paginateAnswers($files,18);

            }else{
                $files = Storage::disk('s3')->allFiles('testlog/'.$exam->id.'/log/');

                $tests_overall = Tests_Overall::where('test_id',$exam->id)->with('user')->get();


                $completed_count  = count($tests_overall);
                $sessions_count = count($files);

                if($sessions_count> $completed_count ){
                    $data['total'] = $sessions_count;
                    $data['completed'] = $completed_count;
                    $data['live'] = $sessions_count - $completed_count;
                }else{
                    $data['total'] = $completed_count;
                    $data['completed'] = $completed_count;
                    $data['live'] = 0;
                }

                $completed_list = $this->updateCompleted($files,$tests_overall,$exam);
                $f2=[];
                
                if(request()->get('completed')){
                    foreach($completed_list as $c=>$flag){
                        if($flag)
                        {
                            if (($key = array_search('testlog/'.$exam->id.'/log/'.$c.'_log.json', $files)) !== false) {
                                    array_push($f2, 'testlog/'.$exam->id.'/log/'.$c.'_log.json');
                                   
                                }
                          

                        }

                    }
                    $pg = $this->paginateAnswers($f2,18);
                }
                elseif(request()->get('open')){
                    foreach($completed_list as $c=>$flag){
                        if(!$flag)
                        {
                            if (($key = array_search('testlog/'.$exam->id.'/log/'.$c.'_log.json', $files)) !== false) {
                                    array_push($f2, 'testlog/'.$exam->id.'/log/'.$c.'_log.json');
                                   
                                }
                          

                        }

                    }
                    $pg = $this->paginateAnswers($f2,18);
                }else if(request()->get('terminate_all')){
                    $data = null;

                    foreach($completed_list as $c=>$flag){
                        $url = 'testlog/'.$exam->id.'/'.$c.'.json';
                        if(!$flag && Storage::disk('s3')->exists($url))
                        {
                            //submit the response
                            
                            $json = json_decode(Storage::disk('s3')->get($url),true);
                            //dd($json);
                            request()->merge(['api_submit'=>1]);
                            request()->merge(['user_id'=>$json['user_id']]);
                            request()->merge(['test_id'=>$json['test_id']]);
                            request()->merge(['code'=>$json['code']]);
                            request()->merge(['window_change'=>$json['window_change']]);
                            foreach($json['responses'] as $d=>$v){
                                $i=$d+1;

                                request()->merge([$i.'_question_id'=>$v['question_id']]);
                                request()->merge([$i.'_section_id'=>$v['section_id']]);
                                request()->merge([$i.'_time'=>intval($v['time'])]);
                                request()->merge([$i.'_dynamic'=>$v['dynamic']]);
                                if(isset($v['response'])){
                                    $data[$i] = $v['response'];
                                    request()->merge([$i=>$v['response']]);
                                }
                                

                                else{
                                    request()->merge([$i=>null]);
                                    $data[$i] =null;
                                }

                            }

                            //dd(request()->all());

                            $result = $this->submission($exam->slug,$r);
                            //dd($result);
                        }else if(!$flag && !Storage::disk('s3')->exists($url)){
                             $url = 'testlog/'.$exam->id.'/log/'.$c.'_log.json';
                             Storage::disk('s3')->delete($url);
                        }   
                        
                    }
                    // print("All the responses submitted <br>");
                    // dd();
                    return redirect()->route('test.active',$exam->slug);

                    $pg = $this->paginateAnswers($files,18);
                }
                else{
                    $pg = $this->paginateAnswers($files,18);
                }
                
                

            }


            foreach($pg as $f){
                $p = explode('/',$f);
                $u = explode('.',$p[2]);

                $content = json_decode(Storage::disk('s3')->get($f),true);
                $content['url'] = Storage::disk('s3')->url($f);

                $name = 'testlog/'.$exam->id.'/'.$content['username'].'.json';
                $content['url2'] = Storage::disk('s3')->url($name);

                $content['selfie_url'] ='';
                $content['idcard_url'] ='';
                $content['approval'] ='';
                $content['chat'] ='';
                $content['chat_post'] ='';
                $content['approval_post'] = '';



                if(isset($content['username'])){
                        $selfie = $content['username'].'_'.$exam->id.'_selfie.jpg';
                        $content['selfie_url'] = Storage::disk('s3')->url('webcam/'.$exam->id.'/'.$selfie);

                        $idcard = $content['username'].'_'.$exam->id.'_idcard.jpg';
                        $content['idcard_url'] = Storage::disk('s3')->url('webcam/'.$exam->id.'/'.$idcard);

                        $name = 'testlog/approvals/'.$exam->id.'/'.$content['username'].'.json';
                        $content['approval'] = Storage::disk('s3')->url($name);
                         $content['approval_post'] = \App::call('PacketPrep\Http\Controllers\AwsController@getAwsUrl',[$name]);

                        $chatname = 'testlog/'.$exam->id.'/chats/'.$content['username'].'.json';
                        $content['chat'] = Storage::disk('s3')->url($chatname);

                        $chatname = 'testlog/'.$exam->id.'/chats/'.$content['username'].'.json';
                        $content['chat_post'] = \App::call('PacketPrep\Http\Controllers\AwsController@getAwsUrl',[$chatname]);



                }

                if(isset($content['last_photo'])){
                    if(!$content['last_photo']){

                    }else{
                        $url_pieces = explode('_',$content['last_photo']);
                        $name = explode('/', $url_pieces[0]);
                        if(is_array($name))
                            $name = $name[5];

                        if(isset($url_pieces[2])){
                             $filepath = 'webcam/'.$exam->id.'/'.$name.'_'.$exam->id.'_'.$url_pieces[2];
                            if(!Storage::disk('s3')->exists($filepath)){
                                $counter = explode('.',$url_pieces[2]);
                                $nm = intval($counter[0])-1;
                                if(strlen($nm)==1)
                                    $nm ="00".$nm;
                                else if(strlen($nm)==2)
                                    $nm ="0".$nm;
                                $filepath =  $filepath = 'webcam/'.$exam->id.'/'.$name.'_'.$exam->id.'_'.($nm).'.jpg';
                                $last_before_url = $url_pieces[0].'_'.$url_pieces[1].'_'.($nm).'.jpg';
                                if(Storage::disk('s3')->exists($filepath)){
                                    $content['last_photo'] = $last_before_url .'?time='.strtotime(now());
                                }else{
                                }
                            }
                        }

                    }
                }else{
                    $content['last_photo'] = '';
                }

                if(!$content['completed']){
                    if($completed_list[$content['username']]==1)
                        $content['completed'] = 1;
                }
                if(isset($content['username']))
                 $users[$content['username']] = $content;
                //array_push($users, $content);
            }
        }





        // foreach($users as $a=>$b){


        //     $time = strtotime(now());
        //     if(isset($b['last_updated']))
        //     $diff = round($time - $b['last_updated']);
        //     $data['total'] = $data['total'] +1;
        //      if(isset($b['completed'])){
        //             $data['completed']++;
        //             $users[$a]['active'] = 2;
        //         }
        //         else{
        //             if($diff > 300){
        //                $data['inactive']++;
        //                $users[$a]['active'] = 0;
        //             }else{
        //                 $data['live']++;
        //                 $users[$a]['active'] = 1;
        //             }

        //     }
        // }



        // $chatname = 'testlog/'.$exam->id.'/chats/proctor_'.\auth::user()->username.'.json';
        // $data['chat'] = Storage::disk('s3')->url($chatname);
        // $data['chat_post'] = \App::call('PacketPrep\Http\Controllers\AwsController@getAwsUrl',[$chatname]);

        if(count($users)==0 && $search){
                return view('appl.exam.exam.nofile')
                    ->with('exam',$exam)
                    ->with('active',1)
                    ->with('message','No user found');
        }

        else if(count($users))
            return view('appl.exam.exam.active')
                    ->with('data',$data)
                    ->with('users',$users)
                    ->with('pg',$pg)
                    ->with('exam',$exam)
                    ->with('userset',$userset)
                    ->with('settings',$exam_settings)
                    ->with('candidates',$candidates)
                    ->with('proctor',1)
                    ->with('active',1)
                    ->with('chats',$chats);
        else{
                return view('appl.exam.exam.nofile')
                        ->with('exam',$exam)
                        ->with('active',1)
                        ->with('message',"No data available yet. Atleast one candidate has to start the exam.");

        }

    }


    public function updateCompleted($files,$tests_overall,$exam){

        $users = array();$completed=[];
        foreach($tests_overall as $t){
            $users[$t->user->username] = $t->user->username;
            //array_push($users,$t->user->username);

        }


         foreach($files as $k=>$f){
            $a = str_replace('testlog/'.$exam->id.'/log/', '', $f);
            $username = str_replace('_log.json', '', $a);
            $completed[$username] = 0;
            if(isset($users[$username]))
                $completed[$username] = 1;
         }

         return $completed;

    }



    public function proctor($id,Request $r){

        $exam = Cache::get('test_'.$id,function() use($id){
            return Exam::where('slug',$id)->first();
        });



        $user = \auth::user();
        //dd($exam->settings);
        if(!isset($exam->getOriginal('settings')->invigilation))
            $exam_settings = json_decode($exam->getOriginal('settings'),true);
        else
            $exam_settings = json_decode(json_encode($exam->getOriginal('settings')),true);

        $candidates = [];
        if(isset($exam_settings['invigilation'])){
            foreach($exam_settings['invigilation'] as $in=>$emails){
                if($user->id==$in){
                    $candidates = $emails;
                }
            }
        }



        if(!$r->get('api'))
        $this->authorize('create', $exam);


        $json =[];

        $userset = Cache::remember('candidates_'.$exam->slug.'_'.$user->username, 240, function() use ($candidates){
            return User::whereIn('email',$candidates)->where('client_slug',subdomain())->get()->keyBy('username');
        });

        if($candidates){
            foreach($userset as $ux=>$sx){
                $file = 'testlog/approvals/'.$exam->id.'/'.$ux.'.json';
                if(Storage::disk('s3')->exists($file)){
                    $json[$ux] = json_decode(Storage::disk('s3')->get($file),true);
                }else{
                    $json[$ux] = null;
                }
            }
        }else{

            // $folder = 'testlog/approvals/'.$exam->id.'/';
            // $files = Storage::disk('s3')->allFiles($folder);
            // foreach($files as $f){
            //     $fl = json_decode(Storage::disk('s3')->get($f),true);
            //     $json[$fl['username']] = $fl;
            // }
        }


        // if(Storage::disk('s3')->exists('testlog/approvals/'.$exam->id.'/'.$user->username.'.json')){
        //     $json = json_decode(Storage::disk('s3')->get('testlog/approvals/'.$exam->id.'.json'),true);
        // }else{
        //     $json = [];
        // }

        if($r->get('api')){
            $username = $r->get('username');
            $message = ['status'=>0,'message'=>''];
            if($r->get('approved')==1){
                $json[$username]['approved']=1;
                $message['status'] = 1;

            }
            else if($r->get('approved')==2){
                $json[$username]['approved']=2;
                 $message['status'] = 2;
            }

            // if($r->get('approved')){
            //     Storage::disk('s3')->put('testlog/approvals/'.$exam->id.'/'.$username.'.json', json_encode($json));
            // }

            if($r->get('alert')){
                 $message['status'] = 3;
                if($r->get('alert')==1)
                    $message['message'] = 'Your Selfie picture is not clear. Kindly recapture.' ;
                else if($r->get('alert')==2)
                    $message['message'] = 'Your ID card picture is not clear. Kindly recapture.' ;
                else if($r->get('alert')==3)
                    $message['message'] = 'Your ID card is invalid. Kindly use the approved Photo ID for this test.' ;
            }
            $json[$username]['status'] = $message['status'];
            $json[$username]['message'] = $message['message'];

            Storage::disk('s3')->put('testlog/approvals/'.$exam->id.'/'.$username.'.json', json_encode($json[$username]),'public');

            exit();


        }

        //dd($json);
        $data = [];

        foreach($userset as $u=>$usr){
            $data['users'][$u] = 1;
        }

        $data['total'] = $data['waiting'] = $data['approved'] =  $data['rejected']=0;
        foreach($json as $a=>$b){
            if($b){
                if(isset($userset[$a]))
                $userset[$a]->started = $b;
                $data['total'] = $data['total'] +1;
                if($b['approved'] == 0 )
                $data['waiting'] = $data['waiting'] +1;
                else if($b['approved'] == 2 )
                $data['rejected'] = $data['rejected'] +1;
                else
                $data['approved'] = $data['approved'] +1;

                $data['users'][$a] = $b;
            }

        }

        $data['colleges'] = Cache::remember('colleges_'.$exam->id, 240,function(){
            return College::get()->keyBy('id');
        });
        $data['branch'] = Cache::remember('branches_'.$exam->id, 240,function(){
            return Branch::get()->keyBy('id');
        });



        if($json)
            return view('appl.exam.exam.proctor')
                    ->with('data',$data)
                    ->with('userset',$userset)
                    ->with('exam',$exam);
        else
            abort(403,'Page on hold / Not records found');

    }

    public function evaluate($response,$answer,$dynamic){

        $item['response'] = '';
        $item['accuracy'] = '';
        $item['answer'] = '';
        if(is_array($response)){
            $item['response'] = strtoupper(implode(',',$response));
        }else{
            $item['response'] = strtoupper($response);
        }

        $item['answer'] = $this->new_answer(strtoupper($answer),$dynamic);

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
        return $item['accuracy'];
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
                        $s3 = 'https://s3-xplore.s3.ap-south-1.amazonaws.com/';
                        $name = str_replace($s3, '', $img);
                        Storage::disk('s3')->delete($name);
                    }
                    unset($json[$qid]);
                }
            }
            Storage::disk('s3')->put('urq/'.$jsonname.'.json', json_encode($json));
        }

        echo 1;
        exit();

    }

    public function rotate_image($slug,$user_id,$r){
        $name = str_replace('urq/', '',$r->get('name'));
        $imgurl = $r->get('imgurl');



        $angle = $r->get('rotate');
        $qid = intval($r->get('qid'));


        $bg = \Image::make($imgurl)->rotate($angle)->encode('jpg',100);
        $new_name = rand(10,100).'_'.$name;
        Storage::disk('s3')->put('urq/'.$new_name, (string)$bg,'public');

        $jsonname = $slug.'_'.$user_id;
        $jsonfile = $jsonname.'.json';

        if(Storage::disk('s3')->exists('urq/'.$jsonfile)){
            $json = json_decode(Storage::disk('s3')->get('urq/'.$jsonfile),true);
        }else{
            $json = array();
        }

        $path = Storage::disk('s3')->url('urq/'.$new_name);
        $json[$qid][$name] = $path;
        Storage::disk('s3')->put('urq/'.$jsonfile, json_encode($json));
        Storage::disk('s3')->delete('urq/'.$name);

        if($r->get('ajax')){
            echo $path;
            exit();
        }

        return redirect()->route('assessment.solutions.q',['slug'=>$slug,'question'=>$qid,'student'=>$r->get('student')]);


    }

    public function update_image($r){
        $name = str_replace('urq/', '',$r->get('name'));
        $slug = $r->get('slug');
        $imgurl = $r->get('imgurl');
        $user_id = $r->get('user_id');
        $qid = $r->get('qid');
        $width = intval($r->get('width'));
        $height = intval($r->get('height'));


        $bg = \Image::make($imgurl)->resize($width,$height);
        $b =$bg->encode('jpg',100);

        if(!Storage::disk('s3')->exists('urq/original_'.$name)){

            Storage::disk('s3')->put('urq/original_'.$name, (string)$b,'public');

        }

        $img = \Image::make($r->get('image'))->resize($width,$height);
        $bg->insert($img)->encode('jpg',100);

        $new_name = rand(10,100).'_'.$name;
        Storage::disk('s3')->put('urq/'.$new_name, (string)$bg,'public');


        $jsonname = $slug.'_'.$user_id;
        $jsonfile = $jsonname.'.json';


        if(Storage::disk('s3')->exists('urq/'.$jsonfile)){
            $json = json_decode(Storage::disk('s3')->get('urq/'.$jsonfile),true);
        }else{
            $json = array();
        }


        $path = Storage::disk('s3')->url('urq/'.$new_name);

        $json[$qid][$name] = $path;
        Storage::disk('s3')->put('urq/'.$jsonfile, json_encode($json));
        Storage::disk('s3')->delete('urq/'.$name);

        if($r->get('ajax')){
           // echo json_encode($jsonfile);
            echo $path;
            exit();
        }

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
                $filename = $name.'.'.$extension;
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

                $json[$qid][$name.'.jpg'] = $path;
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
            //file_put_contents($filepath, json_encode($exam,JSON_PRETTY_PRINT));
        }



        //precheck for auto activation
        $exam = $this->precheck_auto_activation($exam);
        //dd($exam);
        $entry=null;
        $attempt = null;
        $user = \Auth::user();
        $products = $exam->product_ids;
        $product = null;

        $user = \auth::user();

        if($user)
            $responses = Cache::get('responses_'.$user->id.'_'.$exam->id);
        else
            $responses = null;



        if($exam->active){
            if(!$responses)
                return view('appl.exam.assessment.inactive')->with('exam',$exam);
        }else if($exam->status==0){
            abort(403,'Test is in draft state');
        }


        if($products){
            $product = $exam->products[0];
        }
        if($user){
            if($products){
                 $entry = Cache::remember('entry_'.$exam->id.'_'.$user->id, 240, function() use($products,$user){
                        return DB::table('product_user')
                    ->whereIn('product_id', $products)
                    ->where('user_id', $user->id)
                    ->first();
                    });
                $product = $exam->products[0];

            }

            $attempt = $user->attempted_test($exam->id);//Test::where('test_id',$exam->id)->where('user_id',$user->id)->first();
            if($attempt)
            $entry = 1;
        }




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

        // if($slug=='tcsnqt' || $slug=='56865'){
        //     return view('appl.exam.assessment.completed')
        //                 ->with('exam',$exam);
        // }

        $d['branches'] = Cache::get('branches');
        $d['colleges'] = Cache::get('colleges');


        $questions = array();


        $ques = [];
        $i=0;

        if($request->get('student'))
            $student = User::where('username',$request->get('student'))->first();
        else
            $student = \auth::user();

        if(!$student)
            $student = \auth::user();

        $user_id = $student->id;
        $test_id = $exam->id;
        $user = $student;

        $jsonname = $slug.'_'.$user_id;
        $images = [];
        if(Storage::disk('s3')->exists('urq/'.$jsonname.'.json'))
            $images = json_decode(Storage::disk('s3')->get('urq/'.$jsonname.'.json'),true);
        else
            $images = [];


       

        // images
        $username = $student->username;
        $folder = 'webcam/'.$exam->id.'/';
        //$files = Storage::disk('s3')->allFiles($folder);

        // $mask= $username.'_'.$exam->id;
        // $image_files = array_where($files, function ($value, $key) use ($mask) {
        //    return starts_with(basename($value), $mask);
        // });

        $image_files = [];
        $one1 = $username.'_'.$exam->id.'_000.jpg';

        if(Storage::disk('s3')->exists($folder.$one1)){
            //  $selfie = $username.'_'.$exam->id.'_selfie.jpg';
            // $image_files['selfie_url'] = $folder.$selfie;

            // $idcard = $username.'_'.$exam->id.'_idcard.jpg';
            // $image_files['idcard_url'] = $folder.$idcard;

            // $one1 = $username.'_'.$exam->id.'_000.jpg';
            // $image_files['0'] = $folder.$one1;

            $one = $username.'_'.$exam->id.'_001.jpg';
            $image_files['1'] = $folder.$one;
            $two = $username.'_'.$exam->id.'_002.jpg';
            $image_files['2'] = $folder.$two;
            $three = $username.'_'.$exam->id.'_003.jpg';
            $image_files['3'] = $folder.$three;

            $three = $username.'_'.$exam->id.'_004.jpg';
            $image_files['4'] = $folder.$three;

            $three = $username.'_'.$exam->id.'_005.jpg';
            $image_files['5'] = $folder.$three;
            $three = $username.'_'.$exam->id.'_006.jpg';
            $image_files['6'] = $folder.$three;
            
        }
       
       

       

        
        foreach($image_files as $j=>$im){
           if (strpos($im, 'screen') !== false) {
                $images['screens'][$j] =$im ;
            }else if (strpos($im, 'idcard') !== false) {
                $images['idcard'][$j] =$im ;
            }else if (strpos($im, 'selfie') !== false) {
                $images['selfie'][$j] =$im ;
            }else if (strpos($im, 'json') !== false) {
                $images['json'][$j] =$im ;
            }else{
                $images['webcam'][$j] =$im ;
            }

        }

       


        $count = array('webcam'=>0,'screenshot'=>0);

        if(count($image_files)){
            $count['webcam'] = count($images['webcam']);
            if(isset($images['screens']))
            $count['screenshot'] = count($images['screens']);
            else
                $count['screenshot']  = 0;
        }


        // if(request()->get('images')){
        //     if(request()->get('images')=='webcam'){
        //         $count = $count['webcam'];
        //         $images = $images['webcam'];
        //     }else{
        //         $count = $count['screenshot'];
        //         $images = $images['screens'];
        //     }
        //     return view('appl.exam.assessment.images')->with('exam',$exam)->with('user',$student)->with('count',$count)->with('images',$images);
        // }



        $details = ['correct'=>0,'incorrect'=>'0','unattempted'=>0,'attempted'=>0,'avgpace'=>'0','testdate'=>null,'marks'=>0,'total'=>0,'evaluation'=>1];
        $details['course'] = $exam->name;
        $sum = 0;
        $c=0; $i=0; $u=0;

        $tests = Cache::remember('resp_'.$user_id.'_'.$test_id,240,function() use ($exam,$student){
            return Test::where('test_id',$exam->id)
                        ->where('user_id',$student->id)->get();
        });

        $test_keys = $tests->keyBy('question_id');

        if(request()->get('refresh')){
            Cache::forget('attempt_'.$user_id.'_'.$test_id);
             Cache::forget('attempt_section_'.$user_id.'_'.$test_id);
             Cache::forget('exam_type_'.$exam->slug);

        }

        $tests_overall = Cache::remember('attempt_'.$user_id.'_'.$test_id, 60, function() use ($exam,$student){
            return Tests_Overall::where('test_id',$exam->id)->where('user_id',$student->id)->first();
        });


        if(!$tests_overall){
            abort('403','Test not attempted');
        }

        //dd($tests->where('status',1));
        $evaluation = $tests->where('status',2);
        if(count($evaluation))
            $details['evaluation'] = 0;

        $tests_section = Cache::remember('attempt_section_'.$user_id.'_'.$test_id,60,function() use($exam,$student){
            return Tests_Section::where('test_id',$exam->id)->where('user_id',$student->id)->get();
        });
        $secs = $tests_section->groupBy('section_id');




        // api
        if(!count($tests)){
            if($request->get('reference')){
                $id = explode('_',$request->get('reference'))[1];
                $score = $exam->getScore($id);
                $tests = new Test();
                $tests->question_id = 809;
                $tests->test_id = $exam->id;
                $tests->user_id = $student->id;
                $tests->accuracy  = 1;
                $tests->answer  = 1;
                $tests->time  = 1;
                $tests->status = 1;
                $tests->save();

                if(!$score)
                    $score  = 0;

                $tests_section = new Tests_Section();
                $tests_section->test_id = $exam->id;
                $tests_section->user_id = $student->id;
                $tests_section->section_id = $exam->sections[0]->id;
                $tests_section->score = $score;
                $tests_section->time = 1;
                $tests_section->max = 100;
                $tests_section->save();

                $tests_overall = new Tests_Overall();
                $tests_overall->test_id = $exam->id;
                $tests_overall->user_id = $student->id;
                $tests_overall->score = $score;
                $tests_overall->time = 1;
                $tests_overall->max = 100;
                $tests_overall->save();

                Cache::forget('resp_'.$user_id.'_'.$test_id);
                Cache::forget('attempt_section_'.$user_id.'_'.$test_id);
                Cache::forget('attempt_'.$user_id.'_'.$test_id);

                //dd();

                return redirect()->to(request()->fullUrl());


            }else
                abort('404','Test not attempted');
        }
        $subjective = false;
        $sections = array();
        foreach($exam->sections as $section){
            if(isset($secs[$section->id][0]))
                $sections[$section->name] = $secs[$section->id][0];
                else
                $sections[$section->name] ='';
            $secs[$section->id] = $section;
            $qset = $exam->getQuestionsSection($section->id,$user->id);
            foreach($qset as $q){

                if(isset($images)){
                    if(isset($images[$q->id]))
                        $q->images = $images[$q->id];
                    else
                        $q->images = [];
                }else{
                    $q->images = [];
                }

                if(isset($test_keys[$q->id]->dynamic)){
                    $dynamic = $test_keys[$q->id]->dynamic;
                    $q = $this->option_swap2($q,$dynamic);
                }

                $questions[$i] = $q;

                $ques[$q->id] = $q;
                $ques_keys[$q->id]['topic'] = $q->topic;
                $ques_keys[$q->id]['section'] = $section->name;
                $i++;

                if($q->type=='sq' || $q->type=='urq' || $q->type=='csq')
                    $subjective= true;
            }

        }



        if(isset($section))
        if($section->name == 'typing'){
            $details['typing_performance'] = '';
            if($tests_overall->score > 60)
                $details['typing_performance'] = 'Excellent';
            else if($tests_overall->score > 40 && $tests_overall->score < 59)
                $details['typing_performance'] = 'Good';
            else if($tests_overall->score > 29 && $tests_overall->score < 39)
                $details['typing_performance'] = 'Average';
            else
                $details['typing_performance'] = 'Not upto the mark';

        }



        if(count($sections)==1)
            $sections = null;


        $details['correct_time'] =0;
        $details['incorrect_time']=0;
        $details['unattempted_time']=0;
        $topics = false;
        $review=false;

        $i=0;
        $typeslug= Cache::remember('exam_type_'.$exam->slug, 240, function() use($exam) {
            return $exam->examtype->slug;
        });
        if($exam->slug=='psychometric-test' || $typeslug=='psychometric-test')
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
                        ->with('data',$d)
                        ->with('m',$mc)
                        ->with('c',$cc)
                        ->with('typeslug',$typeslug)
                        ->with('student',$student)
                        ->with('chart',true);
        }

             //dd($tests->pluck('question_id'));

        if(!request()->get('reference') && $typeslug!='api')
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

            if(isset($ques_keys[$t->question_id]['topic'])){
               if($ques_keys[$t->question_id]['topic'])
                $topics = true;
            }else{
                 $ques_keys[$t->question_id]['topic'] = null;
                 $ques_keys[$t->question_id]['section'] = null;
                 if(!$ques[$t->question_id])
                    if(isset($t->question))
                        $ques[$t->question_id] = $t->question;
                    else
                        $ques[$t->question_id] = null;
                 //$ques[$t->question_id]->type = $t->question->type;
            }




            if($t->response){
                $details['attempted'] = $details['attempted'] + 1;
                if($t->accuracy==1){
                    $details['c'][$c]['topic'] = $ques_keys[$t->question_id]['topic'];
                    $details['c'][$c]['section'] = $ques_keys[$t->question_id]['section'];
                    $c++;
                    $details['correct'] = $details['correct'] + 1;
                    $details['correct_time'] = $details['correct_time'] + $t->time;
                    if($ques[$t->question_id]->type=='sq' || $ques[$t->question_id]->type=='urq' ||$ques[$t->question_id]->type=='csq')
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
                if($ques[$t->question_id]->type=='sq' || $ques[$t->question_id]->type=='urq' || $ques[$t->question_id]->type=='csq')
                        $details['marks'] = $details['marks'] + $t->mark;
            }

            $details['total'] = $details['total'] + $secs[$t->section_id]->mark;
            //dd();

        }


        if(!count($questions))
            $questions = [1];
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
        else if(request()->get('reference') ||  $typeslug=='api')
            $view = 'analysis_api';
        else if($exam->status==2)
            $view = "analysis_private";

        else
            $view = "analysis";


        return view('appl.exam.assessment.'.$view)
                        ->with('exam',$exam)
                        ->with('data',$d)
                        ->with('questions',$ques)
                        ->with('sections',$sections)
                        ->with('details',$details)
                        ->with('student',$student)
                        ->with('user',$student)
                        ->with('tests',$tests)
                        ->with('typeslug',$typeslug)
                        ->with('test_overall',$tests_overall)
                        ->with('review',true)
                        ->with('mathjax',$mathjax)
                        ->with('count',$count)
                        ->with('images',$images)
                        ->with('noback',1)
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

    public function comment(Request $request)
    {
        $id = $request->get('test_overall');


        $item= Tests_Overall::where('id',$id)->first();
        $item->comment = $request->comment;
        $item->save();

        Cache::forget('responses_'.$request->user_id.'_'.$request->test_id);
        flash('Comment Added')->success();

        return redirect()->route('assessment.responses',['slug'=>$request->slug,'student'=>$request->username,'forget'=>1]);

    }


    public function delete($slug,Request $request){

        if($request->get('user_id') && $request->get('test_id')){
            $user_id = $request->get('user_id');
            $test_id = $request->get('test_id');

            $attempts = Test::where('test_id',$test_id)->where('user_id',$user_id)->get();

            $jsonname = $slug.'_'.$user_id;
            $user = User::where('id',$user_id)->first();

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

            if(Storage::disk('s3')->exists('testlog/'.$test_id.'/'.$user->username.'.json')){
                Storage::disk('s3')->delete('testlog/'.$test_id.'/'.$user->username.'.json');
            }

             if(Storage::disk('s3')->exists('testlog/'.$test_id.'/log/'.$user->username.'_log.json')){
                Storage::disk('s3')->delete('testlog/'.$test_id.'/log/'.$user->username.'_log.json');
            }

            if(Storage::disk('s3')->exists('testlog/'.$test_id.'/chats/'.$user->username.'.json')){
                Storage::disk('s3')->delete('testlog/'.$test_id.'/chats/'.$user->username.'.json');
            }

            if(Storage::disk('s3')->exists('testlog/approvals/'.$test_id.'/'.$user->username.'.json')){
                Storage::disk('s3')->delete('testlog/approvals/'.$test_id.'/'.$user->username.'.json');
            }


            $name = 'testlog/pre-message/'.$test_id.'/'.$user->username.'.json';
            if(Storage::disk('s3')->exists($name)){
                Storage::disk('s3')->delete($name);
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
        flash('Test attempt DELETED')->success();
        return redirect()->route('assessment.show',$slug);


    }
}
