<?php

namespace PacketPrep\Models\Training;

use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
     protected $fillable = [
     	'sno',
        'name',
        'day',
        'details',
        'user_id',
        'training_id',
        'meeting_link',
        'status',
        // add all other fields
    ];

    public function user(){
      return $this->belongsTo('PacketPrep\User');
    }

    public function training(){
      return $this->belongsTo('PacketPrep\Models\Training\Training');
    }

    public function users()
    {
        return $this->belongsToMany('PacketPrep\User');
    }

    public function resources()
    {
        return $this->hasMany('PacketPrep\Models\Training\Resource');
    }

    public function present_ids(){
        return implode(',',$this->users->pluck('id')->toArray());
    }

    public function present($training,$percent=null){
        $total = $training->users->count();
        if(!$total)
            return 0;
        if($percent){
            return ($this->users->count()/$total*100);
        }else{
            return $this->users->count();
        }
    }

    public function absent($training,$percent=null){
        $total = $training->users->count();
        if(!$total)
            return 0;
        if(!$this->users->count())
            return 0;
        if($percent){
            return (($total -$this->users->count())/$total*100);
        }else{
            return ($total -$this->users->count());
        }
    }
}
