<?php

namespace PacketPrep\Http\Controllers\College;

use Illuminate\Http\Request;
use PacketPrep\Http\Controllers\Controller;
use PacketPrep\Models\College\Branch;
use PacketPrep\Models\College\College;
use PacketPrep\User;
use Illuminate\Support\Facades\DB;

class CampusController extends Controller
{
    public function main(Request $r){

    	return view('appl.college.campus.main');
    }

    public function admin(Request $r){

    	return view('appl.college.campus.admin');
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
            //dd($branches);

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
