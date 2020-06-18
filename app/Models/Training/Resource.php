<?php

namespace PacketPrep\Models\Training;

use Illuminate\Database\Eloquent\Model;

class Resource extends Model
{
    protected $fillable = [
        'name',
        'type',
        'link',
        'user_id',
        'schedule_id',
        'status',
        // add all other fields
    ];

    public function user(){
      return $this->belongsTo('PacketPrep\User');
    }

    public function schedule(){
      return $this->belongsTo('PacketPrep\Models\Training\Schedule');
    }

    
}
