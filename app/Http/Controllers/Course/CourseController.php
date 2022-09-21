<?php

namespace PacketPrep\Http\Controllers\Course;

use Illuminate\Http\Request;
use PacketPrep\Http\Controllers\Controller;
use PacketPrep\Models\Course\Course;
use PacketPrep\Models\Dataentry\Project;
use PacketPrep\Models\Dataentry\Tag;
use PacketPrep\Models\Dataentry\Category;
use PacketPrep\Models\Dataentry\Question;
use PacketPrep\Models\Product\Product;
use PacketPrep\Models\Product\Order;
use PacketPrep\Models\Exam\Exam;
use PacketPrep\Models\Exam\Tests_Overall;
use PacketPrep\Models\Exam\Examtype;
use PacketPrep\Models\Course\Practice;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Cache;
use PacketPrep\Models\College\College;
use PacketPrep\Models\College\Branch;
use PacketPrep\User;

use Illuminate\Support\Facades\DB;

class CourseController extends Controller
{
    public function __construct(){
        $this->cache_path =  '../storage/app/cache/courses/';
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Course $course,Request $request)
    {
        //$this->authorize('view', $course);

        $search = $request->search;
        $item = $request->item;

        $filename = 'index.courses.json';
        $filepath = $this->cache_path.$filename;
        /* update in cache folder */
        if($request->refresh){

            $courses = $course->where('name','LIKE',"%{$item}%")->orderBy('created_at','asc')->paginate(config('global.no_of_records')); 
            //Storage::disk('s3')->put('courses/'.$filename, json_encode($courses,JSON_PRETTY_PRINT));
            $course->updatecache($courses,null);
            //file_put_contents($filepath, json_encode($courses,JSON_PRETTY_PRINT));

            foreach($courses as $obj){
                if($obj->status){
                    $obj->products = $obj->products;
                    $course_data = $obj->category_list($obj->slug);
                    $obj->categories = $course_data['categories'];
                    $obj->ques_count = $course_data['ques_count'];
                    $obj->nodes = $course_data['nodes'];
                    $obj->exams = $course_data['exams'];
                    $obj->tests = $course_data['tests'];
                    $filename = $obj->slug.'.json';
                    $filepath = $this->cache_path.$filename;
                    //file_put_contents($filepath, json_encode($obj,JSON_PRETTY_PRINT));
                    //Storage::disk('s3')->put('courses/'.$filename, json_encode($obj,JSON_PRETTY_PRINT));
                    $obj->updatecache(null,$obj);
                } 
                
            }

            flash('Article Pages Cache Updated')->success();
        }

        if($item)
            $courses = $course->where('name','LIKE',"%{$item}%")->orderBy('created_at','asc')->paginate(config('global.no_of_records'));
        else
        {
            $courses = Cache::get('courses');
            if(!$courses){
                $courses = $course->where('name','LIKE',"%{$item}%")->orderBy('created_at','asc')->paginate(config('global.no_of_records'));
            }
        }
        $view = $search ? 'list': 'index';



        return view('appl.course.course.'.$view)
        ->with('courses',$courses)->with('course',new Course());
    }

