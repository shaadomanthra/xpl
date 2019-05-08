<?php

namespace PacketPrep\Models\Exam;

use Illuminate\Database\Eloquent\Model;
use PacketPrep\Models\Product\Test;


class Exam extends Model
{
	protected $fillable = [
        'name',
        'slug',
        'user_id',
        'description',
        'instructions',
        'status',
        'examtype_id',
        'course_id'
        // add all other fields
    ];
    
    public function sections()
    {
        return $this->hasMany('PacketPrep\Models\Exam\Section');
    }

    public function products()
    {
        return $this->belongsToMany('PacketPrep\Models\Product\Product');
    }

    public function examtype()
    {
        return $this->belongsTo('PacketPrep\Models\Exam\Examtype');
    }

    public function course()
    {
        return $this->belongsTo('PacketPrep\Models\Course\Course');
    }

    public function question_count()
    {
        $exam = $this;$count =0;
        if(count($exam->sections)!=0){
            foreach($exam->sections as $section){
                $count = $count + count($section->questions);   
            }
            return $count;
        }else
            return null;

    }

    public function getProductSlug(){

        $p = $this->products->first();
        if($p)
            return $p->slug;
        else
            return 0;
    }

    public function time()
    {
        $exam = $this;$count =0;
        if(count($exam->sections)!=0){
            foreach($exam->sections as $section){
                $count = $count + $section->time;   
            }
            return $count;
        }else
            return null;

    }

    public function attempted()
    {
        if(!\auth::user())
            return false;

        $test = Test::where('test_id',$this->id)->where('user_id',\auth::user()->id)->first();

        if($test){
            return true;
        }else
            return false;

    }

}
