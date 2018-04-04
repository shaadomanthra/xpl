<?php

namespace PacketPrep\Models\Library;

use Illuminate\Database\Eloquent\Model;
use PacketPrep\Models\Library\Repository;
use PacketPrep\Models\Library\Lquestion as Question;

class Lquestion extends Model
{
     protected $fillable = [
        'reference',
        'slug',
        'type',
        'question',
        'a',
        'b',
        'c',
        'd',
        'e',
        'answer',
        'explanation',
        'dynamic',
        'passage_id',
        'user_id',
        'repository_id',
        'stage',
        'status',
        // add all other fields
    ];

    public function user(){
        return $this->belongsTo('PacketPrep\User');
    }

    public function  structures()
    {
        return $this->belongsToMany('PacketPrep\Models\Library\Structure');
    }

    public function tags()
    {
        return $this->belongsToMany('PacketPrep\Models\Library\Ltag');
    }


    public static function getTotalQuestionCount($repo){
            return Question::where('repository_id',$repo->id)->count();
    }
}
