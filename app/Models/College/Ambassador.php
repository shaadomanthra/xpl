<?php

namespace PacketPrep\Models\College;

use Illuminate\Database\Eloquent\Model;

class Ambassador extends Model
{
    protected $fillable = [
        'user_id',
        'uid',
        'mode'
        // add all other fields
    ];

    public function users(){
        return $this->belongsTo('PacketPrep\User');
    }

    public function others(){
        return $this->belongsTo('PacketPrep\User','id','uid');
    }

    public function colleges(){
        return $this->belongsTo('PacketPrep\Models\College\Ambassador');
    }
}
