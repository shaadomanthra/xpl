<?php

namespace PacketPrep\Models\Content;

use Illuminate\Database\Eloquent\Model;

class Doc extends Model
{
    
    protected $fillable = [
        'name',
        'slug',
        // add all other fields
    ];
    
}
