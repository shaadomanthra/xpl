<?php

namespace PacketPrep\Http\Controllers\User;

use Illuminate\Http\Request;
use PacketPrep\Http\Controllers\Controller;
use PacketPrep\User;
use PacketPrep\Models\College\College;
use PacketPrep\Models\User\User_Details;

use PacketPrep\Exports\UsersExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use PacketPrep\Mail\CodingBootcamp;

class TeamController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(User $user,Request $request)
    {

        $search = $request->search;
        $item = $request->item;
        if(\auth::user())
        $user = \auth::user();
        if($user->role != 2){
            //if  guest
            if(\auth::guest()){
                 $users = $user->where('name','LIKE',"%{$item}%")
                        ->whereIn('status',[1,3])
                        ->whereHas('details', function ($query) {
                            $query->where('privacy', '=', 0);
                        })
                        ->orderBy('name','asc')
                        ->paginate(config('global.no_of_records'));
            }else{
                $users = $user->where('name','LIKE',"%{$item}%")
                        ->whereIn('status',[1,3])
                        ->whereHas('details', function ($query) {
                            $query->whereIn('privacy',[0,1]);
                        })
                        ->orderBy('name','asc')
                        ->paginate(config('global.no_of_records'));
            }
            
        }else{
            /* Admin */
            $users = $user->where('name','LIKE',"%{$item}%")
                        
                        ->orderBy('name','asc')
                        ->paginate(config('global.no_of_records'));
                      
        }
        
        $view = $search ? 'list': 'index';
        return view('appl.user.team.'.$view)->with('users',$users);
    }

    public function export() 
    {
        

        return Excel::download(new UsersExport, 'users.xlsx');
    }

    public function bootcampmail(Request $r) 
    {
        $start = $r->get('start');
        $end = $r->get('end');


        $entry = DB::table('branch_user')->whereIn('branch_id', [9,10])->pluck('user_id'); 
        $users =  User::whereIn('id',$entry)->get();

        if($start){
            for($i=$start;$i<$end;$i++){
            $user = $users[$i];
            
            if($user->client_slug!=3){
                echo $user->name.'<br>';
                Mail::to($user->email)->send(new CodingBootcamp($user));
            }

            $user->client_slug = 3;
            $user->save();

            } 
        }else{
            echo "Enter the start and ending points";
        }
        

        
        
    }


}
