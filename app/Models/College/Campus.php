<?php

namespace PacketPrep\Models\College;

use Illuminate\Database\Eloquent\Model;

use PacketPrep\Models\College\Branch;
use PacketPrep\Models\College\College;
use PacketPrep\Models\College\Campus;
use PacketPrep\Models\College\Batch;
use PacketPrep\Models\User\User_Details;
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
use Illuminate\Support\Facades\Cache;

class Campus extends Model
{
    

    public static function getAnalytics($college,$branch,$batch,$r,$course_id=null,$category_id=null,$student_username=null){

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
        		$data['total_item'][$node->id] = DB::table('category_question')->whereIn('category_id', $descendants)->where('intest',0)->count();
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

        		$data['total_item'][$node->id] = DB::table('category_question')->whereIn('category_id', $descendants)->where('intest',0)->count();
        		
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
        		
        		$data['total_item'][$c->id] = DB::table('category_question')->whereIn('category_id', $ids)->where('intest',0)->count();
        		$data[$c->id]= array("total"=>0,"solved"=>0,"time"=>0,"correct"=>0,"participants"=>0,"vg_solved"=>0,"completion"=>0,"accuracy"=>0);
            }
        }


        
        $data['total'] = DB::table('category_question')->whereIn('category_id', $item_id)->where('intest',0)->count();
        
        //dd($data['total']);

        if(!$student_username)
        $student_username = $r->get('student');

        if($student_username){
            $user = User::where('username',$student_username)->first();
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

    public static function test_count($category_id){
        $count =0;
        $category = Category::where('id',$category_id)->first();
            foreach($category->children as $node){
                if($node->exam_id){
                    $count++;
                }
            }
        return $count;
    }

    public static function analytics_test($college,$branch,$batch,$r,$course_id=null,$category_id=null,$exam_id =null,$student_username=null){


        if($college)
    	   $courses = $college->courses;
        else
            $courses = null;

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
            
    	}else if($exam_id){

    		array_push($test_id,$exam_id);
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

            if($course_id){
                $course = Course::where('id',$course_id)->first();
                $data['course'][$course->id] = array();
                foreach($course->exams as $e){
                    array_push($data['course'][$course->id],$e->id); 
                    array_push($test_id,$e->id);
                }

            }
    		
    	}

        if(!$student_username)
        $student_username = $r->get('student');

        if($student_username){
            $user = User::where('username',$student_username)->first();
            $tests = Tests_Overall::where('user_id',$user->id)
                    ->whereIn('test_id',$test_id)->get()->groupBy('test_id');

            $data_tests = array("excellent"=>0,"good"=>0,"need_to_improve"=>0,'participants'=>0,
                            "excellent_percent"=>0, "need_to_improve_percent"=>0,"good_percent"=>0,"count"=>count($test_id),"pace"=>0,"accuracy"=>0,"avg_pace"=>0,"avg_accuracy"=>0);
            $data_tests = self::getData_Test($tests,$data_tests);


        }else{

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
                $users = null;



            if($r->get('code')){
                $users_code = DB::table('tests_overall')->whereIn('test_id', $test_id)->where('code',$r->get('code'))->pluck('user_id')->toArray();
                $users = array_intersect($users->toArray(),$users_code);   
            }



            if($users){
                if(request()->get('all') && $branch){

                    $Tests_Overall = Cache::get('test_overall_'.$branch.'_'.$exam_id);
                    if(!$Tests_Overall){
                        $Tests_Overall = Tests_Overall::whereIn('user_id',$users)->whereIn('test_id',$test_id)->orderBy('score','desc')->get();
                        Cache::forever('test_overall_'.$branch.'_'.$exam_id,$Tests_Overall);
                    }
                    
                }else{
                    $Tests_Overall = Tests_Overall::whereIn('user_id',$users)->whereIn('test_id',$test_id)->orderBy('score','desc')->get();
                }
                
            }
            else
                $Tests_Overall = Tests_Overall::whereIn('test_id',$test_id)->orderBy('score','desc')->get();
            $tests =$Tests_Overall->groupBy('user_id');



            
            $c_users = null;
            if(request()->get('all')){
                $c_users = Cache::get('c_users_'.$exam_id);
                if(!$c_users){
                        $c_users =User::whereIn('id',$Tests_Overall->pluck('user_id'))->get()->groupBy('college_id');
                        Cache::forever('c_users_'.$exam_id,$c_users);
                }
                

            }else{
                $c_users =User::whereIn('id',$Tests_Overall->pluck('user_id'))->get()->groupBy('college_id');
            }



            $u = array_keys($tests->toArray());

            
            if(request()->get('all')){
                $u_data = Cache::get('u_data_'.$exam_id);
                if(!$u_data){
                    $u_data = User::whereIn('id',$u)->get()->groupBy('id');
                    Cache::forever('u_data_'.$exam_id,$u_data);
                }
            }else{
                $u_data = User::whereIn('id',$u)->get()->groupBy('id');
            }
            

            $data_tests = array("excellent"=>0,"good"=>0,"need_to_improve"=>0,
                            'participants'=>0,
                            "excellent_percent"=>0, "need_to_improve_percent"=>0,"good_percent"=>0,"count"=>count($test_id),"pace"=>0,"accuracy"=>0,"avg_pace"=>0,"avg_accuracy"=>0);
            
            $data_tests = self::getData_Test($tests,$data_tests,$u_data);

            $data_tests['college_users'] = $c_users;

            

            

        }



    	return $data_tests;

    }



    public static function getData_Test($tests,$data,$users=null){

        $data['correct'] = $data['max'] =0;

    	foreach($tests as $k=>$t)
    	{
            if(isset($users[$k])){
                $data['users'][$k]['name'] = $users[$k][0]['name'];
                $data['users'][$k]['username'] = $users[$k][0]['username']; 
                $data['users'][$k]['video'] = $users[$k][0]['video']; 
                $data['users'][$k]['branch'] = $users[$k][0]['branch_id']; 
                $data['users'][$k]['college'] = $users[$k][0]['college_id'];  
            }else{
                $data['users'][$k]['name'] = '';
                $data['users'][$k]['username'] = ''; 
                $data['users'][$k]['branch'] = ''; 
            }
            
    		$data['users'][$k]['score']=$t->sum('score');
    		$data['users'][$k]['max']=$t->sum('max');

            $data['users'][$k]['pace']=$t->sum('time')/$data['users'][$k]['max'];
            $data['users'][$k]['correct']=$t->sum('correct');

    		if($data['users'][$k]['score'])
    		  $data['users'][$k]['percent'] = round($data['users'][$k]['score']/$data['users'][$k]['max'],2);
    		else
    		  $data['users'][$k]['percent'] =0;

    		if($data['users'][$k]['percent']>0.70){
    			$data['users'][$k]['performance'] = 'excellent';
    			$data['excellent']++;
    		}elseif( $data['users'][$k]['percent']> 0.4 && $data['users'][$k]['percent'] <=0.70){
    			$data['users'][$k]['performance'] = 'good';
    			$data['good']++;
    		}else{
    			$data['users'][$k]['performance'] = 'need_to_improve';
    			$data['need_to_improve']++;

    		}



    		$data['participants']++;
            $data['correct'] =  $data['correct']  + $data['users'][$k]['correct'];
            $data['max'] = $data['max'] + $data['users'][$k]['max'];
            $data['users'][$k]['accuracy'] = round($data['users'][$k]['correct']/$data['users'][$k]['max']*100,2);
            $data['pace'] = $data['pace'] + $data['users'][$k]['pace'];

            if($t[0]->status==1){
                $data['users'][$k]['score'] = '-';
                $data['users'][$k]['max'] = '-';
                $data['users'][$k]['performance'] = 'processing';
            }

    	}

    	if($data['participants']){
    		$data['excellent_percent'] = round(($data['excellent']*100)/$data['participants'],2);
    		$data['good_percent'] = round($data['good']/$data['participants']*100,2);
    		$data['need_to_improve_percent'] = round($data['need_to_improve']/$data['participants']*100,2);


            $data['avg_pace'] = round($data['pace']/$data['participants'],2);

            if($data['avg_pace']< 60)
                $data['avg_pace'] = $data['avg_pace'].' sec';
            else
                $data['avg_pace'] = round($data['avg_pace']/60,2).' min';

            $data['avg_accuracy'] = round($data['correct']/$data['max']*100,2);

    	}

        
    	
    	return $data;
    }


    public function analytics_test_detail($college,$branch,$batch,$r,$exam_id){

        $test_id = array();
        array_push($test_id,$exam_id);
        $data = array();
        $data['course']=array();
        
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
            $users = null;



        $exam = Exam::where('id',$exam_id)->first();
        foreach($exam->sections as $section){
        if($users){

            if(request()->get('all') && $branch){

                    $tests_sections = Cache::get('tests_sections_'.$branch.'_'.$exam_id);
                    if(!$tests_sections){
                        $tests_sections = Tests_Section::whereIn('user_id',$users)->whereIn('test_id',$test_id)
                            ->where('section_id',$section->id)->get()->groupBy('user_id');
                        Cache::forever('tests_sections_'.$branch.'_'.$exam_id,$tests_sections);
                    }
                    
                }else{
                    $tests_sections = Tests_Section::whereIn('user_id',$users)->whereIn('test_id',$test_id)
                            ->where('section_id',$section->id)->get()->groupBy('user_id');
                }

           
        }
        else
            $tests_sections = Tests_Section::whereIn('test_id',$test_id)
                            ->where('section_id',$section->id)->get()->groupBy('user_id');

            $data = array("excellent"=>0,"good"=>0,"need_to_improve"=>0,'participants'=>0,
                        "excellent_percent"=>0, "need_to_improve_percent"=>0,"good_percent"=>0,"pace"=>0,"accuracy"=>0,"avg_pace"=>0,"avg_accuracy"=>0);

            $data_tests[$section->id] = self::getData_Test($tests_sections,$data); 
            $data_tests[$section->id]['name']=$section->name;

        }
                
        return $data_tests;
    }

    public function userlist_batch($college,$b){
        if($b==1){
            $batch_ids = Batch::where('college_id',$college->id)->pluck('id');
            return DB::table('batch_user')->whereIn('batch_id', $batch_ids)->pluck('user_id')->toArray();
        }else{
            $batch = Batch::where('slug',$b)->first();
            
            $users_batches = $batch->users()->pluck('id')->toArray();
            return array_intersect($users_batches,$this->userlist_college($college)); 

        }
            
    }

    public function userlist_branch($college,$b){
            $branch = Branch::where('name',$b)->first();
            $users_branches = $branch->users()->pluck('id')->toArray();
            return array_intersect($users_branches,$this->userlist_college($college)); 
    }

    public function userlist_college($college){
            return $college->users()->pluck('id')->toArray();
    }

    public function userlist_course($course_id,$user_list){
            return array_unique(Practices_Course::whereIn('course_id',$course_id)
                        ->whereIn('user_id',$user_list)
                        ->pluck('user_id')->toArray());
    }

    public function userlist_topic($topic_id,$user_list){
            return array_unique(Practices_Topic::whereIn('category_id',$topic_id)
                        ->whereIn('user_id',$user_list)
                        ->pluck('user_id')->toArray());
    }

    public function userlist_pratice($userlist,$college,$topic=null){
        $data=array();
        $item_id = array();
        if($topic){
            
            $nodes = Category::descendantsAndSelf($topic->id);
            $ids = $nodes->pluck('id')->toArray();
                foreach($ids as $id)
                array_push($item_id,$id);
        
        }else{

            
            $courses = $college->courses;
            foreach($courses as $c){
                $project = Project::where('slug',$c->slug)->first();
                $category = Category::where('slug',$project->slug)->first();
                $nodes = Category::descendantsAndSelf($category->id);
                $ids = $nodes->pluck('id')->toArray();

                foreach($ids as $id)
                array_push($item_id,$id);
                
            }

        }

        $practice_data = Practices_Topic::whereIn('category_id',$item_id)
                        ->whereIn('user_id',$userlist)->get()->groupBy('user_id');
        
            
            $total = DB::table('category_question')->whereIn('category_id', $item_id)->where('intest',0)->count();

            foreach($practice_data as $user_id => $p){
                $data[$user_id] = array("total"=>$total,"solved"=>0,"time"=>0,"correct"=>0,"participants"=>0,"avg_solved"=>0,"completion"=>0,"accuracy"=>0);
                $data[$user_id] = $this->getData($data[$user_id],$p);
            }
            return $data;

    }



}
