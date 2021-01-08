<?php

namespace PacketPrep\Http\Controllers\Job;

use Illuminate\Http\Request;
use PacketPrep\Http\Controllers\Controller;
use PacketPrep\User;
use PacketPrep\Models\Job\Post as Obj;
use PacketPrep\Models\College\Branch;
use PacketPrep\Models\College\College;
use PacketPrep\Models\Exam\Exam; 
use PacketPrep\Models\Exam\Tests_Overall;   
use Illuminate\Support\Facades\Storage;
use PacketPrep\Exports\UsersExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Input;
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;

use PacketPrep\Jobs\SendEmail;
use PacketPrep\Jobs\FaceDetect;
use PacketPrep\Mail\EmailForQueuing;
use Mail;

class PostController extends Controller
{
    public function __construct(){
        $this->app      =   'job';
        $this->module   =   'post';
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Obj $obj,Request $request)
    {

        $this->authorize('view', $obj);

        $search = $request->search;
        $item = $request->item;
        $user =\auth::user();


        if(request()->get('refresh')){
            $objs = $obj->where('title','LIKE',"%{$item}%")
                    ->orderBy('created_at','desc ')->with('user')->withCount('users')->get();
            foreach($objs as $oj){
                Cache::forget('post_'.$oj->id);
                Cache::put('post_'.$oj->id,$oj,240);
            }
            flash('Posts cache is refreshed!')->success();
            
        }

        if($user->isAdmin())
            $objs = $obj->where('title','LIKE',"%{$item}%")
                    ->orderBy('created_at','desc ')->with('user')->withCount('users')
                    ->paginate(config('global.no_of_records')); 
        else
            if($item)
                $objs = $obj->where('user_id',$user->id)->where('title','LIKE',"%{$item}%")
                    ->orderBy('created_at','desc ')->with('user')->withCount('users')
                    ->paginate(config('global.no_of_records')); 
            else
                $objs = $obj->where('user_id',$user->id)->orWhere('viewer_id',$user->id)
                    ->orderBy('created_at','desc ')->with('user')->withCount('users')
                    ->paginate(config('global.no_of_records')); 

        

        $view = $search ? 'list': 'index';

        return view('appl.'.$this->app.'.'.$this->module.'.'.$view)
                ->with('objs',$objs)
                ->with('obj',$obj)
                ->with('app',$this);
    }

    public function public_index(Obj $obj,Request $request)
    {


        $search = $request->search;
        $item = $request->item;
        $user = \auth::user();
        if($user){
            $myjobs = $user->posts;
        }else{
            $myjobs = array();
        }
        
        $objs = $obj->where('title','LIKE',"%{$item}%")
                    ->orderBy('created_at','desc ')
                    ->paginate(config('global.no_of_records'));   
        $view = $search ? 'public_list': 'public_index';

        return view('appl.'.$this->app.'.'.$this->module.'.'.$view)
                ->with('objs',$objs)
                ->with('obj',$obj)
                ->with('app',$this)
                ->with('myjobs',$myjobs);
    }

    public function analytics($slug,Request $request)
    {

        $search = $request->search;
        $item = $request->item;
        $obj = Obj::where('slug',$slug)->first();
        
        
        $this->authorize('view', $obj);
        
        $users = $obj->users;

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



        if(request()->get('sendmail')){
            //$users = $obj->users()->whereIn('year_of_passing',[2018,2019,2020])->get();
            $users = $obj->users()->get();
            $this->mailer($users);
            //echo "mailed";
        }


        $view ='analytics';

        return view('appl.'.$this->app.'.'.$this->module.'.'.$view)
                ->with('users',$users)
                ->with('data',$data)
                ->with('obj',$obj)
                ->with('app',$this);
    }


