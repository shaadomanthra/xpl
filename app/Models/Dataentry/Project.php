<?php

namespace PacketPrep\Models\Dataentry;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
     protected $fillable = [
        'name',
        'slug',
        'user_id_data_manager',
        'user_id_data_lead',
        'user_id_feeder',
        'user_id_proof_reader',
        'user_id_renovator',
        'user_id_validator',
        'target',
        'status',
        // add all other fields
    ];

    public function questions()
    {
        return $this->hasMany('PacketPrep\Models\Dataentry\Question');
    }

    public function getQuesCount($project_id){
        $details['drafts'] = Question::where('project_id',$project_id)->where('status',0)->count();
        $details['published'] = Question::where('project_id',$project_id)->where('status',1)->count();
        $details['live'] = Question::where('project_id',$project_id)->where('status',2)->count();
        $details['total'] = $details['drafts'] + $details['published'] + $details['live'];
        return $details['total'];
    }

    public function getAllQuestionsCount($projects){

        $count=0;
        foreach($projects as $project){
            $count = $count + count($project->questions);
        }
        return $count;
    }

    public static function getName($slug){
    	 $model = new Project;
    	 return $model->where('slug',$slug)->first()->name;
    }

    public static function get($slug){
        return (new Project)->where('slug',$slug)->first();
    }

    public static function getID($slug){
        return (new Project)->where('slug',$slug)->first()->id;
    }
}
