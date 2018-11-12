<?php

namespace PacketPrep\Http\Controllers\Dataentry;

use Illuminate\Http\Request;
use PacketPrep\Http\Controllers\Controller;
use PacketPrep\Models\Dataentry\Qdb;
use PacketPrep\Models\Dataentry\Question;
use PacketPrep\Models\Dataentry\Category;
use PacketPrep\Models\Dataentry\Tag;
use PacketPrep\Models\Dataentry\Passage;
use PacketPrep\Models\Dataentry\Project;
use Illuminate\Support\Facades\DB;


class QdbController extends Controller
{
    public function index(){
    	
        dd();
    	//$this->remove_questions();
    	//dd();
    	$slug = '120';
    	$our_slug = 'double-synonyms';
    	$project_id = Project::where('slug','general-english')->first()->id;

    	//dd($project_id);
    	$qset = Qdb::where('cat_id',$slug)->get();



        //dd($qset);
        //create tags
        foreach($qset as $q ){

            $exam_tag_exists = Tag::where('name','exam')
                            ->where('value',strtolower($q->exam))
                            ->where('project_id',$project_id)
                            ->first();

            if(!$exam_tag_exists){
                $tag = new Tag();
                $tag->name = 'exam';
                $tag->value = strtolower($q->exam);
                $tag->project_id = $project_id;
                $tag->user_id = \auth::user()->id;
                $tag->save();
            }

            $year_tag_exists = Tag::where('name','year')
                            ->where('value',$q->year)
                            ->where('project_id',$project_id)
                            ->first();

            if(!$year_tag_exists){
                $tag = new Tag();
                $tag->name = 'year';
                $tag->value = $q->year;
                $tag->project_id = $project_id;
                $tag->user_id = \auth::user()->id;
                $tag->save();
            }

            // if passage exists
            if($q->pid)
            {
                $passage = DB::table('qinput_passage')->where('id', $q->pid)->first();
                $passage_exists = Passage::where('passage', htmlspecialchars_decode($passage->passage))
                            ->where('project_id',$project_id)
                            ->first();

                if(!$passage_exists)
                {
                    $pass = new Passage();
                    $pass->name = $q->pid;
                    $pass->passage = htmlspecialchars_decode($passage->passage);
                    $pass->project_id = $project_id;
                    $pass->user_id = \auth::user()->id;
                    $pass->status = 1;
                    $pass->save();
                }


            }


            //echo $q->exam." ".$q->year."<br>";
        }
        //dd();

    	foreach($qset as $q )
    	{
    		
    		$q->question = htmlspecialchars_decode($q->question);

    		 $question_exists = Question::where('slug',$q->qhash)
                            ->where('project_id',$project_id)
                            ->first();

            if(!$question_exists){
                $ques = new Question();
                $ques->reference = $q->qno;
                $ques->slug = $q->qhash;
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
                
                $passage_ = Passage::where('name',$q->pid)->where('project_id',$project_id)->first();
                if($passage_)
                    $ques->passage_id = $passage_->id;
       			
                $ques->save();

       			
       			$category = Category::where('slug',$our_slug)->first();
       			
       			$year= Tag::where('value',$q->year)->where('project_id',$project_id)->first();
       			$exam = Tag::where('value',strtolower($q->exam))->where('project_id',$project_id)->first();
                


       			$ques->categories()->attach($category->id);
       			if($year)
       			$ques->tags()->attach($year->id);
       			if($exam)
       			$ques->tags()->attach($exam->id);


            }else{
            	$year= Tag::where('value',$q->year)->where('project_id',$project_id)->first();
       			$exam= Tag::where('value',strtolower($q->exam))->where('project_id',$project_id)->first();

	       		$ques = $question_exists;
	            if($year)
	            	if(!$ques->tags->contains($year->id))
	       			$ques->tags()->attach($year->id);
	       		if($exam)
	       			if(!$ques->tags->contains($exam->id))
	       			$ques->tags()->attach($exam->id);
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

    public function exportQuestion(){

        $qset = Question::get();
        $ques = [];
        foreach($qset as $a=>$q){
        
            $ques[$a]['id'] = $q->id;
            $ques[$a]['slug'] = $q->slug;
            $ques[$a]['answer'] = $q->answer;
        }

        $json_data = json_encode($ques,JSON_PRETTY_PRINT);
        file_put_contents('ques_answers.json', $json_data);

    }

    public function importQuestion(){
        $ques = json_decode(file_get_contents('ques_answers.json'));
        foreach($ques as $q){
            $slug = $q->slug;
            $answer = $q->answer;
            $question = Question::where('slug',$slug)->first();
            
            if($question){
                $question->answer = strtoupper($this->answerSanitize($answer));
                $question->save();
            }
            
        }

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
    	$item = 'cause-and-effect-reasoning';
    	$qset = Question::whereHas('categories', function ($query) use ($item)  {
			    $query->where('slug', 'like', $item);
			})->get(); 

    	foreach($qset as $q){
    		$q->categories()->detach();
    		$q->tags()->detach();
    		$q->delete();
    	}

        dd();
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
