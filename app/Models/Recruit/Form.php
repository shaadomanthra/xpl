<?php

namespace PacketPrep\Models\Recruit;

use Illuminate\Database\Eloquent\Model;

class Form extends Model
{
    protected $fillable = [
        'job_id',
        'user_id',
        'name',
        'dob',
        'email',
        'phone',
        'address',
        'education',
        'experience',
        'why',
        'status',
        'reason',
        // add all other fields
    ];

    public function job()
    {
        return $this->belongsTo('PacketPrep\Models\Recruit\Job');
    }

    public function user()
    {
        return $this->belongsTo('PacketPrep\User');
    }


    public function getForms(){
        $request = request();
        $search = $request->search;
        $item = $request->item;

        $form = new Form();


        $job = 0;
        if($request->get('job'))
            $job = $request->get('job');

        $status = [0,1,2];
        if($request->get('all'))
            $status = [0,1,2];
        if($request->get('open'))
            $status = [0];
        if($request->get('accepted'))
            $status = [1];
        if($request->get('rejected'))
            $status = [2];
        

        if(\Auth::guest()){
            return redirect('login');          
        }else{

            if($job)
             $forms = $form->where('name','LIKE',"%{$item}%")
                        ->where('job_id',$job)
                        ->whereIn('status',$status)
                        ->orderBy('created_at','desc')
                        ->paginate(config('global.no_of_records'));
            else
             $forms = $form->where('name','LIKE',"%{$item}%")
                        ->whereIn('status',$status)
                        ->orderBy('created_at','desc')
                        ->paginate(config('global.no_of_records')); 

        }

        return $forms;
    }

    public static function getCount(){

        $count = ['open'=>0,'accepted'=>0,'rejected'=>0,'all'=>0];
        $forms = Form::orderBy('created_at','desc')->get(); 

        foreach($forms as $form)
        {
            if($form->status ==0)
                $count['open']++;
            if($form->status == 1)
                $count['accepted']++;
            if($form->status==2)
                $count['rejected']++;

            $count['all']++;

        }

        return $count;
    }
}
