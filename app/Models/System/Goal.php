<?php

namespace PacketPrep\Models\System;

use Illuminate\Database\Eloquent\Model;

class Goal extends Model
{
    protected $fillable = [
        'user_id',
        'title',
        'content',
        'endnote',
        'status',
        'prime',
        'end_to',
    ];


    public function user(){
    	return $this->belongsTo('PacketPrep\User');
    }

    public function getGoals(){
    	$request = request();
    	$goal = new Goal();

        $status = [0,1,2];
        $prime = [0,1];
        if($request->get('all'))
            $status = [0,1,2];
        if($request->get('prime'))
            $prime = [1];
        if($request->get('open'))
            $status = [0];
        if($request->get('complete'))
            $status = [1];
        if($request->get('incomplete'))
            $status = [2];
        

        if(\Auth::guest()){
            return redirect('login');          
        }else{
             $goals = $goal
                        ->whereIn('prime',$prime)
                        ->whereIn('status',$status)
                        ->orderBy('end_at','asc')
                        ->paginate(config('global.no_of_records'));
        }

        return $goals;
    }
}
