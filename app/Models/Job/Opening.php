<?php

namespace PacketPrep\Models\Job;

use Illuminate\Database\Eloquent\Model;

class Opening extends Model
{
    protected $fillable = [
        'name',
        'stream_id',
        'company_id',
        'location_id',
        'title',
        'position',
        'salary',
        'vacancies',
        'eligibility',
        'description',
        'last_date',
        'link'
        // add all other fields
    ];

}
