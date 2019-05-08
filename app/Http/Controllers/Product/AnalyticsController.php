<?php

namespace PacketPrep\Http\Controllers\Product;

use Illuminate\Http\Request;
use PacketPrep\Http\Controllers\Controller;
use PacketPrep\Models\Product\Client;
use PacketPrep\Models\Dataentry\Question;
use PacketPrep\Models\Dataentry\Category;
use PacketPrep\Models\Dataentry\Project;
use PacketPrep\Models\Course\Course;
use PacketPrep\Models\Course\Practices_Course;
use PacketPrep\Models\Course\Practices_Topic;
use PacketPrep\Models\Product\Product;
use PacketPrep\Models\User\Role;
use PacketPrep\User;
use Intervention\Image\ImageManagerStatic as Image;

use PacketPrep\Models\User\User_Details;
use PacketPrep\Models\College\College;
use PacketPrep\Models\College\Zone;
use PacketPrep\Models\College\Ambassador;
use PacketPrep\Models\Course\Practice;
use PacketPrep\Models\College\Service;
use PacketPrep\Models\College\Metric;
use PacketPrep\Models\College\Branch;
use PacketPrep\Models\Exam\Exam;
use PacketPrep\Models\Exam\Tests_Overall;
use PacketPrep\Models\Exam\Tests_Section;
use PacketPrep\Models\Exam\Section;
use PacketPrep\Models\Product\Test;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use PacketPrep\Mail\ActivateUser;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;

ini_set('max_execution_time', 300); 

class AnalyticsController extends Controller
{
    

    public function filldata(Request $r){

    	if(!\auth::user()->checkRole(['administrator','investor','patron','promoter','employee','client-owner','client-manager','manager']))
        {
             abort(403,'Unauthorised Access');   
        }

        $first = $r->get('first');
        $last = $r->get('last');

        if(!$first && !$last)
            dd("Enter First Last ");

        dd('No Entry');

    	$practice = Practice::where('id','>=',$first)->where('id','<=',$last)->get();
    	
    	
    	foreach($practice as $k=>$p){
    		$practice_course = Practices_Course::where('course_id',$p->course_id)->where('user_id',$p->user_id)->first();
    		$practice_topic = Practices_Topic::where('category_id',$p->category_id)->where('user_id',$p->user_id)->first();

    		if(!$practice_topic ){
    			$practice_topic = new Practices_Topic;
    		}


    		if(!$practice_course ){
    			$practice_course = new Practices_Course;
    		}

    		$practice_course->user_id = $p->user_id;
    		$practice_topic->user_id = $p->user_id;

    		$practice_course->course_id = $p->course_id;
    		$practice_topic->category_id = $p->category_id;

    		$practice_course->attempted++;
    		$practice_topic->attempted++;
    		if($p->accuracy){
    			$practice_course->correct++;
    			$practice_topic->correct++;
    		}else
    		{
    			$practice_course->incorrect++;
				$practice_topic->incorrect++;
    		}



    		$practice_course->time += $p->time;
    		$practice_topic->time += $p->time;
    		
    		
    		$practice_topic->save();
    		$practice_course->save();

    	}
        dd('practice_extra_tables_updated');

    }

    public function practice_filldata(){
    	if(!\auth::user()->checkRole(['administrator','investor','patron','promoter','employee','client-owner','client-manager','manager']))
        {
             abort(403,'Unauthorised Access');   
        }

        dd('No Entry');
    	$practice = Practice::whereNull('category_id')->get();
    	
    	 foreach($practice as $p){
            $p->category_id  = $p->question->categories->last()->id;
            $p->save();
                    
        }
        dd('practice_table_updated');
        
    }


