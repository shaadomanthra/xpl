<?php

namespace PacketPrep\Models\Job;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $fillable = [
        'name',
        'image',
        'description',
        'website',
        'status'
        // add all other fields
    ];
}
