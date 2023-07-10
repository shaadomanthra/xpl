<?php

namespace PacketPrep\Models\Dataentry;

use Illuminate\Database\Eloquent\Model;
use Kalnoy\Nestedset\NodeTrait;
use PacketPrep\Models\Dataentry\Question;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;

class Category extends Model
{
    use NodeTrait;

     protected $fillable = [
        'name',
        'slug',
        'parent_id',
        'video_link',
        'video_keywords',
        'video_',
        'pdf_link',
        'category_id',
        // add all other fields
    ];
    public $timestamps = false;

   
   public function exam()
    {
        return $this->belongsTo('PacketPrep\Models\Exam\Exam');
    }

    public function questions()
    {
        return $this->belongsToMany('PacketPrep\Models\Dataentry\Question')->withPivot('intest');;
    }

    public static function category_tag_questions($category,$exam)
    {   

        if($exam && $exam!='all'){
            $ques_category = DB::table('category_question')->where('category_id', $category->id)->distinct()->get(['question_id'])->pluck('question_id')->toArray();
        $tag = Tag::where('value',$exam)->first();
        if($tag)
        $ques_tag = DB::table('question_tag')->where('tag_id', $tag->id)->distinct()->get(['question_id'])->pluck('question_id')->toArray();
        else
            $ques_tag =0;

        $list = array_intersect($ques_tag, $ques_category);
            return $list;
        }else{
            $ques = Cache::remember('category_ques_'.$category->slug,60,function() use($category){
                return $category->questions()->wherePivot('intest','!=',1)->pluck('id')->toArray();
            });

            return $ques;
        }
        
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


    public static function displayUnorderedListCourse($categories,$options=null,$i=1,$last=null){

        
        $d = '';
        $j=1;
        foreach ($categories as $category) {
            $hasChildren = (count($category->children) > 0);

            if($category->parent_id == $options['parent']->id){
                $d = $d.'<li class="item title-list" id="'.$category->slug.'" > <span class="bg-light p-1 pr-3 pl-3 border rounded">'.$j.'</span> &nbsp;'.$category->name;
                if($category->video_desc)
                $d = $d.'<div class="pt-3 title-normal">'.$category->video_desc.'</div>';
                $d= $d.'</li>';
            }else{

                if($category->video_link){

                    if(!youtube_video_exists($category->video_link)){
                        $icon = '<i class="fa fa-lock"></i>';
                    }else
                     $icon = '<i class="fa fa-circle-o" aria-hidden="true"></i>';
                     
               $d = $d.'<li class="item" id="'.$category->slug.'" >
               <a href="'.route('course.category.video',
                [   
                    'course'=> $options['project']->slug,
                    'category'=> $category->slug,
                    
                ]

                ).'">'.$icon.' '.$category->name.'</a>&nbsp';


                   if(count($category->category_tag_questions($category,session('exam')))!=0)
                    $d = $d.
                        '<a href="'.route('course.question',[$options['project']->slug,$category->slug,''])
                        .'"><span class="badge badge-warning"> Practice '.count(Category::category_tag_questions($category,session('exam'))).'Q</span></a> '; 
                    

                if($category->video_desc)
                $d = $d.'<div class="pt-3 title-normal">'.$category->video_desc.'</div>';
                else
                    $d = $d.'</li>';

               }elseif($category->pdf_link){
                    $icon = '<i class="fa fa-file-pdf-o"></i>';
                    $d = $d.'<li class="item item-pdf" id="'.$category->slug.'"  >
               <a href="'.route('course.category.video',
                [   
                    'course'=> $options['project']->slug,
                    'category'=> $category->slug,
                    
                ]

                ).'">'.$icon.' '.$category->name.'</a>&nbsp';
               }elseif($category->test_link){
                    $icon = '<i class="fa fa-external-link"></i>';
                    $d = $d.'<li class="item " id="'.$category->slug.'"  >
               <a href="'.route('course.category.video',
                [   
                    'course'=> $options['project']->slug,
                    'category'=> $category->slug,
                    
                ]

                ).'">'.$icon.' '.$category->name.'</a>&nbsp';
               }
               else{
                    $d = $d;

               }
                


               

            }
            
