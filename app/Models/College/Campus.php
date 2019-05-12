<?php

namespace PacketPrep\Models\College;

use Illuminate\Database\Eloquent\Model;

use PacketPrep\Models\College\Branch;
use PacketPrep\Models\College\College;
use PacketPrep\Models\College\Campus;
use PacketPrep\Models\College\Batch;
use PacketPrep\User;
use Illuminate\Support\Facades\DB;
use PacketPrep\Models\Dataentry\Question;
use PacketPrep\Models\Dataentry\Category;
use PacketPrep\Models\Dataentry\Project;
use PacketPrep\Models\Course\Course;
use PacketPrep\Models\Course\Practices_Course;
use PacketPrep\Models\Course\Practices_Topic;

use PacketPrep\Models\Exam\Exam;
use PacketPrep\Models\Exam\Tests_Overall;
use PacketPrep\Models\Exam\Tests_Section;

class Campus extends Model
{
    

    public static function getAnalytics($college,$branch,$batch,$r,$course_id=null,$category_id=null){

        $data = array();
        $item_name = 'category_id';
        if($course_id){ 
            $data['item'] = Course::where('id',$course_id)->first();
            $data['item_name'] = 'category_id';
            $project = Project::where('slug',$data['item']->slug)->first();
            $category = Category::where('slug',$project->slug)->first();
            $item_id = $category->descendants->pluck('id')->toArray(); 

            $data['total_item'][$course_id] = 0;
            foreach($category->children as $node){
	            $descendants = $node->descendants->pluck('id')->toArray();
        		$data['total_item'][$node->id] = DB::table('category_question')->whereIn('category_id', $descendants)->count();
        		$data[$node->id]= array("total"=>0,"solved"=>0,"time"=>0,"correct"=>0,"participants"=>0,"vg_solved"=>0,"completion"=>0,"accuracy"=>0);
        		$data['total_item'][$course_id] = $data['total_item'][$course_id] +$data['total_item'][$node->id];
            }

        	$data[$course_id]= array("total"=>0,"solved"=>0,"time"=>0,"correct"=>0,"participants"=>0,"vg_solved"=>0,"completion"=>0,"accuracy"=>0);
        }elseif($category_id)
        {
            $data['item'] = Category::where('id',$category_id)->first();
            $category = $data['item'];
            $nodes = Category::descendantsAndSelf($data['item']->id);
            $item_id = $nodes->pluck('id')->toArray(); 
            $data['item_name'] = 'category_id';


            $data['total_item'][$category_id] = 0;
            foreach($category->children as $node){
	            $descendants = $node->descendantsAndSelf($node)->pluck('id')->toArray();

        		$data['total_item'][$node->id] = DB::table('category_question')->whereIn('category_id', $descendants)->count();
        		
        		$data[$node->id]= array("total"=>$data['total_item'][$node->id],"solved"=>0,"time"=>0,"correct"=>0,"participants"=>0,"vg_solved"=>0,"completion"=>0,"accuracy"=>0);
        		$data['total_item'][$category_id] = $data['total_item'][$category_id] +$data['total_item'][$node->id];
            }
            

        	$data[$category_id]= array("total"=>$data['total_item'][$category->id],"solved"=>0,"time"=>0,"correct"=>0,"participants"=>0,"vg_solved"=>0,"completion"=>0,"accuracy"=>0);


        }else{
            $data['item'] = null;
            $data['item_name'] = 'course_id';
            $courses = $college->courses;
            $item_id = array();
            foreach($courses as $c){
            	$project = Project::where('slug',$c->slug)->first();
	            $category = Category::where('slug',$project->slug)->first();
	            $nodes = Category::descendantsOf($category->id);
	            $ids = $nodes->pluck('id')->toArray(); 
	            foreach($ids as $id)
                array_push($item_id,$id);
        		
        		$data['total_item'][$c->id] = DB::table('category_question')->whereIn('category_id', $ids)->count();
        		$data[$c->id]= array("total"=>0,"solved"=>0,"time"=>0,"correct"=>0,"participants"=>0,"vg_solved"=>0,"completion"=>0,"accuracy"=>0);
            }
        }


        
        $data['total'] = DB::table('category_question')->whereIn('category_id', $item_id)->count();
        
        //dd($data['total']);

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
            
            $data = self::getData($data,$practice);

        }else{

            //dd($data);
            if($college && $branch){
                
                $users_college = $college->users()->pluck('id')->toArray();
                $users_branches = $branch->users()->pluck('id')->toArray();
                $users = array_intersect($users_branches,$users_college);
            }else if($college && $batch){
                $users_college = $college->users()->pluck('id')->toArray();
                $users_batches = $batch->users()->pluck('id')->toArray();
                $users = array_intersect($users_batches,$users_college);
            }elseif($college && $branch==null){

                if($r->get('batch'))
                {
                    $batch_ids = Batch::where('college_id',$college->id)->pluck('id');
                    $users_item = DB::table('batch_user')->whereIn('batch_id', $batch_ids)->pluck('user_id')->toArray();
                }else{
                    $branch_ids = $college->branches()->pluck('id')->toArray();
                    $users_item = DB::table('branch_user')->whereIn('branch_id', $branch_ids)->pluck('user_id')->toArray();
                }
                $users_college = $college->users()->pluck('id')->toArray();
                $users = array_intersect($users_item,$users_college);
            }
            elseif($college==null && $branch)
                $users = $branch->users()->pluck('id');
            else
                $users = User::all()->pluck('id');


            
            $data['college'] = $college;
            $data['branch'] = $branch;
            $data['batch'] = $batch;

            if($course_id || $category_id)
            $practice = Practices_Topic::whereIn('category_id',$item_id)
                        ->whereIn('user_id',$users)->get();
            else{
            	$practice = Practices_Course::whereIn('course_id',$college->courses()->pluck('id')->toArray())->whereIn('user_id',$users)->get();
            } 
              
            $data = self::getData($data,$practice);


            // Grouping
            if($course_id){
            	foreach($category->children as $child){
            		$group = $practice->whereIn('category_id',$child->descendants->pluck('id')->toArray());
            		$data_new = array('total'=>$data['total_item'][$child->id]);
            		$data[$child->id] = self::getData($data_new,$group);
            	}
            	
            }elseif($category_id)
            {
            	foreach($category->children as $child){
            		$group = $practice->whereIn('category_id',$child->descendantsAndSelf($child)->pluck('id')->toArray());
            		$data_new = array('total'=>$data['total_item'][$child->id]);
            		$data[$child->id] = self::getData($data_new,$group);
            	}
            }
            elseif( $branch || $batch){
            	$practice_group = $practice->groupBy($data['item_name']);

				foreach($practice_group as $k=>$group){
					$data_new = array('total'=>$data['total_item'][$k]);
				    $data[$k] = self::getData($data_new,$group);
				}
            }

            //dd($data);
        }
        return $data;
    }

   

    public static function getData($data, $practice){

        $data['solved'] = $practice->sum('attempted');
        if($data['solved'])
        $data['time'] = round($practice->sum('time')/$data['solved'],1);
        else
            $data['time']  =0;
        $data['correct'] = round($practice->sum('correct'),3);

        $data['participants'] = count($practice->unique('user_id'));

        if($data['participants'])
        $data['avg_solved'] = round($data['solved']/$data['participants'],3);
        else
        $data['avg_solved']  = 0;

        if($data['total'])
        $data['completion']  = round($data['avg_solved']/$data['total'],3)*100;
        else
        $data['completion'] =0;

        if($data['solved'])     
            $data['accuracy'] = round(($data['correct']*100)/$data['solved'],2);
        else
            $data['accuracy'] = 0;  

        return $data;
    }

    public static function analytics_test($college,$branch,$batch,$r,$course_id=null,$category_id=null){

    	$courses = $college->courses;

    	$test_id = array();
    	$data = array();
    	$data['course']=array();
    	if($category_id){
    		$category = Category::where('id',$category_id)->first();
            foreach($category->children as $node){
	            if($node->exam_id){
	            	array_push($test_id,$node->exam_id);
	            }
            }
            
    	}
    	else if(!$course_id){
    		foreach($courses as $course){
	    		$data['course'][$course->id] = array();
	    		foreach($course->exams as $e){
	    			array_push($data['course'][$course->id],$e->id); 
	    			array_push($test_id,$e->id);
	    		}
	    	}
    	}
    	else{
    		$course = Course::where('id',$course_id)->first();
    		$data['course'][$course->id] = array();
	    	foreach($course->exams as $e){
	    		array_push($data['course'][$course->id],$e->id); 
	    		array_push($test_id,$e->id);
	    	}
    	}

    	


    	if($college && $branch){   
            $users_college = $college->users()->pluck('id')->toArray();
            $users_branches = $branch->users()->pluck('id')->toArray();
            $users = array_intersect($users_branches,$users_college);
        }else if($college && $batch){
            $users_college = $college->users()->pluck('id')->toArray();
            $users_batches = $batch->users()->pluck('id')->toArray();
            $users = array_intersect($users_batches,$users_college);
        }elseif($college && $branch==null){

            if($r->get('batch'))
            {
                $batch_ids = Batch::where('college_id',$college->id)->pluck('id');
                $users_item = DB::table('batch_user')->whereIn('batch_id', $batch_ids)->pluck('user_id')->toArray();
            }else{
                $branch_ids = $college->branches()->pluck('id')->toArray();
                $users_item = DB::table('branch_user')->whereIn('branch_id', $branch_ids)->pluck('user_id')->toArray();
            }

            $users_college = $college->users()->pluck('id')->toArray();
           
            $users = array_intersect($users_item,$users_college);
        }
        elseif($college==null && $branch)
            $users = $branch->users()->pluck('id');
        else
            $users = User::all()->pluck('id');


    	$tests = Tests_Overall::whereIn('user_id',$users)->whereIn('test_id',$test_id)->get()->groupBy('user_id');

    	$data_tests = array("excellent"=>0,"good"=>0,"need_to_improve"=>0,'participants'=>0,
    					"excellent_percent"=>0, "need_to_improve_percent"=>0,"good_percent"=>0,"count"=>count($test_id));
    	$data_tests = self::getData_Test($tests,$data_tests);

    	
    	return $data_tests;

    }


    public static function getData_Test($tests,$data){

    	foreach($tests as $k=>$t)
    	{
    		$data['users'][$k]['score']=$t->sum('score');
    		$data['users'][$k]['max']=$t->sum('max');
    		if($data['users'][$k]['score'])
    		$data['users'][$k]['percent'] = round($data['users'][$k]['score']/$data['users'][$k]['max'],2);
    		else
    		$data['users'][$k]['percent'] =0;

    		if($data['users'][$k]['percent']>0.70){
    			$data['users'][$k]['performance'] = 'excellent';
    			$data['excellent']++;
    		}elseif( $data['users'][$k]['percent']> 0.3 && $data['users'][$k]['percent'] <=0.70){
    			$data['users'][$k]['performance'] = 'good';
    			$data['good']++;
    		}else{
    			$data['users'][$k]['performance'] = 'need_to_improve';
    			$data['need_to_improve']++;

    		}
    		$data['participants']++;

    	}

    	if($data['participants']){
    		$data['excellent_percent'] = round(($data['excellent']*100)/$data['participants'],2);
    		$data['good_percent'] = round($data['good']/$data['participants']*100,2);
    		$data['need_to_improve_percent'] = round($data['need_to_improve']/$data['participants']*100,2);
    	}
    	
    	return $data;
    }

}
