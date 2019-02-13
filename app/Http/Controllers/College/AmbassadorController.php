<?php

namespace PacketPrep\Http\Controllers\College;

use Illuminate\Http\Request;
use PacketPrep\Http\Controllers\Controller;
use PacketPrep\Models\College\Ambassador as Obj;
use PacketPrep\Models\College\College;

class AmbassadorController extends Controller
{
    
    public function __construct(){
        $this->app      =   'college';
        $this->module   =   'ambassador';
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
                                $query->where('name', '=', 'Campus Ambassador');
                            })->get();

        $colleges = College::all();
        $score = array(); $score_2 = array();

        foreach($colleges as $c){
        	$score_2[$c->name] = $c->users()->count();
        }
        
        foreach($users as $u){
        	$score[$u->name] = $u->referrals()->count();
        }
        $data['users'] = array_reverse(array_sort($score));

        $data['colleges'] =  array_reverse(array_sort($score_2));

        //dd($data);

        return view('appl.'.$this->app.'.'.$this->module.'.'.$view)
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
    		  $branches[$b->name] = \auth::user()->whereHas('colleges', function ($query) use ($college)  			{
                                $query->where('name', '=', $college->name);
                            })->whereHas('branches',function ($query) use ($b)  			{
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

}
