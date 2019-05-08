<?php

namespace PacketPrep\Models\College;

use Illuminate\Database\Eloquent\Model;

class Campus extends Model
{
    

    public function getAnalytics($college,$branch,$batch,Request $r){

        $data = array();
        $item_name = 'category_id';
        if($r->get('course')){ 
            $data['item'] = Course::where('id',$r->get('course'))
                            ->first();
            $project = Project::where('slug',$data['item']->slug)
                        ->first();
            $category = Category::where('slug',$project->slug)->first();
            $nodes = Category::descendantsOf($category->id);
            $item_id = $nodes->pluck('id')->toArray(); 
        }elseif($r->get('category'))
        {
            $data['item'] = Category::where('id',$r->get('category'))->first();
            $nodes = Category::descendantsAndSelf($data['item']->id);
            $item_id = $nodes->pluck('id')->toArray(); 
        }else{
            $data['item'] = null;
            $courses = Course::where('status',1)->get();
            $item_id = array();
            foreach($courses as $c){
                $category = Category::where('slug',$c->slug)->first();
                $items = Category::descendantsOf($category->id)->pluck('id')->toArray();
                $item_id = $item_id + $items;

            }
            
        }

        //dd($item_id);
        
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
            
            $data = $this->getData($data,$practice);

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

            if($r->get('course'))
            $practice = Practices_Course::where('course_id',$r->get('course'))
                        ->whereIn('user_id',$users)->get();
            else    
            $practice = Practices_Topic::whereIn('category_id',$item_id)
                        ->whereIn('user_id',$users)->get();

            //dd($item_id);

            $data = $this->getData($data,$practice);


        }
        return $data;
    }

    public function getData($data, $practice){

        $data['solved'] = $practice->sum('attempted');
        if($data['solved'])
        $data['time'] = round($practice->sum('time')/$data['solved'],2);
        else
            $data['time']  =0;
        $data['correct'] = round($practice->sum('correct'),2);

        $data['participants'] = count($practice->unique('user_id'));

        if($data['solved'])
        $data['avg_solved'] = round($data['solved']/$data['participants'],2);
        else
        $data['avg_solved']  = 0;

        if($data['avg_solved'])
        $data['completion']  = round($data['avg_solved']/$data['total'],2)*100;
        else
        $data['completion'] =0;

        if($data['solved'])     
            $data['accuracy'] = round(($data['correct']*100)/$data['solved'],2);
        else
            $data['accuracy'] = 0;  

        return $data;
    }

    public function analytics_test($college,$branch,$batch,Request $r){



    	$student = $r->get('student');
    	


    	if($r->get('student')){
    		$data['user'] =  User::where('id',$student)->first();
    		$users = array($student);
    	
    	}
    	else if($college && $branch){   
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

    
    	$tests = Tests_Overall::whereIn('user_id',$users)->get();

    	$data = $this->getData_Test($tests);
    	
    	return $data;

    }


    public function getData_Test($tests){

        $data['solved'] = $tests->sum('attempted');
        if($data['solved'])
        $data['time'] = round($practice->sum('time')/$data['solved'],2);
        else
            $data['time']  =0;
        $data['correct'] = round($practice->sum('correct'),2);

        $data['participants'] = count($practice->unique('user_id'));

        if($data['solved'])
        $data['avg_solved'] = round($data['solved']/$data['participants'],2);
        else
        $data['avg_solved']  = 0;

        if($data['avg_solved'])
        $data['completion']  = round($data['avg_solved']/$data['total'],2)*100;
        else
        $data['completion'] =0;

        if($data['solved'])     
            $data['accuracy'] = round(($data['correct']*100)/$data['solved'],2);
        else
            $data['accuracy'] = 0;  

        return $data;
    }

}
