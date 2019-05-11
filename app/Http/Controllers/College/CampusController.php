<?php

namespace PacketPrep\Http\Controllers\College;

use Illuminate\Http\Request;
use PacketPrep\Http\Controllers\Controller;
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

class CampusController extends Controller
{
    public function main(Request $r){

    	return view('appl.college.campus.main');
    }

    public function admin(Request $r){

        if(!\auth::user()->checkRole(['administrator','investor','patron','promoter','employee','client-owner','client-manager','manager','tpo']))
        {
             abort(403,'Unauthorised Access');   
        }

        $campus = new Campus;
        $college_id = $r->get('college');
        if($college_id)
            $college = College::find($college_id);
        else
            $college = \auth::user()->colleges()->first();

        $branch_item = $r->get('branch');
        if($branch_item){
            $branch_item = Branch::where('name',$branch_item)->first();
            $practice['item'] = $campus->getAnalytics($college,$branch_item,null,$r);
            $test['item'] = $campus->analytics_test($college,$branch_item,null,$r);

            $practice['item_name'] = 'Courses';
            $practice['items'] = $college->courses()->orderBy('id')->get(); 
            foreach($practice['items'] as $k=> $item){

                $practice['items'][$k]->url = route('campus.courses.show',$item->slug);
                $test['item'][$item->id] = $campus->analytics_test($college,$branch_item,null,$r,$item->id);
                //dd($test);
            }

        }
        //dd($practice);

        $batch_mode = $r->get('batch');
        $batch_code = $r->get('batch_code');
        $batch_item = null;
        if($batch_code){
            $batch_item = Batch::where('slug',$r->get('batch_code'))->first();
            $practice['item'] = $campus->getAnalytics($college,null,$batch_item,$r);
            $test['item'] = $campus->analytics_test($college,null,$batch_item,$r);

            $practice['item_name'] = 'Courses';
            $practice['items'] = $college->courses()->orderBy('id')->get(); 
            foreach($practice['items'] as $k=> $item){

                $practice['items'][$k]->url = route('campus.courses.show',$item->slug);
                $test['item'][$item->id] = $campus->analytics_test($college,null,$batch_item,$r,$item->id);
                //dd($test);
            }
        }
        
        
        if(!$batch_item && !$branch_item){
             // Practice Analytics
            $practice['item'] = $campus->getAnalytics($college,null,null,$r); 
            if($batch_mode){
                foreach($college->batches as $batch){
                    $practice['item'][$batch->id] = $campus->getAnalytics($college,null,$batch,$r);
                }
                $practice['items'] = $college->batches;

                $practice['item_name'] = 'Batches';
                foreach($practice['items'] as $k=> $item){
                        $practice['items'][$k]->url = route('campus.admin').'?batch_code='.$item->slug;
                }

            }    
            else{
                foreach($college->branches()->orderBy('id')->get() as $branch){
                    $practice['item'][$branch->id] = $campus->getAnalytics($college,$branch,null,$r);
                }
                $practice['item_name'] = 'Branches';
                $practice['items'] = $college->branches()->orderBy('id')->get(); 
                foreach($practice['items'] as $k=> $item){
                        $practice['items'][$k]->url = route('campus.admin').'?branch='.$item->name;
                }
            }
            
            // Test Analytics
            $test['item'] = $campus->analytics_test($college,null,null,$r);
            if($batch_mode){

                foreach($college->batches as $batch){
                    $test['item'][$batch->id] = $campus->analytics_test($college,null,$batch,$r);
                }
                $test['items'] = $college->batches;

            }    
            else{
                foreach($college->branches()->orderBy('id')->get() as $branch){
                    $test['item'][$branch->id] = $campus->analytics_test($college,$branch,null,$r);
                }
                $test['items'] = $college->branches()->orderBy('id')->get();
                
            }
        }

    	return view('appl.college.campus.admin')
                ->with('college',$college)
                ->with('batch',$batch_item)
                ->with('branch',$branch_item)
                ->with('practice',$practice)
                ->with('test',$test);
    }



