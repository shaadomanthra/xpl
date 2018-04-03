<?php

namespace PacketPrep\Models\Library;

use Illuminate\Database\Eloquent\Model;
use Kalnoy\Nestedset\NodeTrait;
use Illuminate\Support\Facades\DB;

class Structure extends Model
{
    use NodeTrait;

     protected $fillable = [
        'name',
        'slug',
        'type',
        'parent_id',
        // add all other fields
    ];
    public $timestamps = false;

        public static function getParent($struct){
    	$result = Structure::defaultOrder()->ancestorsOf($struct->id);
    	//dd($result);
    	if(count($result)>0)
    	{
    		return $result[count($result)-1];
    	}
    	else
    		return null;

    }



    public static function displayUnorderedList($structures,$options=null,$i=1){

        
    	$d = '';
    	foreach ($structures as $struct) {
    		$hasChildren = (count($struct->children) > 0);

            $d = $d.'<li class="item" id="'.$struct->id.'" ><a href="'.route('structure.show',
            	[	
            		'structure'=> $struct->slug,
            		'repo'=> $options['repo']->slug,
            	]

            ).'">'.$struct->name.'</a>'.
            '<a href="'.route('structure.question',[$options['repo']->slug,$struct->slug,''])
            .'"><span class="float-right">Questions('.count($struct->questions).')</span></a></li>';

            if($hasChildren) {
                $d = $d.Structure::displayUnorderedList($struct->children,$options,$i+1);
            }
        }
        if($i==1){
            $total_ques = Question::getTotalQuestionCount($options['repo']);
            $categorized_ques = Structure::getCategorizedQuestionCount($options['repo']);
            $d = '<ul class="list list-first" >'.$d.'<li>Uncategorized <a href="'.route('structure.question',[$options['repo']->slug,'uncategorized',''])
            .'"><span class="float-right">Questions('.($total_ques-$categorized_ques).')</span></a></li></ul>';
        }
    	else
    	$d = '<ul class="list" >'.$d.'</ul>';	
        return $d;
    }


    public static function getCategorizedQuestionCount($repo){
        $parent =  Structure::where('slug',$repo->slug)->first();   
        $struct_id_list = Structure::defaultOrder()->descendantsOf($parent->id)->pluck('id')->toArray();
        return ( DB::table('Structure_question')->whereIn('Structure_id', $struct_id_list)->distinct()->get(['question_id'])->count());
        
    }

    public static function getUncategorizedQuestions($repo){
        $parent =  Structure::where('slug',$repo->slug)->first();   
        $struct_id_list = Structure::defaultOrder()->descendantsOf($parent->id)->pluck('id')->toArray();
        $question_id_list = DB::table('Structure_question')->whereIn('Structure_id', $struct_id_list)->pluck('question_id')->toArray();

        $questions = Question::where('repo_id',$repo->id)->whereNotIn('id',$question_id_list)->get();
        return $questions;
    }


    public static function displayUnorderedCheckList($structures,$options=null,$i=1){

        $d = '';
        foreach ($structures as $struct) {
            $hasChildren = (count($struct->children) > 0);

            $state = null;
            if(isset($options['Structure_id']))
            if(in_array($struct->id , $options['Structure_id']))
                $state = 'checked';

            $d = $d.'<li class="item" id="'.$struct->id.'" >
            <input  type="checkbox" name="Structure[]" value="'.$struct->id.'"  '.$state.'> '
            .$struct->name.'</li>';

            if($hasChildren) {
                $d = $d.Structure::displayUnorderedCheckList($struct->children,$options,$i+1);
            }
        }
        if($i==1)
        $d = '<ul class="list list-first" >'.$d.'</ul>';
        else
        $d = '<ul class="list" >'.$d.'</ul>';   
        return $d;
    }


	 public static function displaySelectOption($structures,$options=null,$prefix='&nbsp;',$disable=false){
/*
	 	if($prefix=='&nbsp;')
	 	$d = '<option value="0">FIRST LEVEL ROOT (DEFAULT)</option>';	
	 	else
    	$d = '';*/
        $d='';
    	foreach ($structures as $struct) {
    		$hasChildren = (count($struct->children) > 0);

    		$state = null;
    		if($struct->id == $options['select_id'])
    			$state = 'selected';

    		if($struct->id == $options['disable_id'] || $disable){
    			$state = 'disabled';
    			$disable = true;
    		}

    		if(!$hasChildren)
			$d = $d.'<option value="'.$struct->id.'" '.$state.'>'.$prefix.$struct->name.'</option>';
    		else
            $d = $d.'<option value="'.$struct->id.'" '.$state.'>'.$prefix.$struct->name.'</option>';
			

            if($hasChildren) {
                $d = $d.Structure::displaySelectOption($struct->children,$options,$prefix.'&nbsp;&nbsp;&nbsp;',$disable);
            }
            if($struct->id == $options['disable_id'])
            	$disable = false;
        }
        return $d;
    }
}
