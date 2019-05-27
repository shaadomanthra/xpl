<?php

namespace PacketPrep\Http\Controllers\College;

use Illuminate\Http\Request;
use PacketPrep\Http\Controllers\Controller;
use PacketPrep\Models\College\Ambassador as Obj;
use PacketPrep\Models\College\College;
use PacketPrep\Models\Course\Course;
use PacketPrep\Models\Course\Practices_Course;
use PacketPrep\Models\Exam\Tests_Overall;
use Illuminate\Support\Facades\DB;
use PacketPrep\User;

class AmbassadorController extends Controller
{
    
    public function __construct(){
        $this->app      =   'college';
        $this->module   =   'ambassador';
    }


    public function connect2(Obj $obj, Request $request){

        if(!\auth::user())
            abort(403,'Login Requuired');

        $this->authorize('view', $obj);
        $view = 'connect2';


        $user = \auth::user();



        $course_id = 20;
        if($course_id)
            $course = Course::where('id',$course_id)->first();
        $users = $user->referrals->pluck('id')->toArray();
        array_push($users, $user->id);



        $data = [];
        
        $practice = Practices_Course::where('course_id',$course_id)
                        ->whereIn('user_id',$users)->get();

        //sdd($users);
        $test_id = [];
        if(isset($course->exams))
        foreach($course->exams as $e){
            array_push($test_id,$e->id);
        }
                            
        $tests = Tests_Overall::whereIn('user_id',$users)
                    ->whereIn('test_id',$test_id)
                    ->get();
     
        $data['practice_score'] = $practice->sum('attempted');
        $data['tests_score'] = $tests->sum('correct');
        $data['total_score'] = $data['practice_score'] + $data['tests_score'];

        $practice_top = Practices_Course::where('course_id',$course_id)
                        ->whereIn('user_id',$users)->orderBy('attempted','desc')->limit(5)->get();
    
        $user_array = implode(', ', $users);
        $test_array = implode(', ', $test_id);
        
        if($test_id)
        $tests_top = DB::select("select user_id, SUM(correct) as sum from tests_overall where user_id IN ($user_array) and test_id IN ($test_array) GROUP BY user_id ORDER By sum DESC LIMIT 5");
        else
        $tests_top = null;
        $users_test_top = [];

        if($tests_top)
        foreach($tests_top as $k=>$t){
            $tests_top[$k]->user = User::where('id',$t->user_id)->first();
        }

        $data['tests_top'] = $tests_top;
        $data['practice_top'] = $practice_top;
        $data['course'] = $course;
        //dd($data);

         $amb_ids = DB::table('role_user')
                    ->where('role_id',37)
                    ->pluck('user_id');
        $amb_scores = [];
        $amb_user = [];
        foreach($amb_ids as $amb){
            $ambassador = User::where('id',$amb)->first();
            $users = $ambassador->referrals->pluck('id')->toArray();
            array_push($users, $user->id);

            $attempted = Practices_Course::where('course_id',$course_id)
                        ->whereIn('user_id',$users)->sum('attempted');
            $correct = Tests_Overall::whereIn('user_id',$users)
                    ->whereIn('test_id',$test_id)
                    ->sum('correct');
            $score = $attempted + $correct; 
            $amb_scores[$amb] = $score;
            $amb_user[$amb] = $ambassador;


        }

        return view('appl.'.$this->app.'.'.$this->module.'.'.$view)
                ->with('obj',$obj)
                ->with('app',$this)
                ->with('amb_user',$amb_user)
                ->with('amb_scores',$amb_scores)
                ->with('data',$data);

    }

   

    

    public function connect(Obj $obj,Request $request)
    {

        $this->authorize('view', $obj);
        $view = 'connect';

        $college = \auth::user()->colleges()->first();

        $data = array();
        $data['college_score'] = $college->users()->count();
        $data['my_score'] = \auth::user()->referrals()->count();
        $data['college'] = $college;
        $data['username'] = \auth::user()->username;
        

        $users = \auth::user()->whereHas('roles', function ($query)  {
                                $query->where('name', '=', 'Campus Ambassador')->orWhere('name','=','Campus Coordinator');

                            })->get();

        $colleges = College::all();
        $score = array(); $score_2 = array();

        foreach($colleges as $c){
        	$score_2[$c->name] = $c->users()->count();
        }
        
        $coll = array(); $branch = array();
        foreach($users as $u){
        	$score[$u->name] = $u->referrals()->count();

            if($u->colleges()->first())
            $coll[$u->name] = $u->colleges()->first()->name;
            else
            $coll[$u->name] = '';  

            if($u->branches()->first())
            $branch[$u->name] = $u->branches()->first()->name;
            else
            $branch[$u->name] = ''; 
        }
        $data['users'] = array_reverse(array_sort($score));

        $data['colleges'] =  array_reverse(array_sort($score_2));

        $data['coll'] = $coll;
        $data['branch'] = $branch;
        //dd($data);

        return view('appl.'.$this->app.'.'.$this->module.'.'.$view)
                ->with('obj',$obj)
                ->with('app',$this)
                ->with('data',$data)->with('k',1)->with('j',1);
    }