    public function courses(Request $r){

    	return view('appl.college.campus.courses');
    }

    public function course_show($course_slug,Request $r){

        if(!\auth::user()->checkRole(['administrator','investor','patron','promoter','employee','client-owner','client-manager','manager','tpo']))
        {
             abort(403,'Unauthorised Access');   
        }

        $campus = new Campus;
        $college_id = $r->get('college');
        if($college_id)
            $college = College::find($college_id);
        else
            $college = \auth::user()->colleges()->first();


       // dd($nodes);

        $course = Course::where('slug',$course_slug)->first();

        $category = Category::where('slug',$r->get('topic'))->first();

       // dd($category->children);

        $practice['item_name'] = 'Topics';

        $branch_item = $r->get('branch');

        if($branch_item){
            $branch_item = Branch::where('name',$branch_item)->first();
        }

        $batch_code = $r->get('batch_code');
        if($batch_code){
            $batch_item = Batch::where('slug',$r->get('batch_code'))->first();
        }else{
            $batch_item = null;
        }

        // course analytics
        if($category){
            $practice['item'] = $campus->getAnalytics($college,$branch_item,$batch_item,$r,null,$category->id);
            $test['item'] = $campus->analytics_test($college,$branch_item,$batch_item,$r,null,$category->id);

             // topic analysis
            $nodes = $category->children;

            $practice['items'] = $nodes; 
            foreach($practice['items'] as $k=> $item){
                $practice['items'][$k]->url = route('campus.courses.show',$item->slug);
                $test['item'][$item->id] = $campus->analytics_test($college,null,null,$r,null,$item->id);
                    //dd($test);
            }

        }else{
            $practice['item'] = $campus->getAnalytics($college,$branch_item,$batch_item,$r,$course->id);
            $test['item'] = $campus->analytics_test($college,$branch_item,$batch_item,$r,$course->id);

             // topic analysis
            $project = Project::where('slug',$course->slug)->first();
            $category = Category::where('slug',$project->slug)->first();
            $nodes = $category->children;

            $practice['items'] = $nodes; 
            foreach($practice['items'] as $k=> $item){
                $practice['items'][$k]->url = route('campus.courses.show',$item->slug);
                $test['item'][$item->id] = $campus->analytics_test($college,null,null,$r,null,$item->id);
                    //dd($test);
            }
        }
        dd($practice);
        
    	return view('appl.college.campus.course_show')
                ->with('college',$college)
                ->with('course',$course)
                ->with('category',$category)
                ->with('test',$test)
                ->with('practice',$practice);
    }

    public function tests(Request $r){

    	return view('appl.college.campus.tests');
    }

    public function test_show(Request $r){

    	return view('appl.college.campus.test_show');
    }

    public function students(Request $r){

        $obj = new CampusController;

        $college = \auth::user()->colleges()->first();
        $this->authorize('manage', $college);


        $users_college = $college->users()->pluck('id')->toArray();
        $branches = DB::table('branch_user')->whereIn('user_id', $users_college)->get()->groupBy('branch_id');



        $branches->total = count($users_college); 
        if($r->get('branch')){
            $branch = Branch::where('name',$r->get('branch'))->first();
            $users_branches = $branch->users()->pluck('id')->toArray();
            $user_list = array_intersect($users_branches,$users_college);
            
        }else
            $user_list = $college->users()->pluck('id')->toArray();

        $users = User::whereIn('id',$user_list)
                ->paginate(config('global.no_of_records'));

    	return view('appl.college.campus.students')
            ->with('users',$users)
            ->with('college',$college)
            ->with('total',count($user_list))
            ->with('branches',$branches);
    }

    public function student_show(Request $r){

    	return view('appl.college.campus.student_show');
    }
}
