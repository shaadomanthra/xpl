<?php

namespace PacketPrep\Models\Content;

use Illuminate\Database\Eloquent\Model;
use Kalnoy\Nestedset\NodeTrait;

class Chapter extends Model
{
    use NodeTrait;

     protected $fillable = [
        'title',
        'slug',
        'content',
        // add all other fields
    ];

    public static function getParent($item){
    	$result = Chapter::defaultOrder()->ancestorsOf($item->id);
    	//dd($result);
    	if(count($result)>0)
    	{
    		return $result[count($result)-1];
    	}
    	else
    		return null;

    }

    public static function displayUnorderedList($chapters,$options=null,$i=1){
    	$d = '';
    	foreach ($chapters as $chapter) {
    		$hasChildren = (count($chapter->children) > 0);

            $d = $d.'<li class="item" id="'.$chapter->id.'" ><a href="'.route('chapter.show', ['doc'=>$options['doc_slug'],'chapter'=>$chapter->slug]).'">'.$chapter->title.'</a></li>';

            if($hasChildren) {
                $d = $d.Chapter::displayUnorderedList($chapter->children,$options,$i+1);
            }
        }
        if($i==1)
        $d = '<ul class="list list-first" >'.$d.'</ul>';
    	else
    	$d = '<ul class="list" >'.$d.'</ul>';	
        return $d;
    }

    public static function displaySelectOption($chapters,$options=null,$prefix='&nbsp;',$disable=false){

	 	if($prefix=='&nbsp;')
	 	$d = '<option value="'.$options["root_id"].'">'. $options["root_title"].' (DEFAULT)</option>';	
	 	else
    	$d = '';
    	foreach ($chapters as $chapter) {
    		$hasChildren = (count($chapter->children) > 0);

    		$state = null;
    		if(isset($options['select_id']))
    		if($chapter->id == $options['select_id'])
    			$state = 'selected';

    		if(isset($options['disable_id']))
    		if($chapter->id == $options['disable_id'] || $disable){
    			$state = 'disabled';
    			$disable = true;
    		}

    		if(!$hasChildren)
			$d = $d.'<option value="'.$chapter->id.'" '.$state.'>'.$prefix.$chapter->title.'</option>';
    		else
            $d = $d.'<option value="'.$chapter->id.'" '.$state.'>'.$prefix.$chapter->title.'</option>';
			

            if($hasChildren) {
                $d = $d.Chapter::displaySelectOption($chapter->children,$options,$prefix.'&nbsp;&nbsp;&nbsp;',$disable);
            }

            if(isset($options['disable_id']))
            if($chapter->id == $options['disable_id'])
            	$disable = false;
        }
        return $d;
    }
}
