<?php

namespace PacketPrep\Http\Controllers\Dataentry;

use Illuminate\Http\Request;
use PacketPrep\Http\Controllers\Controller;
use PacketPrep\Models\Dataentry\Qdb;
use PacketPrep\Models\Dataentry\Question;
use PacketPrep\Models\Dataentry\Category;
use PacketPrep\Models\Dataentry\Tag;
use PacketPrep\Models\Dataentry\Project;
use Illuminate\Support\Facades\DB;


class QdbController extends Controller
{
    public function index(){



    	
    	//$this->remove_questions();
    	//dd();
    	$slug = 'verbal-ability';
    	$our_slug = 'verbal-ability';
    	$project_id = Project::where('slug','general-aptitude')->first()->id;
    	//dd($project_id);
    	$qset = Qdb::where('course',$slug)->get();


    	foreach($qset as $q )
    	{
    		
    		$q->question = htmlspecialchars_decode($q->question);

    		

    		 $question_exists = Question::where('slug',$q->hash)
                            ->where('project_id',$project_id)
                            ->first();

            if(!$question_exists){
                $ques = new Question();
                $ques->reference = $q->qno;
                $ques->slug = $q->hash;
                $ques->type = $q->type;
                $ques->question = $q->question;
                $ques->a = htmlspecialchars_decode($q->a);
                $ques->b = htmlspecialchars_decode($q->b);
                $ques->c = htmlspecialchars_decode($q->c);
                $ques->d = htmlspecialchars_decode($q->d);
                $ques->e = htmlspecialchars_decode($q->e);
                $ques->answer = htmlspecialchars_decode($q->answer);
                $ques->explanation = htmlspecialchars_decode($q->explanation);
                $ques->user_id = \auth::user()->id;
                $ques->project_id  = $project_id;
                $ques->stage = 0;
                $ques->status =0;
       			$ques->save();

       			
       			$category = Category::where('slug',$our_slug)->first();
       			
       			$year= Tag::where('value',$q->year)->where('project_id',$project_id)->first();
       			$set = Tag::where('value',$q->qset)->where('project_id',$project_id)->first();
       			$mark = Tag::where('value',$q->mark)->where('project_id',$project_id)->first();


       			$ques->categories()->attach($category->id);
       			if($year)
       			$ques->tags()->attach($year->id);
       			if($set)
       			$ques->tags()->attach($set->id);
       			if($mark)
       			$ques->tags()->attach($mark->id);
            }else{
            	$year= Tag::where('value',$q->year)->where('project_id',$project_id)->first();
       			$set = Tag::where('value',$q->qset)->where('project_id',$project_id)->first();
       			$mark = Tag::where('value',$q->mark)->where('project_id',$project_id)->first();

	       		$ques = $question_exists;
	            if($year)
	            	if(!$ques->tags->contains($year->id))
	       			$ques->tags()->attach($year->id);
	       		if($set)
	       			if(!$ques->tags->contains($set->id))
	       			$ques->tags()->attach($set->id);
	       		if($mark)
	       			if(!$ques->tags->contains($mark->id))
	       			$ques->tags()->attach($mark->id);
            }

            
    	}


    	$this->replacement($our_slug);


    	/*
    	return $q;
    	echo htmlspecialchars_decode($q->question);
    	echo htmlspecialchars_decode($q->a);
    	echo htmlspecialchars_decode($q->b);
    	echo htmlspecialchars_decode($q->c);
    	echo $this->strip_codecogs($q->d);
    	echo str_replace('&space;', ' ', '(\exists&space;x)P(x)\wedge&space;(\exists&space;x)Q(x)\rightarrow&space;(\exists&space;x)\left&space;\{&space;P(x)\wedge&space;Q(x)\right&space;\}');


    	foreach($q as $a=>$b)
    	{
    		print_r($b['question']);
    	}
    	//return $q;
    	*/
    }

    public function replacement($item=null){

    	if($item==null)
    		$item = 'probability';

    	$qset = Question::whereHas('categories', function ($query) use ($item)  {
			    $query->where('slug', 'like', $item);
			})->get();

    	foreach($qset as $q){
    		$q->question = $this->img_replace($q->question);
	    	$q->a = $this->img_replace($q->a);
	    	$q->b = $this->img_replace($q->b);
	    	$q->c = $this->img_replace($q->c);
	    	$q->d = $this->img_replace($q->d);
	    	$q->e = $this->img_replace($q->e);
	    	$q->answer = $this->img_replace($q->answer);
	    	$q->explanation = $this->img_replace($q->explanation);
	    	$q->save();
    	}
    	
    	//echo $q->explanation;
    	//echo $this->img_replace($q->explanation);

    }

    public function answerSanitize($answer){
		$pattern = "=^<p>(.*)</p>$=i";
		preg_match($pattern, $answer, $matches);
		if(isset($matches[1]))
			return $matches[1];
		else
			return $answer;
    }

    public function remove_questions(){
    	$item = 'graph-theory';
    	$qset = Question::whereHas('categories', function ($query) use ($item)  {
			    $query->where('slug', 'like', $item);
			})->get(); 

    	foreach($qset as $q){
    		$q->categories()->detach();
    		$q->tags()->detach();
    		$q->delete();
    	}
    }
    public function img_replace($editor_data){
    	$detail=$editor_data;
        if($detail){
            $dom = new \DomDocument();
            libxml_use_internal_errors(true);
            $dom->loadHtml(mb_convert_encoding($detail, 'HTML-ENTITIES', 'UTF-8'), LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);    
            $images = $dom->getElementsByTagName('img');

            $domele = array();
            $domval = array();
            foreach($images as $k => $img){

                $data = $img->getAttribute('src');

                $new_data = $this->strip_codecogs($data);

                if($new_data){
                	$divnode = $dom->createElement("span", $new_data);
	                $domele[] = $img;
	                $domval[] = $divnode;
                }else{
                	$img->removeAttribute('width');
                	$img->removeAttribute('height');
                    $img->setAttribute('class', 'qimage w-100');
                }
            }

            foreach($domele as $k=>$d){
            	$d->parentNode->replaceChild($domval[$k], $d);
            }

            $detail = $dom->saveHTML();
        }
        return $detail;
    }

    public function strip_codecogs($image){
    	if (strpos($image, 'http://latex.codecogs.com/gif.latex?') !== false) {
		    $image = str_replace('http://latex.codecogs.com/gif.latex?', '', $image);
	    	$image = str_replace('&space;', ' ', $image);
	    	return '\('.$image.'\)';
		}else
			return false;
    	
    }
}