     public function test_filldata(Request $r){
    	if(!\auth::user()->checkRole(['administrator','investor','patron','promoter','employee','client-owner','client-manager','manager']))
        {
             abort(403,'Unauthorised Access');   
        }

        $first = $r->get('first');
        $last = $r->get('last');

        if(!$first && !$last)
            dd("Enter First Last ");

        //dd('No Entry');
        
        $tests = test::where('id','>=',$first)->where('id','<=',$last)->get();

    	$i=0;
    	foreach($tests as $k=>$t){
    		$tests_overall = Tests_Overall::where('test_id',$t->test_id)->where('user_id',$t->user_id)->first();

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
        dd('tests filldata updated '.$i);
    }


    public function analytics_practice(Request $r){

        if(!\auth::user()->checkRole(['administrator','investor','patron','promoter','employee','client-owner','client-manager','manager']))
        {
             abort(403,'Unauthorised Access');   
        }

        $data = array();
        $item_name = 'category_id';
        if($r->get('course')){ 
            $data['item'] = Course::where('id',$r->get('course'))
                            ->first();
            $project = Project::where('slug',$data['item']->slug)
                        ->first();
            $category = Category::where('slug',$project->slug)->first();
            $nodes = Category::descendantsOf($category->id);
        }elseif($r->get('category'))
        {
            $data['item'] = Category::where('id',$r->get('category'))->first();
            
            $nodes = Category::descendantsAndSelf($data['item']->id);
        }else{
            $data['item'] = null;
            $nodes = Category::defaultOrder()->get();
            
        }
        $item_id = $nodes->pluck('id')->toArray(); 
        $data['total'] = DB::table('category_question')->whereIn('category_id', $item_id)->count();
        

        $student_id = $r->get('student');

        if($student_id){
            $user = User::where('id',$student_id)->first();
            $data['college'] = $user->colleges->first();
            $data['branch'] = $user->branches->first();
            $data['user'] = $user;

            if($r->get('course'))
            $practice = Practices_Course::where('course_id',$r->get('course'))
                        ->where('user_id',$user->id)->get();
            else	
            $practice = Practices_Topic::whereIn('category_id',$item_id)
                        ->where('user_id',$user->id)->get();
            
            $data = $this->getData($data,$practice);

        }else{

            $college_id = $r->get('college');
            $branch_id = $r->get('branch');
            $college = College::where('id',$college_id)->first();
            $branch = Branch::where('id',$branch_id)->first();
            //dd($data);
            if($college && $branch){
                
                $users_college = $college->users()->pluck('id')->toArray();
                $users_branches = $branch->users()->pluck('id')->toArray();
                $users = array_intersect($users_branches,$users_college);
            }elseif($college && $branch==null)
                $users = $college->users()->pluck('id');
            elseif($college==null && $branch)
                $users = $branch->users()->pluck('id');
            else
                $users = User::all()->pluck('id');


            
            $data['college'] = $college;
            $data['branch'] = $branch;

            if($r->get('course'))
            $practice = Practices_Course::where('course_id',$r->get('course'))
                        ->whereIn('user_id',$users)->get();
            else	
            $practice = Practices_Topic::whereIn('category_id',$item_id)
                        ->whereIn('user_id',$users)->get();

            //dd($item_id);

            $data = $this->getData($data,$practice);


        }

        return view('appl.product.admin.analytics.index')
                    ->with('data',$data);


    }

    public function getData($data, $practice){

        $data['solved'] = $practice->sum('attempted');
        if($data['solved'])
        $data['time'] = round($practice->sum('time')/$data['solved'],2);
    	else
    		$data['time']  =0;
        $data['correct'] = round($practice->sum('correct'),2);

        $data['active'] = $practice->unique('user_id');

        if($data['solved'])     
            $data['accuracy'] = round(($data['correct']*100)/$data['solved'],2);
        else
            $data['accuracy'] =null;  

        return $data;
    }


    public function analytics_test(Request $r){

        $college = College::where('id',$r->get('college'))->first();
        $data['college'] = $college;
        $branch = Branch::where('id',$r->get('branch'))->first();
        $data['branch'] = $branch;

    	$test = $r->get('test');
    	$data['test'] = Exam::where('id',$test)->first();

    	$student = $r->get('student');
    	

    	if($r->get('student')){
    		$data['user'] =  User::where('id',$student)->first();
    		$users = array($student);
    	
    	}
    	elseif($college && $branch){
                $users_college = $college->users()->pluck('id')->toArray();
                $users_branches = $branch->users()->pluck('id')->toArray();
                $users = array_intersect($users_branches,$users_college);
        }elseif($college && $branch==null)
                $users = $college->users()->pluck('id');
        elseif($college==null && $branch)
                $users = $branch->users()->pluck('id');
        else
    		$users = User::all()->pluck('id');

    	$data['active'] = $users;



    	$data['tests'] = Tests_Overall::whereIn('user_id',$users)->where('test_id',$test)->get();
    	
    	return view('appl.product.admin.analytics.test')
                    ->with('data',$data);


    }
}
