<?php

namespace PacketPrep\Models\System;

use Illuminate\Database\Eloquent\Model;

class Update extends Model
{
    protected $fillable = [
        'user_id',
        'type',
        'content',
        'status',
        // add all other fields
    ];

    public function user(){
    	return $this->belongsTo('PacketPrep\User');
    }

    public function getUpdates(){
    	$request = request();
    	$update = new Update();
    	$type = [1,2];
        $status = [1,0];
        if($request->get('all'))
            $type = [1,2];
        if($request->get('feed'))
            $type = [1];
        if($request->get('milestone'))
            $type = [2];
        if($request->get('published')){
            $status = [1];
        }
        if($request->get('draft')){
            $status = [0];
        }

        if(\Auth::guest())
            return redirect('login');
        if(\Auth::user()->checkRole(['administrator','manager'])){
            if(\Auth::user()->checkRole(['administrator'])){

                $updates = $update
                        ->whereIn('type',$type)
                        ->whereIn('status',$status)
                        ->orderBy('created_at','desc ')
                        ->paginate(config('global.no_of_records'));
                
            }
            else{

                if($request->get('draft') || $request->get('published')){
                    $updates = $update
                        ->whereIn('type',$type)
                        ->where([
                            ['status', $status],
                            ['user_id', '=', \auth::user()->id],
                            ])
                        ->orderBy('created_at','desc ')
                        ->paginate(config('global.no_of_records'));
                }elseif($request->get('milestone') || $request->get('feed')){
                    $updates = $update->where('status',1)
                        ->whereIn('type',$type)
                        ->OrWhere([
                            ['status', 0],
                            ['user_id', '=', \auth::user()->id],
                            ['type',$type]
                            ])
                        ->orderBy('created_at','desc ')
                        ->paginate(config('global.no_of_records'));

                }else{
                     $updates = $update->where('status',1)
                        ->whereIn('type',$type)
                        ->OrWhere([
                            ['status', 0],
                            ['user_id', '=', \auth::user()->id],
                            ])
                        ->orderBy('created_at','desc ')
                        ->paginate(config('global.no_of_records'));

                }


            }
            
                    
        }else{
            $updates = $update->where('status',1)
                        ->whereIn('type',$type)
                        ->orderBy('created_at','desc ')
                        ->paginate(config('global.no_of_records'));
        }

        return $updates;
    }
}
