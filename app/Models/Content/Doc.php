<?php

namespace PacketPrep\Models\Content;

use Illuminate\Database\Eloquent\Model;

class Doc extends Model
{
    
    protected $fillable = [
        'name',
        'slug',
        'image',
        'description',
        'keywords'
        // add all other fields
    ];
    
}
