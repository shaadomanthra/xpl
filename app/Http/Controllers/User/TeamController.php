<?php

namespace PacketPrep\Http\Controllers\User;

use Illuminate\Http\Request;
use PacketPrep\Http\Controllers\Controller;
use PacketPrep\User;
use PacketPrep\Models\User\User_Details;

use PacketPrep\Exports\UsersExport;
use Maatwebsite\Excel\Facades\Excel;

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


}
