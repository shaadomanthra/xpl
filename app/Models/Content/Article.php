<?php

namespace PacketPrep\Models\Content;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'image',
        'description',
        'details',
        'keywords',
        'related',
        'math',
        'status'
    ];
}
