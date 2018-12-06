<?php

namespace PacketPrep\Models\Content;

use Illuminate\Database\Eloquent\Model;

class Doc extends Model
{
    
    protected $fillable = [
        'name',
        'slug',
        'image',
        // add all other fields
    ];
    
}
