<?php

namespace PacketPrep\Models\Training;

use Illuminate\Database\Eloquent\Model;

class Training extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'details',
        'user_id',
        'trainer_id',
        'tpo_id',
        'sessions',
        'start_date',
        'due_date',
        'status',
        // add all other fields
    ];

    public function user(){
      return $this->belongsTo('PacketPrep\User');
    }

    public function trainer(){
      return $this->belongsTo('PacketPrep\User','trainer_id');
    }

    public function tpo(){
      return $this->belongsTo('PacketPrep\User','tpo_id');
    }

    public function users()
    {
        return $this->belongsToMany('PacketPrep\User');
    }

    public function schedules()
    {
        return $this->hasMany('PacketPrep\Models\Training\Schedule');
    }

    public function progress(){
        $schedules = $this->schedules;
        $count =0;
        foreach($schedules as $s){
            if($s->users->count())
                $count++;
        }
        return $count;
    }

    public function progress_percent(){
        $schedules = $this->schedules;
        $count =0;
        foreach($schedules as $s){
            if($s->users->count())
                $count++;
        }
        $sessions = $this->sessions;
        if(!$sessions)
            return 0;
        $percent = round((($count/$sessions) * 100),1);
        return $percent;
    }

    public function progress_message(){
        $start_date  = \carbon\carbon::parse($this->start_date);
        $due_date  = \carbon\carbon::parse($this->due_date);

        if($start_date->gt(\carbon\carbon::now())){
            $message = 'Upcoming';
        }elseif($start_date->lt(\carbon\carbon::now()) && $due_date->gt(\carbon\carbon::now())){
            $message = 'In Progress';
        }else{
            if($this->progress_percent>100){
                $message = 'Completed';
            }else{
                $message = 'Delayed';
            }
        }

        return $message;
    }

     public function progress_color(){
        $start_date  = \carbon\carbon::parse($this->start_date);
        $due_date  = \carbon\carbon::parse($this->due_date);

        if($start_date->gt(\carbon\carbon::now())){
            $color = 'warning';
        }elseif($start_date->lt(\carbon\carbon::now()) && $due_date->gt(\carbon\carbon::now())){
            $color = 'success';
        }else{
            if($this->progress_percent>100){
                $color = 'primary';
            }else{
                $color = 'danger';
            }
        }

        return $color;
    }

    public function username($email){
        $parts = explode("@", $email);
        $username = $parts[0];
        return $username;
    }
}
