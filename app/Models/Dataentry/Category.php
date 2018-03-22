<?php

namespace PacketPrep\Models\Dataentry;

use Illuminate\Database\Eloquent\Model;
use Kalnoy\Nestedset\NodeTrait;

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
            		'project'=> $options['project_slug'],
            	]

            ).'">'.$category->name.'</a></li>';

            if($hasChildren) {
                $d = $d.Category::displayUnorderedList($category->children,$options,$i+1);
            }
        }
        if($i==1)
        $d = '<ul class="list list-first" >'.$d.'<li>Uncategorized</li></ul>';
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