    public function batches($id){
        $course = Cache::get('course_'.$id);

        if(!$course){
            $course = Course::where('slug',$id)->first();
            $course_data = $course->category_list($course->slug);
            $course->categories = json_decode(json_encode($course_data['categories']));
            $course->ques_count = $course_data['ques_count'];
            $course->nodes = $course_data['nodes'];
            $course->exams = $course_data['exams'];
            $course->tests = $course_data['tests'];
        }


         if(!\auth::user())
            abort('403','Unauthorized');
        if(!\auth::user()->isSiteAdmin())
            abort('403','Unauthorized');

        $batch=request()->get('batches');
        $batches = [];
        if(request()->get('batches')){
            $batches = explode(',',request()->get('batches'));
        }
        
        $start = $end = null;

        $start = request()->get('start');
        $end = request()->get('end');


        $date = \Carbon\Carbon::today()->subDays(7);
        $data = [];
       
        $avg = [];
        foreach($batches as $bno){
            $user_practice = [];
            $users = [];
            $practice_set=[];


            if($bno){
                $total = 0;
                $users = User::where('info',$bno)->where('client_slug',subdomain())->where('role',1)->get()->keyBy('id');

                $data[$bno]['users'] = $users;
                if(!count($users ))
                    $countuser = 1;
                else
                    $countuser = count($users);

                $uids = $users->pluck('id')->toArray();

                if($start)
                $user_practice = Practice::whereIn('user_id',$uids)->where('course_id',$course->id)->where('created_at','>=',$start)->where('created_at','<=',$end)->get()->groupBy('user_id');
                else
                $user_practice = Practice::whereIn('user_id',$uids)->where('course_id',$course->id)->get()->groupBy('user_id');

                foreach($user_practice as $uid=>$p){
                    $practice_set[$uid] = $p->sum('accuracy');
                    $total = $total + $p->sum('accuracy');
                }

                foreach($users as $u){
                    if(!isset($practice_set[$u->id]))
                        $practice_set[$u->id] = 0;
                }

                $data[$bno]['batch'] = $bno;
                $data[$bno]['practice_set'] = $practice_set; 

                 arsort($practice_set);
                $pavg = $total / $countuser;

                if($start)
                $user_practice2 = Practice::whereIn('user_id',$uids)->where('course_id',$course->id)->where('created_at','>=',$start)->where('created_at','<=',$end)->get()->groupBy('user_id');
                else
                $user_practice2 = Practice::whereIn('user_id',$uids)->where('course_id',$course->id)->where('created_at','>=',$date)->get()->groupBy('user_id');

                $total2 =0;
                foreach($user_practice2 as $uid=>$p){
                    $total2 = $total2 + $p->sum('accuracy');
                }
                $wpavg = $total2 / $countuser;
                $data[$bno]['total2'] = $total2;
                $data[$bno]['pavg'] = $pavg;
                $data[$bno]['wpavg'] = $wpavg;

                if($start)
                $tests_overall = Tests_Overall::whereIn('user_id',$uids)->where('created_at','>=',$start)->whereIn('test_id',array_keys($course->tests))->where('created_at','<=',$end)->where('test_id','!=',2623)->get()->groupBy('user_id');
                else
                   $tests_overall = Tests_Overall::whereIn('user_id',$uids)->whereIn('test_id',array_keys($course->tests))->where('test_id','!=',2623)->get()->groupBy('user_id');
                 
                $data[$bno]['tests_overall'] = $tests_overall;
                $total =0;
                $data[$bno]['total_tests'] = Tests_Overall::whereIn('user_id',$uids)->where('created_at','>=',$start)->where('created_at','<=',$end)->whereIn('test_id',array_keys($course->tests))->where('test_id','!=',2623)->count();

                if(Tests_Overall::whereIn('user_id',$uids)->avg('max'))
                    $data[$bno]['tcgpa'] = round(Tests_Overall::whereIn('user_id',$uids)->where('created_at','>=',$start)->whereIn('test_id',array_keys($course->tests))->where('test_id','!=',2623)->where('created_at','<=',$end)->avg('score')*10 / Tests_Overall::whereIn('user_id',$uids)->avg('max'),2);
                else
                    $data[$bno]['tcgpa'] = 0;
            }


        }        

       

        $d['p_date'] = $date;
        $d['date'] = \Carbon\Carbon::today();
        $d['btotal']=0;
        $d['bavg']=0;
        $d['btotal_name'] ='';
        $d['bavg_name'] = '';
        foreach($data as $bno){
            if($bno['wpavg']>$d['bavg']){
                $d['bavg'] = round($bno['wpavg'],2);
                $d['bavg_name'] = strtoupper($bno['batch']);
            }
            if($bno['total2']>$d['btotal']){
                $d['btotal'] = $bno['total2'];
                $d['btotal_name'] = strtoupper($bno['batch']);
            }

        }

        $branches = Cache::remember('branches',240,function(){
                    return Branch::all()->keyBy('id');
                });

          return view('appl.course.course.batches')
                ->with('data',$data)
                ->with('d',$d)
                ->with('start',$start)
                ->with('end',$end)
                ->with('jqueryui',true)
                ->with('branches',$branches)
                ->with('course',$course);

    }

