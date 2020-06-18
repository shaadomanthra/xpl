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
        'status',
        // add all other fields
    ];

    public function user(){
      return $this->belongsTo('PacketPrep\User');
    }

    public function trainer(){
      return $this->belongsTo('PacketPrep\User','trainer_id');
    }

    public function users()
    {
        return $this->belongsToMany('PacketPrep\User');
    }

    public function schedules()
    {
        return $this->hasMany('PacketPrep\Models\Training\Schedule');
    }
}
