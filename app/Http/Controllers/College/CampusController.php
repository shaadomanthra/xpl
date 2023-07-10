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
use PacketPrep\Models\Exam\Exam;
use PacketPrep\Models\Product\Test;
use PacketPrep\Models\Course\Practices_Course;
use PacketPrep\Models\Course\Practices_Topic;
use PacketPrep\Models\Exam\Tests_Section;
use PacketPrep\Models\Exam\Tests_Overall;

use PacketPrep\Exports\ExamExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Cache;


class CampusController extends Controller
{


    public function __construct(){
        $this->app      =   'exam';
        $this->module   =   'exam';
        $this->cache_path =  '../storage/app/cache/exams/';
    }

    public function main(Request $r){

    	return view('appl.college.campus.main');
    }

    public function admin(Request $r){

        if(!\auth::user()->checkRole(['administrator','investor','patron','promoter','employee','client-owner','client-manager','manager','tpo']))
        {
             abort(403,'Unauthorised Access');   
        }

        if($r->get('set_college')){
            $college = College::find($r->get('college'));
            $r->session()->put('college', $college);
        }


        if($r->get('unset_college')){
            $r->session()->forget('college');
        }

        $campus = new Campus;
        $college_id = $r->get('college');

        if($college_id)
            $college = College::find($college_id);
        else{
            if(request()->session()->get('college')){
                $col = request()->session()->get('college')['id'];
                $college =  College::where('id',$col)->first();
            }else
                $college = \auth::user()->colleges()->first();
        }

        $branch_item = $r->get('branch');
        if($branch_item){
            $branch_item = Branch::where('name',$branch_item)->first();
            $practice['item'] = $campus->getAnalytics($college,$branch_item,null,$r);
            $test['item'] = $campus->analytics_test($college,$branch_item,null,$r);

            $practice['item_name'] = 'Courses';
            $practice['items'] = $college->courses()->orderBy('id')->get(); 
            foreach($practice['items'] as $k=> $item){

                $practice['items'][$k]->url = route('campus.courses.show',$item->slug).'?branch='.$branch_item->name;
                $practice['items'][$k]->url_participants = route('campus.student_table').'?practice=true&topic='.$item->slug.'&branch='.$branch_item->name;

                if($college_id){
                    $practice['items'][$k]->url = $practice['items'][$k]->url.'&college_id='.$college_id;
                }
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

                $practice['items'][$k]->url = route('campus.courses.show',$item->slug).'?batch=1&batch_code='.$batch_code;
                $practice['items'][$k]->url_participants = route('campus.student_table').'?practice=true&topic='.$item->slug.'&batch=1&batch_code='.$batch_code;
                if($college_id){
                    $practice['items'][$k]->url = $practice['items'][$k]->url.'&college_id='.$college_id;
                }
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
                        $practice['items'][$k]->url_participants = route('campus.student_table').'?practice=true&batch=1&batch_code='.$item->slug;
                        if($college_id){
                            $practice['items'][$k]->url = $practice['items'][$k]->url.'&college_id='.$college_id;
                        }
                }

            }    
            else{
                foreach($college->branches()->orderBy('id')->get() as $branch){
                    $practice['item'][$branch->id] = $campus->getAnalytics($college,$branch,null,$r);
                }
                $practice['item_name'] = 'Branches';
                $practice['item_tag'] = 'branch';
                $practice['items'] = $college->branches()->orderBy('id')->get(); 
                //dd($practice);
                foreach($practice['items'] as $k=> $item){
                        $practice['items'][$k]->url = route('campus.admin').'?branch='.$item->name;
                        $practice['items'][$k]->url_participants = route('campus.student_table').'?practice=true&branch='.$item->name;
                        if($college_id){
                            $practice['items'][$k]->url = $practice['items'][$k]->url.'&college_id='.$college_id;
                        }
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

        //dd($test);

    	return view('appl.college.campus.admin')
                ->with('college',$college)
                ->with('batch',$batch_item)
                ->with('branch',$branch_item)
                ->with('practice',$practice)
                ->with('test',$test);
    }



    public function courses(Request $request){


        $search = $request->search;
        $item = $request->item;
        

            if(request()->session()->get('college')){
                $col = request()->session()->get('college')['id'];
                $college =  College::where('id',$col)->first();
            }else
                $college = \auth::user()->colleges()->first();
    
        if($request->get('student'))
            $user = User::where('username',$request->get('student'))->first();
        else
            $user = null;
        $courses = Course::where('name','LIKE',"%{$item}%")
                    ->whereIn('id',$college->courses->pluck('id')->toArray())
                    ->orderBy('created_at','desc ')
                    ->paginate(config('global.no_of_records'));   

        $view = $search ? 'list_course': 'courses';

    	return view('appl.college.campus.'.$view)
                ->with('courses',$courses)
                ->with('user',$user);
    }

    public function course_student($course_slug,$username,Request $r){

        if(!\auth::user()->checkRole(['administrator','investor','patron','promoter','employee','client-owner','client-manager','manager','tpo']))
        {
             abort(403,'Unauthorised Access');   
        }

        $user = User::where('username',$username)->first();
        $course = Course::where('slug',$course_slug)->first();
        
        if(request()->session()->get('college')){
                $col = request()->session()->get('college')['id'];
                $college =  College::where('id',$col)->first();
            }else
                $college = \auth::user()->colleges()->first();

        $campus = new Campus;
        $url_parameters='';


        $batch_mode = $r->get('batch');

       // dd($nodes);
        $category = Category::where('slug',$r->get('topic'))->first();

       // dd($category->children);

        $practice['item_name'] = 'Topics';

        // course analytics
        if($category){
            $practice['item'] = $campus->getAnalytics($college,null,null,$r,null,$category->id,$user->username);
            $test['item'] = null;

            $test['item']['count'] = 0;
             // topic analysis
            $nodes = $category->children;

            $practice['items'] = $nodes; 
            foreach($practice['items'] as $k=> $item){
                $practice['items'][$k]->url = 
                        route('campus.courses.student.show',[$course->slug,$user->username]).'?topic='.$item->slug.$url_parameters;
                    
                if($item->exam_id){
                    
                    if($test['item']['count']==0)
                    $test['item'][$item->id] = 0;
                    else    
                    $test['item'][$item->id] = 0;
                }
                        
            }

        }else{
            $practice['item'] = $campus->getAnalytics($college,null,null,$r,$course->id,null,$user->username);
            $test['item'] = $campus->analytics_test($college,null,null,$r,$course->id,null,null,$user->username);

             // topic analysis
            $project = Project::where('slug',$course->slug)->first();
            $category = Category::where('slug',$project->slug)->first();
            $nodes = $category->children;

            foreach($course->exams as $exam){
                $test['exam'][$exam->id] = $campus->analytics_test($college,null,null,$r,null,null,$exam->id,$user->username);
                $test['exam'][$exam->id]['name'] = $exam->name;
                $test['exam'][$exam->id]['url'] = route('campus.tests.student.show',[$exam->slug,$user->username]);
            }

            //dd($test['exam']);
            $practice['items'] = $nodes; 
            foreach($practice['items'] as $k=> $item){

                $practice['items'][$k]->url = route('campus.courses.student.show',[$course->slug,$user->username]).'?topic='.$item->slug.$url_parameters;
            }
        }

        //dd($test);
        return view('appl.college.campus.course_student')
                ->with('course',$course)
                ->with('college',$college)
                ->with('category',$category)
                ->with('test',$test)
                ->with('user',$user)
                ->with('practice',$practice);
    }

    public function course_show($course_slug,Request $r){

        if(!\auth::user()->checkRole(['administrator','investor','patron','promoter','employee','client-owner','client-manager','manager','tpo']))
        {
             abort(403,'Unauthorised Access');   
        }

        $campus = new Campus;
        $url_parameters='';
        $college_id = $r->get('college');
        if($college_id)
            $college = College::find($college_id);
        else
            {
                if(request()->session()->get('college')){
                $col = request()->session()->get('college')['id'];
                $college =  College::where('id',$col)->first();
                }else
                    $college = \auth::user()->colleges()->first();
            }

        $batch_mode = $r->get('batch');

        if($batch_mode){
            $menu['item'] = $college->batches;
            $menu['name'] = 'batch_code';
            $menu['menu'] = 'Batches';
            $url_parameters = $url_parameters.'&batch=1'; 
        }else{
            $menu['item'] = $college->branches()->orderBy('id')->get();
            $menu['name'] = 'branch';
            $menu['menu'] = 'Branches';
        }
       // dd($nodes);

        $course = Course::where('slug',$course_slug)->first();

        $category = Category::where('slug',$r->get('topic'))->first();

       // dd($category->children);

        $practice['item_name'] = 'Topics';
        $practice['batch_branch'] = null;
        $branch_item = $r->get('branch');

        if($branch_item){

            $branch_item = Branch::where('name',$branch_item)->first();
            $practice['batch_branch'] = $branch_item->name;
            $url_parameters = $url_parameters.'&branch='.$branch_item->name;
        }

        $batch_code = $r->get('batch_code');
        if($batch_code){
            $batch_item = Batch::where('slug',$r->get('batch_code'))->first();
            $practice['batch_branch'] = $batch_item->name;
            $url_parameters = $url_parameters.'&batch_code='.$batch_item->slug;
        }else{
            $batch_item = null;
        }

        // course analytics
        if($category){
            $practice['item'] = $campus->getAnalytics($college,$branch_item,$batch_item,$r,null,$category->id);
            $test['item'] = null;

            $test['item']['count'] = 0;
             // topic analysis
            $nodes = $category->children;

            $practice['items'] = $nodes; 
            foreach($practice['items'] as $k=> $item){
                $practice['items'][$k]->url = 
                        route('campus.courses.show',$course->slug).'?topic='.$item->slug.$url_parameters;
                $practice['items'][$k]->url_participants = route('campus.student_table').'?practice=true&topic='.$item->slug.$url_parameters;
                    
                if($item->exam_id){
                    
                    if($test['item']['count']==0)
                    $test['item'][$item->id] = 0;
                    else    
                    $test['item'][$item->id] = 0;
                }
                        
            }

        }else{
            $practice['item'] = $campus->getAnalytics($college,$branch_item,$batch_item,$r,$course->id);
            $test['item'] = $campus->analytics_test($college,$branch_item,$batch_item,$r,$course->id);

             // topic analysis
            $project = Project::where('slug',$course->slug)->first();
            $category = Category::where('slug',$project->slug)->first();
            $nodes = $category->children;

            foreach($course->exams as $exam){
                $test['exam'][$exam->id] = $campus->analytics_test($college,$branch_item,$batch_item,$r,null,null,$exam->id);
                $test['exam'][$exam->id]['name'] = $exam->name;
                $test['exam'][$exam->id]['url'] = route('campus.tests.show',$exam->slug);
            }

            //dd($test['exam']);
            $practice['items'] = $nodes; 
            foreach($practice['items'] as $k=> $item){

                $practice['items'][$k]->url = route('campus.courses.show',$course->slug).'?topic='.$item->slug.$url_parameters;
                 $practice['items'][$k]->url_participants = route('campus.student_table').'?practice=true&topic='.$item->slug.$url_parameters;
            }
        }

    	return view('appl.college.campus.course_show')
                ->with('college',$college)
                ->with('course',$course)
                ->with('category',$category)
                ->with('test',$test)
                ->with('practice',$practice)
                ->with('menu',$menu);
    }

    public function tests(Request $request){
        $search = $request->search;
        $item = $request->item;
        
        if(request()->session()->get('college')){
                $col = request()->session()->get('college')['id'];
                $college =  College::where('id',$col)->first();
            }else
                $college = \auth::user()->colleges()->first();

        $exam_id =[];
        foreach($college->courses as $course)
        {
            foreach($course->exams as $exam)
            array_push($exam_id,$exam->id );
        }

        if($request->get('student'))
            $user = User::where('username',$request->get('student'))->first();
        else
            $user = null;


        $exams = Exam::where('name','LIKE',"%{$item}%")
                    ->whereIn('id',$exam_id)
                    ->orderBy('created_at','desc ')
                    ->paginate(config('global.no_of_records'));   

        $view = $search ? 'list_test': 'tests';


    	return view('appl.college.campus.'.$view)
                ->with('exams',$exams)
                ->with('user',$user);
    }

    public function test_student($exam,$user,Request $r){

        $student = User::where('username',$user)->first();
        $exam = Exam::where('slug',$exam)->first();

        $questions = array();
        $i=0;


        if(!$student)
            $student = \auth::user();

        
        $details = ['correct'=>0,'incorrect'=>'0','unattempted'=>0,'attempted'=>0,'avgpace'=>'0','testdate'=>null,'marks'=>0,'total'=>0];
        $details['course'] = $exam->name;
        $sum = 0;
        $c=0; $i=0; $u=0;

        $tests = Test::where('test_id',$exam->id)
                        ->where('user_id',$student->id)->get();

        
        if(!count($tests))
            return view('appl.college.campus.test_student')->with('nodata',true)->with('exam',$exam)

                        ->with('user',$student);     


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
            
        
        //dd($sections);

        return view('appl.college.campus.test_student')
                        ->with('exam',$exam)
                        ->with('sections',$sections)
                        ->with('details',$details)
                        ->with('user',$student)
                        ->with('nodata','')
                        ->with('chart',true);
    }

    public function test_show($exam_slug,Request $r){

        $exam = Exam::where('slug',$exam_slug)->first();
        
        if(request()->session()->get('college')){
                $col = request()->session()->get('college')['id'];
                $college =  College::where('id',$col)->first();
        }else
                $college = \auth::user()->colleges()->first();

        $sections = $data = null;
        $campus = new Campus();
        $batch_code = $r->get('batch_code');
        $branch_item = $r->get('branch');

        if($branch_item){
            $branch_item = Branch::where('name',$branch_item)->first();
            $data['item_name'] = 'Branch';
            $data['item'] = $branch_item;
        }

        if($batch_code){
            $batch_code = Batch::where('slug',$batch_code)->first();
            $data['item_name'] = 'Batch';
            $data['item'] = $batch_code;
        }


        $details = $campus->analytics_test($college,$branch_item,$batch_code,$r,null,null,$exam->id);
        if(count($exam->sections)>1){
            $details['section'] = $campus->analytics_test_detail($college,$branch_item,$batch_code,$r,$exam->id);
            $sections = $exam->sections;
        }


        if($r->get('batch')&& !$r->get('batch_code')){

               $batches = $college->batches()->orderBy('id')->get();
                foreach($batches as $batch){
                $details['items'][$batch->id] = $campus->analytics_test($college,null,$batch,$r,null,null,$exam->id);
                $details['items'][$batch->id]['name'] = $batch->name; 
                $details['items'][$batch->id]['url'] = route('campus.tests.show',$exam->slug).'?batch=1&batch_code='.$batch->slug;
                }
                $details['item_name'] = 'Batch'; 
            
        }else if(!$r->get('batch')&& !$r->get('batch_code') && !$r->get('branch')){
            $branches = $college->branches()->orderBy('id')->get();

            foreach($branches as $branch){
            $details['items'][$branch->id] = $campus->analytics_test($college,$branch,null,$r,null,null,$exam->id);

            $details['items'][$branch->id]['name'] = $branch->name; 
            $details['items'][$branch->id]['url'] = route('campus.tests.show',$exam->slug).'?branch='.$branch->name;
                
            }

            $details['item_name'] = 'Branch';
        }
        

      $branches = array(1=>"BCOM",2=>"",3=>"",4=>"",5=>"",6=>"",7=>"",8=>"",9=>"CSE",10=>"IT",11=>"ECE",12=>"EEE",13=>"MECH",14=>"CIVIL",15=>"OTHER");


    	return view('appl.college.campus.test_show')
            ->with('exam',$exam)
            ->with('details',$details)
            ->with('data',$data)
            ->with('test_analysis',1)
            ->with('sections',$sections)
            ->with('branches',$branches);
    }


    public function test_analytics($exam_slug,Request $r){

        $code  = $r->get('code');
        $filename = $exam_slug.'.json';
        $filepath = $this->cache_path.$filename;


        if(file_exists($filepath))
        {
            $exam = json_decode(file_get_contents($filepath));
        }else{
            $exam = Exam::where('slug',$exam_slug)->first();
        }

        
        $this->authorize('create', $exam);
        
        if(request()->session()->get('college')){
            $col = request()->session()->get('college')['id'];
            $college =  College::where('id',$col)->first();
        }else{

            if(request()->get('all'))
                $college = null;
            else if(request()->get('college_id'))
                $college =  College::where('id',request()->get('college_id'))->first();
            else
                $college = null;
        }

        $sections = $data = null;
        $campus = new Campus();
        $batch_code = $r->get('batch_code');
        $branch_item = $r->get('branch');

        if($branch_item){
            $branch_item = Branch::where('name',$branch_item)->first();
            $data['item_name'] = 'Branch';
            $data['item'] = $branch_item;
        }

        if($batch_code){
            $batch_code = Batch::where('slug',$batch_code)->first();
            $data['item_name'] = 'Batch';
            $data['item'] = $batch_code;
        }



        $details = $campus->analytics_test($college,$branch_item,$batch_code,$r,null,null,$exam->id);

        if(count($exam->sections)>1){
            $details['section'] = $campus->analytics_test_detail($college,$branch_item,$batch_code,$r,$exam->id);
            $sections = $exam->sections;
        }



        if($r->get('batch')&& !$r->get('batch_code')){

               $batches = $college->batches()->orderBy('id')->get();
                foreach($batches as $batch){
                $details['items'][$batch->id] = $campus->analytics_test($college,null,$batch,$r,null,null,$exam->id);
                $details['items'][$batch->id]['name'] = $batch->name; 
                $details['items'][$batch->id]['url'] = route('test.analytics',$exam->slug).'?batch=1&batch_code='.$batch->slug;
                }
                $details['item_name'] = 'Batch'; 
            
        }else if(!$r->get('batch')&& !$r->get('batch_code') && !$r->get('branch')){
            if($college)
                $branches = $college->branches()->orderBy('id')->get();
            else
                $branches = Branch::whereIn('name',['CSE','ECE','EEE','IT','CIVIL','MECH','AERO','BE-AGRICULTURE','BIOMEDICAL','BT','CSW','CSO','CSM','CSIT','AI','Data_Science','OTHER'])->get();

            foreach($branches as $branch){
            $details['items'][$branch->id] = $campus->analytics_test($college,$branch,null,$r,null,null,$exam->id);

            $details['items'][$branch->id]['name'] = $branch->name; 
            $details['items'][$branch->id]['url'] = route('test.analytics',$exam->slug).'?branch='.$branch->name;
                
            }

            $details['item_name'] = 'Branch';
        }

        
        $branches = array(1=>"BCOM",2=>"",3=>"",4=>"",5=>"",6=>"",7=>"",8=>"",9=>"CSE",10=>"IT",11=>"ECE",12=>"EEE",13=>"MECH",14=>"CIVIL",15=>"OTHER",30=>"AERO",31=>"BE-AGRICULTURE",32=>"BIOMEDICAL",33=>"BT",60=>"CSW",61=>"CSO",69=>"CSM",47=>"CSIT",41=>"AI",74=>"Data_Science");
        if(!$college)
        $colleges = College::all()->groupBy('id');
        else
        $colleges = null;

        if($details['college_users']){
            foreach($details['college_users'] as $coll => $counter){
                if(!$coll)
                    $coll =0;
                $coll_list[$coll]= count($counter);
            }
            if(isset($coll_list)){
            arsort($coll_list);
            $details['coll_list'] =$coll_list;
            }
            
        }


        if(request()->get('export')){
            foreach($details['users'] as $w=>$u){
                if($u['college']){
                    if($colleges[$u['college']][0])
                        $college_name = $colleges[$u['college']][0]->name;
                    else if($college)
                        $college_name = $college->name;
                    $details['users'][$w]['college'] = $college_name;
                }

                if($u['branch']){
                    $details['users'][$w]['branch'] = $branches[$u['branch']];
                }

                if($sections)
                foreach($sections as $s){
                    if(isset($details['section'][$s->id]['users'][$w]['score']))
                        $details['users'][$w][$s->name] = $details['section'][$s->id]['users'][$w]['score'];
                    else
                        $details['users'][$w][$s->name] = 0;
                }
            }

            $d = $details['users'];
            $users = array_keys($d);
            request()->session()->put('d',$d);
            request()->session()->put('sections',$sections);
            request()->session()->put('users',$users);

            $name = $exam->name;
            if($code)
                $name = $code.'_'.$exam->slug;
            if(request()->get('export')==1)
            return Excel::download(new ExamExport, $name."_full.xlsx");
            else
            return Excel::download(new ExamExport2, $name.".xlsx");

        }

        $exam->settings = json_decode($exam->settings);
        //dd($exam);
        if(isset($exam->settings->totalmarks)){
            if($exam->settings->totalmarks){
                foreach($details['users'] as $a=>$b){
                    $details['users'] [$a]['max'] = $exam->settings->totalmarks;
                }
            }
           
        }
        

        return view('appl.college.campus.test_show2')
            ->with('exam',$exam)
            ->with('details',$details)
            ->with('data',$data)
            ->with('test_analysis',1)
            ->with('college',$college)
            ->with('colleges',$colleges)
            ->with('sections',$sections)
            ->with('branches',$branches);
    }

    public function students(Request $r){

        $obj = new CampusController;

        if(request()->session()->get('college')){
                $col = request()->session()->get('college')['id'];
                $college =  College::where('id',$col)->first();
            }else
                $college = \auth::user()->colleges()->first();
                
        $this->authorize('manage', $college);


        $users_college = $college->users()->pluck('id')->toArray();
        $branches = DB::table('branch_user')->whereIn('user_id', $users_college)->get()->groupBy('branch_id');



        $branches->total = count($users_college); 
        if($r->get('branch')){
            $branch = Branch::where('name',$r->get('branch'))->first();
            $users_branches = $branch->users()->pluck('id')->toArray();
            $user_list = array_intersect($users_branches,$users_college);
            
        }else if($r->get('practice')){
            $users = $college->users()->pluck('id')->toArray();
            if($r->get('course'))
                $course_id = Course::where('slug',$r->get('course'))->pluck('id')->toArray();
            else
                $course_id = $college->courses()->pluck('id')->toArray();

            $user_list = array_unique(Practices_Course::whereIn('course_id',$course_id)
                        ->whereIn('user_id',$users)
                        ->pluck('user_id')->toArray());

            
            
        }else if($r->get('test')){
            $users = $college->users()->pluck('id')->toArray();
            if($r->get('course')){
                $course = Course::where('slug',$r->get('course'))->first();
                $test_id = $course->exams()->pluck('id')->toArray();
            }
            else{
                $test_id = array();
                if($college->courses()->first())
                foreach($college->courses as $course){
                    if($course->exams()->first())
                    foreach($course->exams as $e)
                        array_push($test_id,$e->id);
                }
                $courses = $college->courses()->pluck('id')->toArray();
            }


            $user_list = array_unique(Tests_Overall::whereIn('test_id',$test_id)
                        ->whereIn('user_id',$users)
                        ->pluck('user_id')->toArray());
        }
        else{

            $user_list = $college->users()->pluck('id')->toArray();
        }

        $item = $r->item;
        $search = $r->search;
         
        $view = $search ? 'list_students': 'students';

        $users = User::whereIn('id',$user_list)->where('name','LIKE',"%{$item}%")
                ->orderBy('created_at','desc ')
                ->paginate(config('global.no_of_records'));

    	return view('appl.college.campus.'.$view)
            ->with('users',$users)
            ->with('college',$college)
            ->with('total',count($user_list))
            ->with('branches',$branches);
    }

    public function remove_duplicates($id){
        
        $tests = Test::where('test_id',$id)->get();
        $users = $tests->unique('user_id')->pluck('user_id');
        $i=0;
        $us=array();

        $usr = User::whereIn('id',$users)->get();
        foreach($users as $user){
            $entry = Test::where('test_id',$id)->where('user_id',$user)->get()->groupBy('question_id');
            $sections = Tests_Section::where('test_id',$id)->where('user_id',$user)->get()->groupBy('section_id');
            $tests = Tests_Overall::where('test_id',$id)->where('user_id',$user)->get();
            
            foreach($entry as $k=>$g){
                if(count($g)>1){
                    echo count($g).' '.$k.'<br>';
                    if(!in_array($user, $us))
                    $us[$i++]=$user;
                    foreach($g as $m=>$item){
                        if($m!=0)
                            $item->delete();
                    }
                }
            }

            foreach($sections as $sec){
                if(count($sec)>1){
                    foreach($sec as $m=>$item){
                        if($m!=0)
                            $item->delete();
                    }
                }
            }

            foreach($tests as $m=>$item){
                if($m!=0)
                    $item->delete();
            }


            
        }

        foreach($usr as $uk){
            if(!$uk->branch_id || $uk->branch_id==1)
            if($uk->branches()->first()){
              $uk->branch_id = $uk->branches()->first()->id;
              $uk->save();  
            }    
        }
        
        
    }

    public function user_details_update(){

        
        $data = file_get_contents('update.txt');
        
        $id = $data;
        $users = User::whereNull('branch_id')->where('id','>',$id)->where('id','<',$id+500)->get();
        

        foreach($users as $k=>$user){
            
            if(count($user->colleges)){
               $user->college_id = $user->colleges->first()->id; 
            }
            
            if(count($user->branches))
            $user->branch_id = $user->branches->first()->id;

            if($user->details){
                $details = $user->details;
                $user->roll_number = $details->roll_number;
                $user->phone = $details->phone;
                $user->year_of_passing = $details->year_of_passing;
            }
            $user->save();
            $d = $user->id;
        }


        file_put_contents('update.txt', $d);
        dd($id);
    }

    public function student_table(Request $r){

        $obj = new CampusController;
        $campus = new Campus;

        if(request()->session()->get('college')){
            $col = request()->session()->get('college')['id'];
            $college =  College::where('id',$col)->first();
        }else
            $college = \auth::user()->colleges()->first();
                
        $this->authorize('manage', $college);

        $item = array();
        $item['batch'] = null;
        $item['branch']= null;
        $item['course'] = null;
        $item['topic'] = null;

        if($r->get('branch')){
            $item['branch'] = Branch::where('name',$r->get('branch'))->first();
            $user_list = $campus->userlist_branch($college,$r->get('branch'));
        }else if($r->get('batch_code')){
            $item['batch'] = Batch::where('slug',$r->get('batch_code'))->first();
            $user_list = $campus->userlist_batch($college,$r->get('batch_code'));
        }else{
            $user_list = $campus->userlist_college($college);
        }


        $user_list2 = null;
        if($r->get('practice')){
            if($r->get('topic')){
                $item['topic'] = Category::where('slug',$r->get('topic'))->first();
                $category = $item['topic'];
                $topic_id = $category->descendantsAndSelf($category)->pluck('id')->toArray();
                $user_list2 = $campus->userlist_topic($topic_id,$user_list);
            }
            else{
                $course_id = $college->courses()->pluck('id')->toArray();
                $user_list2 = $campus->userlist_course($course_id,$user_list);
            }

            
            
        }else if($r->get('test')){
            if($r->get('course')){
                $course = Course::where('slug',$r->get('course'))->first();
                $item['course'] = $course;
                $test_id = $course->exams()->pluck('id')->toArray();
            }
            else{
                $test_id = array();
                if($college->courses()->first())
                foreach($college->courses as $course){
                    if($course->exams()->first())
                    foreach($course->exams as $e)
                        array_push($test_id,$e->id);
                }
                $courses = $college->courses()->pluck('id')->toArray();
            }


            $user_list2 = array_unique(Tests_Overall::whereIn('test_id',$test_id)
                        ->whereIn('user_id',$user_list)
                        ->pluck('user_id')->toArray());
        }
        


        if(count($user_list2)){
            $user_list = array_intersect($user_list,$user_list2); 
        }else{
            // when no one participated
            $user_list = $user_list2;
        }

        if(count($user_list)){
            
            $data = $campus->userlist_pratice($user_list,$college,$item['topic']);

        }

        $item_ = $r->item;
        $search = $r->search;
         
        $view = $search ? 'student_table': 'student_table';

        $users = User::whereIn('id',$user_list)->where('name','LIKE',"%{$item_}%")
                ->orderBy('created_at','desc ')
                ->paginate(20);

        return view('appl.college.campus.'.$view)
            ->with('users',$users)
            ->with('user_count',count($user_list))
            ->with('item',$item)
            ->with('college',$college)
            ->with('data',$data)
            ->with('total',count($user_list));
    }
    public function student_show(Request $r){

    	return view('appl.college.campus.student_show');
    }
}
