<?php

namespace PacketPrep\Http\Controllers\User;

use Illuminate\Http\Request;
use PacketPrep\Http\Controllers\Controller;
use PacketPrep\User;

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
            $users = $user->where('name','LIKE',"%{$item}%")
                        ->whereIn('status',[1,3])
                        ->orderBy('name','asc')
                        ->paginate(config('global.no_of_records'));
        }else{
            $users = $user->where('name','LIKE',"%{$item}%")
                        ->orderBy('name','asc')
                        ->paginate(config('global.no_of_records'));
        }
        
        $view = $search ? 'list': 'index';
        return view('appl.user.team.'.$view)->with('users',$users);
    }

}
