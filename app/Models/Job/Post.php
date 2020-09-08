<?php

namespace PacketPrep\Models\Job;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Post extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'title',
        'details',
        'education',
        'salary',
        'salary_num',
        'location',
        'academic',
        'last_date',
        'yop',
        'user_id',
        'viewer_id',
        'exam_ids',
        'status',
        'extra',
        'conditions'
        // add all other fields
    ];

    public function user(){
      return $this->belongsTo('PacketPrep\User');
    }

    public function viewer(){
      return $this->belongsTo('PacketPrep\User','viewer_id');
    }

    public function users()
    {
        return $this->belongsToMany('PacketPrep\User')->withPivot(['created_at','score','shortlisted']);
    }

    public function updateApplicant($post_id,$user_id,$score,$shortlisted){
        $entry = DB::table('post_user')->where('post_id', $post_id)->where('user_id',$user_id)
                ->update(['score' => $score,'shortlisted'=>$shortlisted]);
        echo $entry;
        exit();
    }
}
