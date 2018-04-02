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
}
