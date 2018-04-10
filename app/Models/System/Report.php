<?php

namespace PacketPrep\Models\System;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    protected $fillable = [
        'user_id',
        'type',
        'content',
    ];

     public function user(){
    	return $this->belongsTo('PacketPrep\User');
    }

    public function getReports(){
    	$request = request();
    	$report = new Report();

        $type = [0,1,2];
        if($request->get('all'))
            $type = [0,1,2];
        if($request->get('day'))
            $type = [0];
        if($request->get('week'))
            $type = [1];
        if($request->get('month'))
            $type = [2];
        

        if(\Auth::guest()){
            return redirect('login');          
        }else{
             $reports = $report
                        ->whereIn('type',$type)
                        ->orderBy('created_at','desc')
                        ->paginate(config('global.no_of_records'));
        }

        return $reports;
    }
}
