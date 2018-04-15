<?php

namespace PacketPrep\Models\Course;

use Illuminate\Database\Eloquent\Model;
use Kalnoy\Nestedset\NodeTrait;
use Illuminate\Support\Facades\DB;

class Index extends Model
{
    use NodeTrait;

     protected $fillable = [
        'name',
        'slug',
        'type',
        // add all other fields
    ];
    public $timestamps = false;

}
