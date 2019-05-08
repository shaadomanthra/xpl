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

        // Practice Analytics
        $college_id = $r->get('college_id');
        if($college_id)
            $college = College::find($college_id);
        else
            $college = \auth::user()->colleges()->first();
        $data['college'] = Campus::getAnalytics($college,null,null,$r);

        $batch = $r->get('batch');
        if($batch){
            foreach($college->batches as $batch){
                $data[$batch->id] = Campus::getAnalytics($college,null,$batch,$r);
            }
            $data['items'] = $college->batches;

        }    
        else{
            foreach($college->branches()->orderBy('id')->get() as $branch){
                $data[$branch->id] = Campus::getAnalytics($college,$branch,null,$r);
            }
            $data['items'] = $college->branches()->orderBy('id')->get();
        }
        
        // Test Analytics

        // Practice Analytics

    	return view('appl.college.campus.admin')
                ->with('college',$college)
                ->with('data',$data);
    }



    public function programs(Request $r){

    	return view('appl.college.campus.programs');
    }

    public function program_show(Request $r){

    	return view('appl.college.campus.program_show');
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
