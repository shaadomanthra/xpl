<?php

namespace PacketPrep\Models\Content;

use Illuminate\Database\Eloquent\Model;

class Label extends Model
{
     protected $fillable = [
     	'label',
        'name',
        'slug',
        'image',
        'description',
        'keywords',
        'status'
    ];

    public function articles()
    {
        return $this->belongsToMany('PacketPrep\Models\Content\Article');
    }
}