    public function analytics($id){
        $course = Cache::get('course_'.$id);

        if(!$course){
            $course = Course::where('slug',$id)->first();
            $course_data = $course->category_list($course->slug);
            $course->categories = json_decode(json_encode($course_data['categories']));
            $course->ques_count = $course_data['ques_count'];
            $course->nodes = $course_data['nodes'];
            $course->exams = $course_data['exams'];
            $course->tests = $course_data['tests'];
        }
        if(!\auth::user())
            abort('403','Unauthorized');
        if(!\auth::user()->isSiteAdmin())
            abort('403','Unauthorized');

        $batches = [];
        if(request()->get('course'))
        dd($course);
        $topic = request()->get('topic');
        $total = $course->ques_count;
        $category = Category::where('slug',$topic)->first();
        $batches =[];
        if(!request()->get('batch')){
            $bno=0;
             return view('appl.course.course.analytics')
                ->with('stub','Create')
                ->with('editor','true')
                ->with('category',$category)
                ->with('course',$course);
        }else{
            $bno = str_replace(',','_',request()->get('batch'));
             if(strpos(request()->get('batch'),',')!==false){
                $batches = explode(',',request()->get('batch'));
            }
                

            
        }

        if(request()->get('refresh'))
        {
            Cache::forget('users_'.subdomain().'_'.$bno);
        }


        if($bno)
            $users = Cache::remember('users_'.subdomain().'_'.$bno, 120, function() use ($bno) { 
                return User::where('info',$bno)->where('client_slug',subdomain())->get();
            });

        if(count($batches)){
            $users = User::whereIn('info',$batches)->where('client_slug',subdomain())->get();
        }
            
        $uids = $users->pluck('id')->toArray();
        if($category){
            $cid = $category->id;
            if(isset($course->categories->$cid))
                $total = $course->categories->$cid->total;
            else
                $total =0;
            $practice = Practice::whereIn('user_id',$uids)->where('course_id',$course->id)->where('category_id',$category->id)->get()->groupBy('user_id');
        }
        else{
            $practice = Practice::whereIn('user_id',$uids)->where('course_id',$course->id)->get()->groupBy('user_id');
        }

        foreach($users as $id=>$u){
            $batches[strtoupper($u->info)]['name'] = strtoupper($u->info);
             $batches[strtoupper($u->info)]['avg'] = 0;
            if(isset($batches[strtoupper($u->info)]['total']))
            {
                if(isset($practice[$u->id]))
                $batches[strtoupper($u->info)]['total'] = $batches[strtoupper($u->info)]['total'] +count($practice[$u->id]);
                $batches[strtoupper($u->info)]['count']++;
            }else{
                $batches[strtoupper($u->info)]['total']  = 0;
                $batches[strtoupper($u->info)]['count'] = 1;
                if(isset($practice[$u->id]))
                $batches[strtoupper($u->info)]['total'] = count($practice[$u->id]);
            }
        }

        foreach($batches as $h=>$j){
            $batches[$h]['avg'] = round($batches[$h]['total']/$batches[$h]['count'],2);
        }
      

        
        return view('appl.course.course.analytics')
                ->with('stub','Create')
                ->with('editor','true')
                ->with('users',$users)
                ->with('practice',$practice)
                ->with('category',$category)
                ->with('total',$total)
                ->with('batches',$batches)
                ->with('course',$course);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $course = new Course();
        $this->authorize('create', $course);

        return view('appl.course.course.createedit')
                ->with('stub','Create')
                ->with('editor','true')
                ->with('course',$course);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Course $course,Request $request)
    {

        try{

            //dd($request->all());

            $request->merge(['slug' => str_replace(' ', '-', $request->slug)]);
            $course = Course::create($request->all());

            // save category
            /*
            $category = new Category;
            $child_attributes =['name'=>$request->name,'slug'=>$request->slug];
            $child = new Category($child_attributes);
            $child->save();*/

            flash('A new Course('.$request->name.') is created!')->success();
            return redirect()->route('course.index');
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
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //load course
        $filename = $id.'.json';
        $filepath = $this->cache_path.$filename;

        $course = Cache::get('course_'.$id);




        if(!$course){
            
            $course = Course::where('slug',$id)->first();
            $course_data = $course->category_list($course->slug);
            $course->categories = json_decode(json_encode($course_data['categories']));
            $course->ques_count = $course_data['ques_count'];
            $course->nodes = $course_data['nodes'];
            $course->exams = $course_data['exams'];
            $course->tests = $course_data['tests'];

        }


        if(request()->get('refresh'))
            {
                Cache::forget('course_'.$id);
                $course->updatecache(null,$course);
                session()->forget('bno');
                flash('Article Pages Cache Updated')->success();
            }


        
        //dd($course->categories);

        if(!$course)
            abort('404','Course Not Found');
        
        $product_ids = [];
        if(isset($course->products))
        foreach($course->products as $product)
        {
            if($product->slug == $id)
                $course->product = $product;
            array_push($product_ids, $product->id);
        }
        $exam_ids = [];


        foreach($course->nodes as $n)
        {
            foreach($n->children as $c){
                if($c->exam_id)
                array_push($exam_ids, $c->exam_id); 
            }
            
        }

        foreach($course->exams as $e){
                array_push($exam_ids, $e->id); 
        }

        if($course->slug=='quantitative-aptitude')
            $course->exams = null;

        if(!isset($course->product))
        foreach($course->products as $product)
        {
            if($product->slug != 'premium-access')
                $course->product = $product;
        }

        if(!isset($course->product))
            $course->product = null;

        $user = \Auth::user();
        $entry=null;
        if($user){
            $entry = DB::table('product_user')
                    ->whereIn('product_id', $product_ids)
                    ->where('user_id', $user->id)
                    ->orderBy('valid_till','desc')
                    ->first();
            
            $practice = DB::table('practices')
                    ->where('course_id', $course->id)
                    ->where('user_id',\auth()->user()->id)
                    ->get();
            $sum =0;$time = 0;
            $count = count($practice);
            foreach($practice as $p){
                if($p->accuracy)
                    $sum++;
                $time = $time + $p->time;
            }
            $dat['practice'] = $practice;
            $dat['attempted'] = count($practice);
            $dat['time'] = 0;

            if($count ){
                $dat['accuracy'] = round(($sum*100)/$count,2);

                $dat['time'] = round(($time)/$count,2);
            }
            else{
              $dat['accuracy'] = 0; 
              $data['time']=0;
            }
            
            foreach($practice as $pr){
                $prid = $pr->category_id;
                if($pr->category_id && isset($course->categories->$prid))
                    if($pr->accuracy==1)
                    $course->categories->$prid->correct++; 
                    else
                    $course->categories->$prid->incorrect++;
            }
            
            /* correct percent */
            foreach($course->categories as $c=>$cat){
            if(isset($cat->total))
            if($cat->total!=0)
                {
                    $course->categories->$c->correct_percent = $course->categories->$c->correct/$course->categories->$c->total*100;
                    
                    $course->categories->$c->incorrect_percent = $course->categories->$c->incorrect/$course->categories->$c->total*100;
                }
            }

            $course->user = $dat; 

            //exams attempt
            $attempt = DB::table('tests_overall')
                    ->whereIn('test_id', $exam_ids)
                    ->where('user_id',\auth()->user()->id)
                    ->get()->groupBy('test_id');

            $course->attempt = $attempt;

        }

        $course->entry = $entry;
        $course->keywords = $course->name;
        $course->description = strip_tags($course->description);

        $bno=null;

        if(session()->get('bno'))
            $bno = session()->get('bno');
        else if(!request()->get('batch') && $user)    
            $bno = trim($user->info);
        else{
            $bno = request()->get('batch');
            session()->put('bno',$bno);
        }



        $user_practice = [];
        $users = [];

        $practice_set=[];
        $pavg = 0;
        $wpavg =0;
        if($bno){
            $total = 0;
            $users = Cache::remember('users_'.$bno, 120, function() use ($bno) { 
                return User::where('info',$bno)->where('client_slug',subdomain())->get();
            });

            if(!count($users ))
                $countuser = 1;
            else
                $countuser = count($users);

            $uids = $users->pluck('id')->toArray();
            $user_practice = Practice::whereIn('user_id',$uids)->where('course_id',$course->id)->get()->groupBy('user_id');
            foreach($user_practice as $uid=>$p){
                $practice_set[$uid] = $p->sum('accuracy');
                $total = $total + $p->sum('accuracy');
            }

             arsort($practice_set);
            $pavg = $total / $countuser;

            $date = \Carbon\Carbon::today()->subDays(7);

            $user_practice2 = Practice::whereIn('user_id',$uids)->where('course_id',$course->id)->where('created_at','>=',$date)->get()->groupBy('user_id');

            $total2 =0;
            foreach($user_practice2 as $uid=>$p){
                $total2 = $total2 + $p->sum('accuracy');
            }
            $wpavg = $total2 / $countuser;

        }

      
        //dd($user_practice);
        //dd($course->exams);
        if($course)
            return view('appl.course.course.show4')
                    ->with('course',$course)
                    ->with('categories',$course->categories)
                    ->with('product',$course->product)
                    ->with('ques_count',$course->ques_count)
                    ->with('exams',$course->exams)
                    ->with('entry',$course->entry)
                    ->with('user_practice',$user_practice)
                    ->with('practice_set',$practice_set)
                    ->with('users',$users)
                    ->with('bno',$bno)
                    ->with('pavg',$pavg)
                    ->with('wpavg',$wpavg)
                    ->with('nodes',$course->nodes);

        else
            abort(404);
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show4($id)
    {
        $course = Course::where('slug',$id)->first();
        
        if(!$course)
            abort('404','Course Not Found');
        



        $p = Product::where('slug',$course->slug)->first();
        if(!$p)
        foreach($course->products as $product)
        {
            if($product != 'premium-access')
                $p = $product;
        }


        $user = \Auth::user();
        $entry=null;
        if($user){
            $entry = DB::table('product_user')
                    ->whereIn('product_id', $course->products()->pluck('id')->toArray())
                    ->where('user_id', $user->id)
                    ->orderBy('valid_till','desc')
                    ->first();
        }


       // dd($user->courses()->find($course->id));
        $categories = Category::where('slug',$id)->first();


        $project = Project::where('slug',$id)->first();
        $parent =  Category::where('slug',$id)->first(); 

        //$x = $parent->questionCount_level2($project);

        $ques_count  = 0; 
        $nodes = null;
        $exams = array();

        $examtype = Examtype::where('slug',$id)->first();
        if($examtype)
            $exams = Exam::where('examtype_id',$examtype->id)->get();
        else{
            $exams = Exam::where('slug','LIKE',"%{$course->slug}%")->get(); 
        }

        $topics = Category::defaultOrder()->descendantsOf($parent->id);
        $exam_ids =[];
        foreach($topics as $t){
            if($t->exam_id)
                array_push($exam_ids, $t->exam_id);
            
        }
        foreach($exams as $k=> $e){
            if(in_array($e->id, $exam_ids))
                unset($exams[$k]);
        }

        //categories
        $categories_list = Category::defaultOrder()->descendantsOf($parent->id)->pluck('id')->toArray();
        $categories_ =array();
        foreach($categories_list as $cat){
            $categories_[$cat]['correct'] =0;
            $categories_[$cat]['incorrect']  =0;
            $categories_[$cat]['total'] = 0; 
            $categories_[$cat]['correct_percent'] =0;        
            $categories_[$cat]['incorrect_percent'] = 0;
        }

        $qset = DB::table('category_question')->whereIn('category_id', $categories_list)->select('category_id', DB::raw('count(*) as count'))->where('intest','!=',1)->groupBy('category_id')->get();
        
        foreach($qset as $q){
            $categories_[$q->category_id]['total'] = $q->count;
        }


        
        
        //put the data with practice
        if(\auth::user()){
            $practice = Practice::where('user_id',\auth::user()->id)->where('course_id',$course->id)->get();

            $i=0;


            //dd($practice);
            foreach($practice as $pr){
                
                if($pr->category_id)
                if($pr->accuracy==1)
                $categories_[$pr->category_id]['correct']++; 
                else
                $categories_[$pr->category_id]['incorrect']++; 
            }

        }


        //convert to percentage
        foreach($categories_list as $cat){
            if($categories_[$cat]['total']!=0)
                {
                  
                    $categories_[$cat]['correct_percent'] = $categories_[$cat]['correct']/$categories_[$cat]['total']*100;
                    
                    $categories_[$cat]['incorrect_percent'] = $categories_[$cat]['incorrect']/$categories_[$cat]['total']*100;
                }
        }
        

        //check for tests


        $course->keywords = $course->name;
        $course->description = strip_tags($course->description);
        if($parent){
            $node = Category::defaultOrder()->descendantsOf($parent->id)->toTree();

            foreach($node as $k=>$n){
                $course->keywords = $course->keywords.', '.$n->name;
                $node[$k]['children'] = Category::defaultOrder()->descendantsOf($n->id)->toTree();
                foreach($node[$k]['children'] as $m => $c){
                    if($c->exam_id){
                        $exam = Exam::where('id',$c->exam_id)->first();
                        if(!$exam->attempted())
                        $node[$k]['children'][$m]['try'] = 1;
                        else
                        $node[$k]['children'][$m]['try'] = 0;
                    }
                }
            }
            
            /*
            $url = url()->full();
            $parsed = parse_url($url);
            $exploded = explode('.', $parsed["host"]);
            $domain = $exploded[0];

            $file_count = '../static/'.$domain.'_'.$course->slug.'_count.txt';
            $file_nodes = '../static/'.$domain.'_'.$course->slug.'_nodes.txt';

            

            if(request()->get('refresh'))
            {

                $ques_count = $parent->questionCount_level2($project);
                file_put_contents($file_count,$ques_count);
                $nodes = Category::displayUnorderedListCourse($node,['project'=>$project,'parent'=>$parent]);

                file_put_contents($file_nodes,$nodes);
            }

            if(!file_exists($file_count)){
                $ques_count = $parent->questionCount_level2($project);
                file_put_contents($file_count,$ques_count);
            }
            else{
                $ques_count = file_get_contents($file_count);
            }
            */
            
            //$exams =  Tag::where('project_id',$project->id)->where('name','exam')
              //          ->orderBy('created_at','desc')->get();
                 
            $ques_count = $parent->questionCount_level2($project);         
            
        } 

        //dd($nodes);

        if($course)
            return view('appl.course.course.show3')
                    ->with('course',$course)
                    ->with('categories',$categories_)
                    ->with('product',$p)
                    ->with('ques_count',$ques_count)
                    ->with('exams',$exams)
                    ->with('project',$project)
                    ->with('entry',$entry)
                    ->with('nodes',$node);
        else
            abort(404);
    }

     /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function video($course,$category)
    {
        

        $course = Course::where('slug',$course)->first();

        $user = \Auth::user();
        $entry=null;
        if($user){
                $entry = DB::table('product_user')
                    ->whereIn('product_id', $course->products()->pluck('id')->toArray())
                    ->where('user_id', $user->id)
                    ->orderBy('valid_till','desc')
                    ->first();
        }



        $category = Category::where('slug',$category)->first();
        //dd($category);

        $videos = explode(',', $category->video_link);

        
        $access = true;

        if(!youtube_video_exists($videos[0])){


            if($entry)
            {
                if(strtotime($entry->valid_till) < strtotime(date('Y-m-d')))
                $access = false;
                else if($entry->status===0)
                    $access =false;
            }else
                $access = false;
        }
        

        if($category->exam_id){
            $exam = Exam::where('slug',$category->exam_id)->first();
            

            if($category->video_link){
            $category->video_desc = $category->video_desc.'<br>';
                if(isset($exam->name))
                 $category->video_desc = $category->video_desc.'<hr><h3>'.$exam->name.'</h3>'.$exam->instructions;  

            }else    
            $category->video_desc = $exam->instructions;

            if($exam)
            if(!$exam->attempted())
                $category->test_analysis = false;
            else{
                $category->test_analysis = true;
            }
        }


            
        //$this->authorize('view', $course);

        
        $parent = Category::getParent($category);
        
        foreach($parent->descendants as $k => $item){
            if($item->slug ==$category->slug)
            {
                if($k==0)
                {
                    $prev = null;
                    if(isset($parent->descendants[$k+1]))
                    $next = $parent->descendants[$k+1];
                    else
                        $next =null;
                }elseif($k == (count($parent->descendants)-1)){
                    $prev = $parent->descendants[$k-1];
                    $next = null;
                }
                else{
                    $prev = $parent->descendants[$k-1];
                    $next = $parent->descendants[$k+1];
                }


            }
        }

        if($course)
            return view('appl.course.course.video')
                ->with('course',$course)
                ->with('category',$category)
                ->with('videos',$videos)
                ->with('parent',$parent)
                ->with('next',$next)
                ->with('prev',$prev)
                ->with('access',$access);
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
        $course = Course::where('slug',$id)->first();
        

        $this->authorize('update', $course);


        if($course)
            return view('appl.course.course.createedit')
                ->with('stub','Update')
                ->with('editor','true')
                ->with('course',$course);
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
            $request->slug = str_replace(' ', '-', $request->slug);
            $course = Course::where('id',$id)->first();

            $this->authorize('update', $course);

            /*
            $category = Category::where('slug',$course->slug)->first();
            $category->name = $request->name;
            $category->slug = $request->slug;
            $category->save(); */

            $course->name = $request->name;
            $course->slug = $request->slug;
            $course->intro_youtube = $request->intro_youtube;
            $course->intro_vimeo = $request->intro_vimeo;
            $course->description = $request->description;
            $course->weightage_min = $request->weightage_min;
            $course->weightage_avg = $request->weightage_avg;
            $course->weightage_max = $request->weightage_max;
            $course->price = $request->price;
            $course->important_topics = $request->important_topics;
            $course->reference_books = $request->reference_books;
            $course->status = $request->status;
            $course->image = $request->image;
            $course->save(); 

            flash('Course (<b>'.$request->name.'</b>) Successfully updated!')->success();
            return redirect()->route('course.show',$request->slug);
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
        $course = Course::where('id',$id)->first();
        $this->authorize('update', $course);
        /*
        $node = Category::where('slug',$course->slug)->first();
        $node->delete();*/
        $course->delete();
        flash('Course Successfully deleted!')->success();
        return redirect()->route('course.index');
       
    }
}