            $j++;

            if($hasChildren) {
                $d = $d.Category::displayUnorderedListCourse($category->children,$options,$i+1,$last=$j);
            }
        }
        if($i==1){
            //$total_ques = Question::getTotalQuestionCount($options['project']);
            //$categorized_ques = Category::getCategorizedQuestionCount($options['project']);
            $d = '<ul class="list2 list2-first" >'.$d.'</ul>';
        }
        else
        $d = '<ul class="list2 " >'.$d.'</ul>';   
        return $d;
    }

       public static function QuestionCounter($categories,$options=null,$i=1,$count=null){

        

        $d = '';
        $j=1;
        $sum = 0;
        foreach ($categories as $category) {
            $hasChildren = (count($category->children) > 0);

            if($category->parent_id == $options['parent']->id){
                $count = $count;
            }else{

            if(count($category->category_tag_questions($category,session('exam')))!=0)
            $count = $count + count($category->category_tag_questions($category,session('exam')));
            //echo $count."<br>";
            }
            
            $j++;

            if($hasChildren) {
                $count =  Category::QuestionCounter($category->children,$options,$i+1,$count);
            }
        } 

        
        return $count;
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

        if (request()->session()->has('exam') && session('exam') != 'all') 
        {
            $exam = session('exam');
            $tag = Tag::where('value',$exam)->where('project_id',$project->id)->first();
            if($tag)
                return count($tag->questions);
            else
                return null;
        }else{
            $parent =  Category::where('slug',$project->slug)->first();   
            $category_id_list = Category::defaultOrder()->descendantsOf($parent->id)->pluck('id')->toArray();
            return ( DB::table('category_question')->whereIn('category_id', $category_id_list)->distinct()->get(['question_id'])->count());
        }
        
        
    }


    public static function QuestionCount_level2($project){

        $parent =  Category::where('slug',$project->slug)->first(); 

            
        if (request()->session()->has('exam') && session('exam') != 'all') 
        {
            $exam = session('exam');
            $tag = Tag::where('value',$exam)->where('project_id',$project->id)->first();
            if($tag)
                return count($tag->questions);
            else
                return null;
        }else{
            $parent =  Category::where('slug',$project->slug)->first(); 
            //dd($parent);
            $node = Category::defaultOrder()->descendantsOf($parent->id)->toTree();
            return  Category::QuestionCounter($node,['project'=>$project,'parent'=>$parent]);
        }
        
        
    }




    public static function getUncategorizedQuestions($project){
        $parent =  Category::where('slug',$project->slug)->first();   
        $category_id_list = Category::defaultOrder()->descendantsOf($parent->id)->pluck('id')->toArray();
        $question_id_list = DB::table('category_question')->whereIn('category_id', $category_id_list)->pluck('question_id')->toArray();

        $questions = Question::where('project_id',$project->id)->whereNotIn('id',$question_id_list)->get();
        return $questions;
    }

     public function getQuestions(){

        $exam = session('exam');

        if($exam && $exam!='all'){
            $ques_category = DB::table('category_question')->where('category_id', $this->id)->distinct()->get(['question_id'])->pluck('question_id')->toArray();
        $tag = Tag::where('value',$exam)->first();
        $ques_tag = DB::table('question_tag')->where('tag_id', $tag->id)->distinct()->get(['question_id'])->pluck('question_id')->toArray();

        $list = array_intersect($ques_tag, $ques_category);
        $questions = Question::whereIn('id', $list)->get();
            return $questions;

        }else
            return $this->questions;
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
	 	$d = '<option value="0">FIRST questionCount_level2 ROOT (DEFAULT)</option>';	
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
