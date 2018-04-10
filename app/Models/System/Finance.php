<?php

namespace PacketPrep\Models\System;

use Illuminate\Database\Eloquent\Model;

class Finance extends Model
{
    protected $fillable = [
        'user_id',
        'year',
        'flow',
        'content',
        'amount',
        // add all other fields
    ];


    public function getRecords($start=null,$end=null){
    	if($start && $end)
    		return Finance::whereDate('transaction_at', '>=', date($start))
                    ->whereDate('transaction_at', '<', date($end))
                    ->orderBy('transaction_at','desc ')
                    ->paginate(config('global.no_of_records'));
        else
        	return Finance::orderBy('transaction_at','desc ')
                    ->paginate(config('global.no_of_records'));
                    
    }

    public function cash($type,$start=null,$end=null){
    	
    	if($type=='IN')
    		$type=0;
    	else
    		$type=1;

    	if($start && $end)
    		return Finance::whereDate('transaction_at', '>=', date($start))
                    ->whereDate('transaction_at', '<', date($end))
                    ->where('flow',$type)->sum('amount');
        else
        	return Finance::where('flow',$type)->sum('amount');

    }


}