    public function applicant_index($slug,Request $request)
    {

        $search = $request->search;
        $item = $request->item;
        $filter = $request->filter;
        $profile = $request->get('profile');

       

        $obj = Cache::remember('post_appl_'.$slug ,240, function() use($slug){
            return Obj::where('slug',$slug)->withCount('users')->first();
        });

         if($request->get('refresh')==1){
            flash('Cache is Refreshed!')->success();
            Cache::forget('post_appl_'.$slug);
            Cache::forget('post_users_'.$slug);

            if($obj->conditions){
                $conditions = json_decode($obj->conditions,true);
                foreach($conditions as $p=>$c){
                    Cache::forget('filter_'.$slug.'_'.$p.'_');
                    Cache::forget('filter_'.$slug.'_'.$p.'_YES');
                    Cache::forget('filter_'.$slug.'_'.$p.'_NO');
                    Cache::forget('filter_'.$slug.'_'.$p.'_MAYBE');
                }

            }
            Cache::forget('filter_'.$slug.'_');
            Cache::forget('filter_'.$slug.'_YES');
            Cache::forget('filter_'.$slug.'_NO');
            Cache::forget('filter_'.$slug.'_MAYBE');
            
        }
        
        $colleges = Cache::remember('colleges',240, function(){

            return College::all()->keyBy('id');
        });
        $branches = Cache::remember('branches',240,function(){
            return Branch::all()->keyBy('id');
        });

        $exam_data = array();
        $exms = array();
        $conditions = [];

        if($obj->exam_ids){
            $exams = explode(',',$obj->exam_ids);
            foreach($exams as $k=>$e){
                $ex =  Cache::remember('pa_'.$e,240,function() use($e){
                return Exam::where('slug',$e)->first();
                });
                $exms[$k] = $ex;

                $exam_data[$ex->id] = Cache::remember('pad_'.$ex->slug,240,function() use ($ex){
                return Tests_Overall::select('score','user_id')->where('test_id',$ex->id)->get()->keyBy('user_id');
                });

            }
        }



        
        $this->authorize('view', $obj);

        $this->yes = 0;
        $this->no = 0;
        $this->maybe = 0;
        $this->total = 0;
        $this->none = 0;
        
        if($request->get('export')){
            //$users = $obj->users->pluck('id')->toArray();
            $objs = $obj->users()->get();//User::whereIn('id',$users)->paginate(10000);
            $colleges = College::all()->keyBy('id');
            $branches = Branch::all()->keyBy('id');
            

            request()->session()->put('users',$objs);
                request()->session()->put('colleges',$colleges);
                request()->session()->put('branches',$branches);
                request()->session()->put('exam_data',$exam_data);
                request()->session()->put('exams',$exms);
                $name = "Applicants_job_".$obj->slug.".xlsx";
                ob_end_clean(); // this
                ob_start(); 
                return Excel::download(new UsersExport, $name);

            // if($objs->total() <= 500){
                
            // }else{
            //     flash('Data more than 500 records has to be queued. Kindly contact administrator')->success();
            // }
            
        } else{
            $users = Cache::remember('post_users_'.$slug ,240, function() use($obj){
                    return $obj->users->toArray();
                });
            foreach($users as $k=>$usersx){
                foreach($exms as $ek =>$ev){
                    $users[$k][$ev->slug] =0;
                    if(isset($exam_data[$ev->id][$usersx['id']]))
                    $users[$k][$ev->slug] = $exam_data[$ev->id][$usersx['id']]->score;
                }
            }

            $ud=[];
            //check for profile conditions
            if($obj->conditions){
                $conditions = json_decode($obj->conditions,true);

                foreach($conditions as $p=>$c){
                    $conditions[$p]['count'] = 0;
                    $conditions[$p]['uids'] = [];
                    foreach($users as $uc => $ucx){
                        $u_yes = 1;
                        foreach($c as $e=>$v){
                            if($ucx[$e]<$v){
                                $u_yes = 0;
                                break;
                            }
                        }

                        if($u_yes){
                            $conditions[$p]['count']++;
                            array_push($conditions[$p]['uids'], $ucx['id']);
                            array_push($ud, $ucx);
                        }
                    }
                    
                }
            }  


            foreach($users as $usx){
                if($usx['pivot']['shortlisted']=='YES')
                    $this->yes++;
                elseif($usx['pivot']['shortlisted']=='NO')
                    $this->no++; 
                elseif($usx['pivot']['shortlisted']=='MAY BE')
                    $this->maybe++; 
                else
                    $this->none++;

                $this->total++;
            }

            if($item)
            $objs = $this->paginateAnswers($obj->users()->where('name','LIKE',"%{$item}%")->orderBy('pivot_created_at','desc')->get()->toArray(),30);
            else if($filter || $profile){


                $yop = explode(',',$request->get('yop'));
                if(!$yop[0]){
                    $yop=['2016','2017','2018','2019','2020','2021','2022','2023','2024'];
                }
                $branch = explode(',',$request->get('branch'));
                if(!$branch[0]){
                    $branch = $branches->pluck('id')->toArray();
                }

                $shortlisted = $request->get('shortlisted');

                $st = str_replace(' ', '', $request->get('shortlisted'));

                if(!$shortlisted){
                    $shortlisted = ['YES','NO','MAY BE'];
                }else{
                    $filter = 'Shortlisted - '.$shortlisted;
                    $shortlisted = [$shortlisted];
                    
                }

                $academics = $request->get('academics');

                if(!$academics){
                    $academics = 0;
                }

                $profile = $request->get('profile');



                if($profile)
                    $filter = ucwords(str_replace('_', ' ', $profile));

                

                if(isset($conditions[$profile]['uids']))
                    $p_uids = $conditions[$profile]['uids'];
                else
                    $p_uids = 0;

                //dd($obj->users()->first());
                //dd($obj->users()->wherePivot('created_at','')->get());



                $objs_cache_filter = Cache::remember('filter_'.$slug.'_'.$profile.'_'.$st,240, function() use($obj,$shortlisted,$p_uids){

                    

                    if($p_uids)
                        $data = $obj->users()->whereIn('id',$p_uids)
                        ->orderBy('pivot_created_at','desc')->get()->toArray();

                    else
                        $data = $obj->users()
                        ->wherePivotIn('shortlisted',$shortlisted)
                        ->orderBy('pivot_created_at','desc')->get()->toArray();

                    return $data;
                });

                $objs = $this->paginateAnswers($objs_cache_filter,config('global.no_of_records')); 
            }else{
                
                $objs = $this->paginateAnswers($users,config('global.no_of_records')); 
            }
        } 

        
        


        $view = $search ? 'applicant_list': 'applicant_index';

        return view('appl.'.$this->app.'.'.$this->module.'.'.$view)
                ->with('objs',$objs)
                ->with('obj',$obj)
                ->with('colleges',$colleges)
                ->with('branches',$branches)
                ->with('exams',$exms)
                ->with('conditions',$conditions)
                ->with('filter',$filter)
                ->with('exam_data',$exam_data)
                ->with('app',$this);
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

    public function mailer($users){
        

        foreach($users as $i=>$u){
            $details['email'] = $u->email;
            $details['name'] = $u->name;

             $subject = 'Requirement for Java Full Stack Developers';
            $content = '<div dir=3D"ltr">
<br>We have openings for 150 java fullstack developers with 14 clients. Details are as follows<br><br>1. Designation - Java Full Stack Developer<br>2.
 Year of Passing - 2018, 2019, 2020<br>3. Qualification - BTech (Any Branch
)<br>4. Academic Percentage - 60% (10th, 12th, Graduation) <br>5. Skills Required - Excellent Communication, Core Java, Adv Java, Spring MVC, AWS, Git
<br>6. Work Location - Pan India<br></div>7. CTC - 4.5 LPA to 6.5 LPA<br><d
iv><br>Selection Process<br></div><div>1. Pre-assessment on Aptitude, Verbal and Java Programming - 100Q/100min</div><div>2. Internship &amp; Training
 on Full stack java</div><div>3. Technical Test (Client Location)<br></div>
<div><br>Selected
 students will be recruited as Interns with Packetprep and will be 
trained in full-stack java (adv java, spring framework and aws 
deployment) for 3 months. <br><br>Note:<br><ul><li>For the candidates
 with pre-assessment score of 85+/100, PacketPrep will sponsor the complete
 training cost of Rs.30,000. </li><li>For the candidates with pre-assessment scores of 60 to 85 can avail 70% fee waiver on the training cost. <br></l
i><li>95% attendance is mandatory to sit for the technical test.</li><li>Technical Internship letter will be awarded to students with 95% attendance only.</li></ul>If you have not applied, then you can apply for the pre-assessment (Online Test) using the following link</div><div><a href="https://forms.gle/mHW71asQUcdo4bzW6" target="_blank">https://forms.gle/mHW71asQUcdo4bzW6</a></div><div><br></div><div>The test link will be shared on e
mail one day before the exam. <br></div><div><br></div><div>Last date to apply : 8th Jan 2021<font color=3D"#888888">, 8PM</font></div><br clear=3D"all">
    <br>
    <br>
';

//             $subject = 'Test Link for Tech/voice-support role 24[7]';
//             $content = '
//   <div class="io-ox-signature">
//    <div class="default-style">
//     <div class="default-style">
//      24 seven is conducting an online recruitment&nbsp; test for the position of Tech/Voice - support
//      <br>&nbsp;
//      <br>Below are the details of the online assessment
//      <br>
//      <br>Test URL:<a href="https://xplore.co.in/test/566962">&nbsp;</a><a class="f20 text-white" href="https://xplore.co.in/test/566962 ">https://xplore.co.in/test/566962</a>
//      <br>
//     </div>
//     <div class="default-style">
//      <br>
//     </div>
//     <div class="default-style">
//      Access Code: XPLORE123
//     </div>
//     <div class="default-style">
//      <br>
//     </div>
//     <div class="default-style">
//      <br><strong>Date &amp; Time of Assessment</strong>: 09rd Sep 2020 i.e Wednesday; 10AM IST (The test link will be activated at 10AM and will be open till 2PM)
//     </div>
//     <div class="default-style">
//      <br>
//     </div>
//     <div class="default-style">
//      <br>Note : 1)You can take test only in<strong>&nbsp;Laptop/desktop&nbsp;.</strong>
//     </div>
//     <div class="default-style">
//      &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; 2) Please register at&nbsp;<a href="https://xplore.co.in/register">Xplore.co.in/register&nbsp;</a>&nbsp;before taking the test
//     </div>
//     <div class="default-style">
//      <br>&nbsp; &nbsp; &nbsp;
//      <br>Instructions:
//      <ul>
//       <li>Each question carries 1 mark and no negative marking</li>
//       <li><strong>Mandatory</strong>: This is a AI proctored examination and you are required to keep your web-camera on in the entire duration of the examination failing which, you might not get selected</li>
//       <li>The test should be taken&nbsp; from <strong>desktop/laptop/mobile/tablet with webcam</strong> facilities.</li>
//       <li>Please make sure that you&nbsp;<strong>disable all&nbsp; notifications</strong>. Else, the test will be terminated in between</li>
//       <li>Please make sure that you have uninterrupted power and internet facility (minimum 2 MBPS required)</li>
//       <li>Please make sure that your camera is switched on and you are facing the light source and camera</li>
//      </ul>
//      <br>
//     </div>
//    </div>
//   </div>
// ';

            //Mail::to($details['email'])->send(new EmailForQueuing($details,$subject,$content));
            SendEmail::dispatch($details,$subject,$content)->delay(now()->addSeconds($i*3));
        }
        
        dd('Email Queued - '.count($users));
        return view('home');
    }

    
    public function updateApplicant(Request $request){
        
        $user_id = $request->get('user_id');
        $post_id = $request->get('post_id');
        $score = $request->get('score');
        $shortlisted = $request->get('shortlisted');



        $obj = new Obj();

        $obj->updateApplicant($post_id,$user_id,$score,$shortlisted);


        echo 1;
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $obj = new Obj();
        $this->authorize('create', $obj);
        $slug = rand(10000,100000);
        $e = Obj::where('slug',$slug)->first();

        if($e){
            $slug = rand(10000,100000);
        }

        $this->education = ['BTECH','MTECH','DEGREE','CSE','IT','EEE','MECH','ECE','CIVIL','BCOM','BSC','BCA','BBA','MBA','BPHARM','MPHARM','MCOM','MCA','MSC','OTHER'];
        $this->salary =['NOT DISCLOSED','0 to 3LPA', '3 to 6LPA','6 to 9LPA', '1.8LPA to 13LPA'];
        $this->location = ['ALL INDIA','HYDERABAD','BENGALURE','CHENNAI','MUMBAI','PUNE','DELHI','NCR REGION','SURAT','KOTA','AHMEDABAD','CHANDIGARH','COIMBATORE','GURGAON','GOA','OTHER' ];
        $this->yop = ['2016','2017','2018','2019','2020','2021'];
        $this->academic = ['55','60','65','70','75'];

        $data['hr-managers'] = \auth::user()->getRole('hr-manager');

        return view('appl.'.$this->app.'.'.$this->module.'.createedit')
                ->with('stub','Create')
                ->with('jqueryui',true)
                ->with('editor',1)
                ->with('obj',$obj)
                ->with('slug',$slug)
                ->with('data',$data)
                ->with('app',$this);
    }

   

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Obj $obj, Request $request)
    {
         try{

            /* locations */
            if(isset($request->all()['locations'])){
                $location = implode(',', $request->all()['locations']);
                $request->request->add(['location' => $location]);
            }

            /* educations */
            if(isset($request->all()['educations'])){
                $education = implode(',', $request->all()['educations']);
                $request->request->add(['education' => $education]);
            }

            /* year of passing */
            if($request->get('yops')){
                $yop = implode(',', $request->get('yops'));

                $request->request->add(['yop' => $yop]);
            }

             /* If image is given upload and store path */
            if(isset($request->all()['file_'])){
                $file      = $request->all()['file_'];
                $filename = 'job_'.$request->get('slug').'.'.$file->getClientOriginalExtension();
                $path = Storage::disk('s3')->putFileAs('post', $request->file('file_'),$filename);

                $request->merge(['image' => $path]);
            }
            if(isset($request->all()['file2_'])){
                $file      = $request->all()['file2_'];
                $filename = 'job_b_'.$request->get('slug').'.'.$file->getClientOriginalExtension();
                $path = Storage::disk('s3')->putFileAs('post', $request->file('file2_'),$filename);

                $request->merge(['image' => $path]);
            }

            if(!$request->all()['last_date']){
                $last_date = \carbon\carbon::now()->addDays(3);
                $request->merge(['last_date' => $last_date]);
            }

            $details = summernote_imageupload(\auth::user(),$request->details);
            $request->merge(['details' => $details]);

            $obj = $obj->create($request->all());

            Cache::forever('post_'.$obj->id,$obj);

            flash('A new ('.$this->app.'/'.$this->module.') item is created!')->success();
            return redirect()->route($this->module.'.index');
        }
        catch (QueryException $e){
           $error_code = $e->errorInfo[1];
            if($error_code == 1062){
                flash('Some error in Creating the record')->error();
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
        $obj = Obj::where('slug',$id)->withCount('users')->first();
        $latest = $obj->users()->orderBy('pivot_created_at','desc')->limit(5)->get();
        $branches = Branch::all()->keyBy('id');

        Cache::forget('post_appl_'.$id);
        Cache::forget('post_users_'.$id);

        $this->authorize('view', $obj);

        if(request()->get('delete')){
            if(Storage::disk('public')->exists('post/job_b_'.$obj->slug.'.jpg'))
                    Storage::disk('public')->delete('post/job_b_'.$obj->slug.'.jpg');
            if(Storage::disk('public')->exists('post/job_b_'.$obj->slug.'.png'))
                    Storage::disk('public')->delete('post/job_b_'.$obj->slug.'.png');
        }
        if($obj)
            return view('appl.'.$this->app.'.'.$this->module.'.show')
                    ->with('obj',$obj)->with('latest',$latest)->with('app',$this)->with('branches',$branches);
        else
            abort(404);
    }

    public function public_show($id,Request $request)
    {

        $user = \auth::user();
        $obj = Cache::remember('post_'.$id,240,function() use($id){
            return Obj::where('slug',$id)->first();
        });

        // if(!$obj->status)
        //     abort('403','Unauthorized Access');

        if($request->get('apply')==1){
          
            if($user){
                if(!$obj->users->contains($user->id)){
                    $obj->users()->attach($user->id,['created_at'=>date("Y-m-d H:i:s")]);
                    flash('Successfully applied the job')->success(); 
                }
                
            }
            $obj = Obj::where('slug',$id)->first();
        }

        

        if($obj)
            return view('appl.'.$this->app.'.'.$this->module.'.public_show')
                    ->with('obj',$obj)->with('app',$this);
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
        $obj= Obj::where('slug',$id)->first();
        $this->authorize('update', $obj);

        $this->education = ['BTECH','MTECH','DEGREE','CSE','IT','EEE','MECH','ECE','CIVIL','BCOM','BCA','BSC','BBA','MBA','BPHARM','MPHARM','MCOM','MCA','MSC','OTHER'];
        $this->salary =['NOT DISCLOSED','0 to 3LPA', '3 to 6LPA','6 to 9LPA','1.8LPA to 13LPA'];
        $this->location = ['ALL INDIA','HYDERABAD','BENGALURE','CHENNAI','MUMBAI','PUNE','DELHI','NCR REGION','SURAT','KOTA','AHMEDABAD','CHANDIGARH','COIMBATORE','GURGAON','GOA','OTHER' ];
        $this->yop = ['2016','2017','2018','2019','2020','2021'];
        $this->academic = ['55','60','65','70','75'];

        $data['hr-managers'] = \auth::user()->getRole('hr-manager');

        if($obj)
            return view('appl.'.$this->app.'.'.$this->module.'.createedit')
                ->with('stub','Update')
                ->with('jqueryui',true)
                ->with('editor',1)
                ->with('data',$data)
                ->with('obj',$obj)->with('app',$this);
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
    public function update(Request $request, $id)
    {
        try{
            $obj = Obj::where('slug',$id)->first();

            /* locations */
            if(isset($request->all()['locations'])){
                $location = implode(',', $request->all()['locations']);
                $request->request->add(['location' => $location]);
            }

            /* educations */
            if(isset($request->all()['educations'])){
                $education = implode(',', $request->all()['educations']);
                $request->request->add(['education' => $education]);
            }

            /* year of passing */
            if($request->get('yops')){
                $yop = implode(',', $request->get('yops'));

                $request->request->add(['yop' => $yop]);
            }

             /* If image is given upload and store path */
            if(isset($request->all()['file_'])){

                /* delete previous image */
                if(Storage::disk('s3')->exists('post/job_'.$obj->slug.'.jpg'))
                    Storage::disk('s3')->delete('post/job_'.$obj->slug.'.jpg');
                if(Storage::disk('s3')->exists('post/job_'.$obj->slug.'.png'))
                    Storage::disk('s3')->delete('post/job_'.$obj->slug.'.png');
            
                $file      = $request->all()['file_'];
                $filename = 'job_'.$request->get('slug').'.'.$file->getClientOriginalExtension();
                $path = Storage::disk('s3')->putFileAs('post', $request->file('file_'),$filename,'public');

                $request->merge(['image' => $path]);
            }

            if(isset($request->all()['file2_'])){

                /* delete previous image */
                if(Storage::disk('s3')->exists('post/job_b_'.$obj->slug.'.jpg'))
                    Storage::disk('s3')->delete('post/job_b_'.$obj->slug.'.jpg');
                if(Storage::disk('s3')->exists('post/job_b_'.$obj->slug.'.png'))
                    Storage::disk('s3')->delete('post/job_b_'.$obj->slug.'.png');

                $file      = $request->all()['file2_'];
                $filename = 'job_b_'.$request->get('slug').'.'.$file->getClientOriginalExtension();
                $path = Storage::disk('s3')->putFileAs('post', $request->file('file2_'),$filename,'public');

                $request->merge(['image' => $path]);
            }

            if(!$request->all()['last_date']){
                $last_date = \carbon\carbon::now()->addDays(3);
                $request->merge(['last_date' => $last_date]);
            }
            $details = summernote_imageupload(\auth::user(),$request->details);
            $request->merge(['details' => $details]);



            $this->authorize('update', $obj);
            $obj->update($request->all()); 

            Cache::forget('post_'.$obj->slug);
            Cache::forever('post_'.$obj->slug,$obj);
            flash('Job post item is updated!')->success();
            return redirect()->route($this->module.'.show',$id);
        }
        catch (QueryException $e){
           $error_code = $e->errorInfo[1];
            if($error_code == 1062){
                 flash('Some error in updating the record')->error();
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
        $obj = Obj::where('slug',$id)->first();
        $this->authorize('update', $obj);
        $obj->delete();

        flash('('.$this->app.'/'.$this->module.') item  Successfully deleted!')->success();
        return redirect()->route($this->module.'.index');
    }
}
