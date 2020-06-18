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
}
