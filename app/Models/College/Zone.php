<?php

namespace PacketPrep\Models\College;

use Illuminate\Database\Eloquent\Model;

class Zone extends Model
{
    protected $fillable = [
        'name',
        // add all other fields
    ];


    public function colleges(){
        return $this->belongsToMany('PacketPrep\Models\College\College');
    }

    public function users(){
        return $this->belongsToMany('PacketPrep\User');
    }


}
