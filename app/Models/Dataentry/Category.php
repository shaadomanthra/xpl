<?php

namespace PacketPrep\Models\Dataentry;

use Illuminate\Database\Eloquent\Model;
use Kalnoy\Nestedset\NodeTrait;
use PacketPrep\Models\Dataentry\Question;
use Illuminate\Support\Facades\DB;

class Category extends Model
{
    use NodeTrait;

     protected $fillable = [
        'name',
        'slug',
        'parent_id',
        // add all other fields
    ];
    public $timestamps = false;

   
    public function questions()
    {
        return $this->belongsToMany('PacketPrep\Models\Dataentry\Question');
    }

    public static function getParent($category){
    	$result = Category::defaultOrder()->ancestorsOf($category->id);
    	//dd($result);
    	if(count($result)>0)
    	{
    		return $result[count($result)-1];
    	}
    	else
    		return null;

    }



    public static function displayUnorderedList($categories,$options=null,$i=1){

        
    	$d = '';
    	foreach ($categories as $category) {
    		$hasChildren = (count($category->children) > 0);

            $d = $d.'<li class="item" id="'.$category->id.'" ><a href="'.route('category.show',
            	[	
            		'category'=> $category->slug,
            		'project'=> $options['project']->slug,
            	]

            ).'">'.$category->name.'</a>'.
            '<a href="'.route('category.question',[$options['project']->slug,$category->slug,''])
            .'"><span class="float-right">Questions('.count($category->questions).')</span></a></li>';

            if($hasChildren) {
                $d = $d.Category::displayUnorderedList($category->children,$options,$i+1);
            }
        }
        if($i==1){
            $total_ques = Question::getTotalQuestionCount($options['project']);
            $categorized_ques = Category::getCategorizedQuestionCount($options['project']);
            $d = '<ul class="list list-first" >'.$d.'<li>Uncategorized <a href="'.route('category.question',[$options['project']->slug,'uncategorized',''])
            .'"><span class="float-right">Questions('.($total_ques-$categorized_ques).')</span></a></li></ul>';
        }
    	else
    	$d = '<ul class="list" >'.$d.'</ul>';	
        return $d;
    }


    public static function getCategorizedQuestionCount($project){
        $parent =  Category::where('slug',$project->slug)->first();   
        $category_id_list = Category::defaultOrder()->descendantsOf($parent->id)->pluck('id')->toArray();
        return ( DB::table('category_question')->whereIn('category_id', $category_id_list)->distinct()->get(['question_id'])->count());
        
    }

    public static function getUncategorizedQuestions($project){
        $parent =  Category::where('slug',$project->slug)->first();   
        $category_id_list = Category::defaultOrder()->descendantsOf($parent->id)->pluck('id')->toArray();
        $question_id_list = DB::table('category_question')->whereIn('category_id', $category_id_list)->pluck('question_id')->toArray();

        $questions = Question::where('project_id',$project->id)->whereNotIn('id',$question_id_list)->get();
        return $questions;
    }


    public static function displayUnorderedCheckList($categories,$options=null,$i=1){

        $d = '';
        foreach ($categories as $category) {
            $hasChildren = (count($category->children) > 0);

            $state = null;
            if(isset($options['category_id']))
            if(in_array($category->id , $options['category_id']))
                $state = 'checked';

            $d = $d.'<li class="item" id="'.$category->id.'" >
            <input  type="checkbox" name="category[]" value="'.$category->id.'"  '.$state.'> '
            .$category->name.'</li>';

            if($hasChildren) {
                $d = $d.Category::displayUnorderedCheckList($category->children,$options,$i+1);
            }
        }
        if($i==1)
        $d = '<ul class="list list-first" >'.$d.'</ul>';
        else
        $d = '<ul class="list" >'.$d.'</ul>';   
        return $d;
    }


	 public static function displaySelectOption($categories,$options=null,$prefix='&nbsp;',$disable=false){
/*
	 	if($prefix=='&nbsp;')
	 	$d = '<option value="0">FIRST LEVEL ROOT (DEFAULT)</option>';	
	 	else
    	$d = '';*/
        $d='';
    	foreach ($categories as $category) {
    		$hasChildren = (count($category->children) > 0);

    		$state = null;
    		if($category->id == $options['select_id'])
    			$state = 'selected';

    		if($category->id == $options['disable_id'] || $disable){
    			$state = 'disabled';
    			$disable = true;
    		}

    		if(!$hasChildren)
			$d = $d.'<option value="'.$category->id.'" '.$state.'>'.$prefix.$category->name.'</option>';
    		else
            $d = $d.'<option value="'.$category->id.'" '.$state.'>'.$prefix.$category->name.'</option>';
			

            if($hasChildren) {
                $d = $d.Category::displaySelectOption($category->children,$options,$prefix.'&nbsp;&nbsp;&nbsp;',$disable);
            }
            if($category->id == $options['disable_id'])
            	$disable = false;
        }
        return $d;
    }

}
