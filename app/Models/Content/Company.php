<?php

namespace PacketPrep\Models\Content;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'image',
        'description',
        'details',
        'keywords',
        'status'
        
        // add all other fields
    ];
}