    public function interngeneralist(Request $request){
         return view('appl.college.ambassador.intern-generalist');
    }

    public function internconnect(Obj $obj,Request $request)
    {

        $this->authorize('view', $obj);
        $view = 'interns-connect';

        $college = \auth::user()->colleges()->first();

        $data = array();
        $score = array();
        $data['my_score'] = \auth::user()->referrals()->count();
        $data['username'] = \auth::user()->username;
        
    
        $users = \auth::user()->referrals()->whereHas('roles', function ($query)  {
                                $query->where('name', '=', 'Campus Ambassador');
                            })->get();

        
        $coll = array();
        $branch =array();
        foreach($users as $u){
            $data['my_score'] = $data['my_score'] + $u->referrals()->count();
            $score[$u->name] = $u->referrals()->count();

            if($u->colleges()->first())
            $coll[$u->name] = $u->colleges()->first()->name;
            else
            $coll[$u->name] = '';  
            if($u->branches()->first())
            $branch[$u->name] = $u->branches()->first()->name;
            else
            $branch[$u->name] = ''; 
        }

        $data['users'] = array_reverse(array_sort($score));

        $data['coll'] = $coll;
        $data['branch'] = $branch;
        //dd($data);

        $intern_generalist = \auth::user()->whereHas('roles', function ($query)  {
                                $query->where('name', '=', 'Intern Generalist');
                            })->get();


        $colls = array(); 
        $branches =array();
        $scores = array();

        foreach($intern_generalist  as $u){
            $scores[$u->name] = $u->referrals()->count();

             $amb = $u->referrals()->whereHas('roles', function ($query)  {
                                $query->where('name', '=', 'Campus Ambassador');
                            })->get();
             foreach($amb as $a){
                $scores[$u->name] = $scores[$u->name] + $a->referrals()->count();
             }



            if($u->colleges()->first())
            $colls[$u->name] = $u->colleges()->first()->name;
            else
            $colls[$u->name] = '';  

            if($u->branches()->first())
            $branches[$u->name] = $u->branches()->first()->name;
            else
            $branches[$u->name] = ''; 
        }

        $data['intern_generalist'] = array_reverse(array_sort($scores));

        $data['colls'] = $colls;
        $data['branches'] = $branches;

        return view('appl.'.$this->app.'.'.$this->module.'.'.$view)
                ->with('obj',$obj)
                ->with('app',$this)
                ->with('data',$data)->with('k',1)->with('j',1);
    }

    public function list(Obj $obj,Request $request)
    {

        $this->authorize('view', $obj);
        $view = 'connect';

        $college = \auth::user()->colleges()->first();

        $data = array();
        $data['college_score'] = $college->users()->count();
        $data['my_score'] = \auth::user()->referrals()->count();
        $data['college'] = $college;
        $data['username'] = \auth::user()->username;
        

        $users = \auth::user()->whereHas('roles', function ($query)  {
                                $query->where('name', '=', 'Campus Ambassador')->orWhere('name','=','Campus Coordinator');
                            })->get();

        $colleges = College::all();
        $score = array(); $score_2 = array();

        foreach($colleges as $c){
            $score_2[$c->name] = $c->users()->count();
        }
        
        $coll = array();
        $branch = array();
        $username = array();
        foreach($users as $u){
            $score[$u->name] = $u->referrals()->count();

            $username[$u->name] = $u->username;
            if($u->colleges()->first())
            $coll[$u->name] = $u->colleges()->first()->name;
            else
            $coll[$u->name] = ''; 

            if($u->branches()->first())
            $branch[$u->name] = $u->branches()->first()->name;
            else
            $branch[$u->name] = '';   

        }
        $data['users'] = array_reverse(array_sort($score));

        $data['colleges'] =  $coll;
        $data['username'] =  $username;
        $data['branch'] = $branch;

        //dd($data);

        return view('appl.'.$this->app.'.'.$this->module.'.ambassador')
                ->with('obj',$obj)
                ->with('app',$this)
                ->with('data',$data)->with('k',1)->with('j',1);
    }


