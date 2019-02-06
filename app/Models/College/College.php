<?php

namespace PacketPrep\Models\College;

use Illuminate\Database\Eloquent\Model;

class College extends Model
{
    protected $fillable = [
        'name',
        'image',
        'location',
        'type',
        'college_code',
        'principal_name',
        'college_phone',
        'college_email',
        'college_website',
        'tpo_name',
        'tpo_email',
        'tpo_email_2',
        'tpo_phone'
    ];

    public function ambassadors(){
        return $this->hasMany('PacketPrep\Models\College\Ambassador');
    }

    public function users(){
        return $this->belongsToMany('PacketPrep\User');
    }

    public function branches(){
        return $this->belongsToMany('PacketPrep\Models\College\Branch');
    }

    public function zones(){
        return $this->belongsToMany('PacketPrep\Models\College\Zone');
    }
}
