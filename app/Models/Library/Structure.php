<?php

namespace PacketPrep\Models\Library;

use Illuminate\Database\Eloquent\Model;
use Kalnoy\Nestedset\NodeTrait;
use Illuminate\Support\Facades\DB;
use PacketPrep\Models\Library\Lquestion as Question;

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

    
    public function versions()
    {
        return $this->hasMany('PacketPrep\Models\Library\Version');
    }

    public function videos()
    {
        return $this->hasMany('PacketPrep\Models\Library\Video');
    }

    public function documents()
    {
        return $this->hasMany('PacketPrep\Models\Library\Document');
    }

     public function questions()
    {
        return $this->belongsToMany('PacketPrep\Models\Library\Lquestion');
    }

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

            $counter ='';
            if($struct->type=='variant')
                $counter =  ' <span class="s10 text-secondary">Variant</span> <a href="'.route('lquestion.show',[$options['repo']->slug,$struct->slug,'']).'"><span class="float-right"> <i class="fa fa-comments"></i> Questions('.count($struct->questions).')</span></a>';
            if($struct->type == 'concept')
                $counter = ' <span class="s10 text-secondary">Concept</span> <a href="'.route('lquestion.show',[$options['repo']->slug,$struct->slug,'']).'"><span class="float-right">  <i class="fa fa-file-text"></i> Versions('.count($struct->versions).')</span></a>';
            if($struct->type == 'topic')
                $counter = ' <span class="s10 text-secondary">Topic</span> <a href="'.route('lquestion.show',[$options['repo']->slug,$struct->slug,'']).'"><span class="float-right">  <i class="fa fa-youtube-play"></i> Videos('.count($struct->videos).')</span></a>';
            if($struct->type == 'subtopic')
                $counter = ' <span class="s10 text-secondary">Sub Topic</span> <a href="'.route('lquestion.show',[$options['repo']->slug,$struct->slug,'']).'"><span class="float-right">  <i class="fa fa-youtube-play"></i> Videos('.count($struct->videos).')</span></a>';
            if($struct->type == 'chapter')
                $counter = ' <span class="s10 text-secondary">Chapter</span> <a href="'.route('lquestion.show',[$options['repo']->slug,$struct->slug,'']).'"><span class="float-right">  <i class="fa fa-file-pdf-o"></i> Documents('.count($struct->documents).')</span></a>';


            $d = $d.'<li class="item" id="'.$struct->id.'" ><a href="'.route('structure.show',[$options['repo']->slug,$struct->slug,]).'">'.$struct->name.'</a>'.$counter.'</li>';

            if($hasChildren) {
                $d = $d.Structure::displayUnorderedList($struct->children,$options,$i+1);
            }
        }
        if($i==1){
            $total_ques = Question::getTotalQuestionCount($options['repo']);
            $categorized_ques = Structure::getCategorizedQuestionCount($options['repo']);
            $d = '<ul class="list list-first" >'.$d.'<li>Uncategorized <a href="'.route('question.show',[$options['repo']->slug,'uncategorized',''])
            .'"><span class="float-right">Questions('.($total_ques-$categorized_ques).')</span></a></li></ul>';
        }
    	else
    	$d = '<ul class="list" >'.$d.'</ul>';	
        return $d;
    }


    public static function getCategorizedQuestionCount($repo){
        $parent =  Structure::where('slug',$repo->slug)->first();   
        $struct_id_list = Structure::defaultOrder()->descendantsOf($parent->id)->pluck('id')->toArray();
        return ( DB::table('lquestion_structure')->whereIn('structure_id', $struct_id_list)->distinct()->get(['lquestion_id'])->count());
        
    }

    public static function getUncategorizedQuestions($repo){
        $parent =  Structure::where('slug',$repo->slug)->first();   
        $struct_id_list = Structure::defaultOrder()->descendantsOf($parent->id)->pluck('id')->toArray();
        $question_id_list = DB::table('lquestion_structure')->whereIn('structure_id', $struct_id_list)->pluck('lquestion_id')->toArray();

        $questions = Question::where('repo_id',$repo->id)->whereNotIn('id',$question_id_list)->get();
        return $questions;
    }


    public static function displayUnorderedCheckList($structures,$options=null,$i=1){

        $d = '';
        foreach ($structures as $struct) {
            $hasChildren = (count($struct->children) > 0);

            $state = null;
            if(isset($options['structure_id']))
            if(in_array($struct->id , $options['structure_id']))
                $state = 'checked';

            $color = '';
            if(isset($options['type']))
                if($struct->type != 'variant'){
                    $state = 'disabled';
                }

            if($state == 'disabled'){
                $d = $d.'<li class="item " id="'.$struct->id.'" >'
                .$struct->name.'</li>';
            }else{
                $d = $d.'<li class="item" id="'.$struct->id.'" >
                 <input  type="checkbox" name="structure[]" value="'.$struct->id.'"  '.$state.'> '
                .$struct->name.'</li>';
            }
            

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

            $item = null;
    		$state = null;
            if(isset($options['select_id']))
    		if($struct->id == $options['select_id'])
    			$state = 'selected';
            if(isset($options['disable_id']))
    		if($struct->id == $options['disable_id'] || $disable){
    			$state = 'disabled';
    			$disable = true;
    		}

            if($options['type']=='chapter'){
                $item = 'chapter';
                if($struct->type !='subject')
                    $state = 'disabled';
            }

            if($options['type']=='topic'){
                $item = 'topic';
                if($struct->type !='chapter')
                    $state = 'disabled';
            }

            if($options['type']=='subtopic'){
                $item = 'subtopic';
                if($struct->type !='topic')
                    $state = 'disabled';
            }

            if($options['type']=='concept'){
                $item = 'concept';
                if($struct->type !='subtopic')
                    $state = 'disabled';
            }

            if($options['type']=='variant'){
                $item = 'variant';
                if($struct->type !='concept')
                    $state = 'disabled';
            }

    		if(!$hasChildren)
			$d = $d.'<option value="'.$struct->id.'" '.$state.'>'.$prefix.$struct->name.'</option>';
    		else
            $d = $d.'<option value="'.$struct->id.'" '.$state.'>'.$prefix.$struct->name.'</option>';
			

            if($hasChildren) {
                $d = $d.Structure::displaySelectOption($struct->children,$options,$prefix.'&nbsp;&nbsp;&nbsp;',$disable);
            }
            if(isset($options['disable_id']))
            if($struct->id == $options['disable_id'])
            	$disable = false;
        }
        return $d;
    }
}