    public function list2(Obj $obj,Request $request)
    {

        $this->authorize('view', $obj);
        $view = 'connect';

        $college = \auth::user()->colleges()->first();

        $data = array();
        $data['college_score'] = $college->users()->count();
        $data['my_score'] = \auth::user()->referrals()->count();
        $data['college'] = $college;
        $data['username'] = \auth::user()->username;
        

        $users = \auth::user()->whereHas('roles', function ($query)  {
                                $query->where('name', '=', 'Campus Ambassador')->orWhere('name','=','Campus Coordinator');
                            })->get();

        $colleges = College::all();
        $score = array(); $score_2 = array();

        foreach($colleges as $c){
            $score_2[$c->name] = $c->users()->count();
        }
        
        $coll = array();
        $branch = array();
        $username = array();
        foreach($users as $u){
            $score[$u->name] = $u->referrals()->count();

            

            $username[$u->name] = $u->username;
            if($u->colleges()->first())
            $coll[$u->name] = $u->colleges()->first()->name;
            else
            $coll[$u->name] = '';  

            $name = $coll[$u->name];

           

            if($u->branches()->first())
            $branch[$u->name] = $u->branches()->first()->name;
            else
            $branch[$u->name] = '';  

        }
        $data['users'] = array_reverse(array_sort($score));

        $data['colleges'] =  $coll;
        $data['username'] =  $username;
        $data['branch'] = $branch;


        //dd($data);

        return view('appl.'.$this->app.'.'.$this->module.'.ambassador-admin')
                ->with('obj',$obj)
                ->with('app',$this)
                ->with('data',$data)->with('k',1)->with('j',1);
    }

    public function college2($college, Obj $obj,Request $request)
    {
        $college = College::where('id',$college)->first();
        $branches = array();

        foreach($college->branches as $k=> $b){
              $branches[$b->name] = \auth::user()->whereHas('colleges', function ($query) use ($college)            {
                                $query->where('name', '=', $college->name);
                            })->whereHas('branches',function ($query) use ($b)              {
                                $query->where('name', '=', $b->name);
                            })->count();
        }

        $this->authorize('view', $obj);
        $view = 'college2';

        return view('appl.'.$this->app.'.'.$this->module.'.'.$view)
                ->with('obj',$obj)
                ->with('app',$this)
                ->with('branches',$branches)
                ->with('college',$college);
    }


    public function students2($college, Obj $obj,Request $request)
    {   
        $college = College::where('id',$college)->first();
        $branch = $request->get('branch');

        if($branch){
            $users = $college->users()
                        ->whereHas('branches',
                            function ($query) use ($branch) {
                                $query->where('name', '=', $branch);
                            })->get();

        }else{
            $users = $college->users()->get();
        }

        $list = array();
        $list2 = array();
        foreach($users as $k => $u){
            $list[$u->name] = $u->details->roll_number;
            if($u->user_id)
            $list2[$u->name] = \auth::user()->where('id',$u->user_id)->first()->name;
            else
            $list2[$u->name]  = null;
        }
        $user_list  = array_sort($list);


        $this->authorize('view', $obj);
        $view = 'students2';

        return view('appl.'.$this->app.'.'.$this->module.'.'.$view)
                ->with('obj',$college)
                ->with('app',$this)
                ->with('user_list',$user_list)->with('list',$list2)->with('i',1);
    }


    public function college(Obj $obj,Request $request)
    {
    	$college = \auth::user()->colleges()->first();

        
    	$branches = array();

    	foreach($college->branches as $k=> $b){

    		  $branches[$b->name] = $college->users()
                        ->whereHas('branches',
                            function ($query) use ($b) {
                                $query->where('name', '=', $b->name);
                            })->count();
    	}

        $this->authorize('view', $obj);
        $view = 'college';

        return view('appl.'.$this->app.'.'.$this->module.'.'.$view)
                ->with('obj',$obj)
                ->with('app',$this)
                ->with('branches',$branches)
                ->with('college',$college);
    }


    public function students(Obj $obj,Request $request)
    {
    	$college = \auth::user()->colleges()->first();
    	$branch = $request->get('branch');

    	if($branch){
    		$users = $college->users()
    					->whereHas('branches',
    						function ($query) use ($branch) {
                                $query->where('name', '=', $branch);
                            })->get();

    	}else{
    		$users = $college->users()->get();
    	}

    	$list = array();
        $list2 = array();
    	foreach($users as $k => $u){
            $list[$u->name] = $u->details->roll_number;
            if($u->user_id)
            $list2[$u->name] = \auth::user()->where('id',$u->user_id)->first()->name;
            else
            $list2[$u->name]  = null;
        }
    	$user_list  = array_sort($list);


        $this->authorize('view', $obj);
        $view = 'students';

        return view('appl.'.$this->app.'.'.$this->module.'.'.$view)
                ->with('obj',$college)
                ->with('app',$this)
                ->with('user_list',$user_list)->with('list',$list2)->with('i',1);
    }

    public function onboard(){

        return view('appl.'.$this->app.'.'.$this->module.'.ambassador-onboard');
    }


}
