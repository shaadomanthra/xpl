<?php

namespace PacketPrep\Models\College;

use Illuminate\Database\Eloquent\Model;

class Batch extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'college_id',
        'code',
        'image'
        // add all other fields
    ];

    public function users(){
        return $this->belongsToMany('PacketPrep\User');
    }

    public function college(){
        return $this->hasOne('PacketPrep\Models\College\College');
    }
}
