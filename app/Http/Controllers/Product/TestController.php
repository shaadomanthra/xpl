<?php

namespace PacketPrep\Http\Controllers\Product;

use Illuminate\Http\Request;
use PacketPrep\Http\Controllers\Controller;
use PacketPrep\Models\Dataentry\Tag;
use PacketPrep\Models\Product\Client;
use PacketPrep\Models\Dataentry\Question;
use PacketPrep\Models\Dataentry\Passage;
use PacketPrep\Models\Product\Test;
use PacketPrep\Models\Product\Product;
use PacketPrep\Models\Product\Order;
use PacketPrep\Models\Exam\Exam;
use PacketPrep\User;


class TestController extends Controller
{


    public function index($tag_slug,$id=null,Request $request)
    {

         $tag = Tag::where('value',$tag_slug)->first();
         $completed = 0;

        if($id==null){
        	$view ='questions';
            if($tag->questions){
                if(isset($tag->questions[0]))
                $id = $tag->questions[0]->id;
                else
                $id = null ;
            }else
                $id=null;
        }else
        	$view = 'q';
        


        if($id){
            $question = Question::where('id',$id)->first();


            if($question){
            
                $passage = Passage::where('id',$question->passage_id)->first();
                $questions = $tag->questions;

                $details = ['curr'=>null,'prev'=>null,'next'=>null,'qno'=>null,'display_type'=>'tag']; 

                $test = Test::where('question_id',$id)->where('user_id',\auth::user()->id)->first();
	            if($test){
	            	$details['response'] = $test->response;
	            }else{
	            	$details['response'] = null;
	            }


              
                $details['curr'] = $question->id;
                
                $tests = ['test1','test2','test3','test4','test5'];
                foreach($questions as $key=>$q){

                    if($q->id == $question->id){

                        if($key!=0)
                            $details['prev'] = $questions[$key-1]->id;

                        if(count($questions) != $key+1)
                            $details['next'] = $questions[$key+1]->id;

                        $details['qno'] = $key + 1 ;
                    }

                    $details['q'.$q->id] = null;

                    $t = Test::where('question_id',$q->id)->where('user_id',\auth::user()->id)->first();
		            if(!$t){
		            	$t= new Test();

				    	$t->question_id = $q->id;
				    	$t->test_id = $tag_slug;
				    	$t->user_id = \auth::user()->id;
				    	$t->response = null;
				    	$t->answer = strtoupper($q->answer);
				    	$t->accuracy=0;
				    	$t->time=0;


				    	$t->save();
		            }else{
		            	if($t->status != 1){
		            	if ((strtotime("now") - strtotime($t->created_at)) > 3600){
				    		$t->status =1;
				    		$t->save();
				    		$completed = 1;
		            	}else{
		            		if($t->response)
		            		$details['q'.$q->id] = true;

		            	}
		            	}else{
		            		$completed = 1;
		            	}

		            }

                } 

                if($completed)
                	return redirect()->route('onlinetest.analysis',$tag_slug);
                else
                return view('appl.product.test.'.$view)
                        ->with('mathjax',true)
                        ->with('question',$question)
                        ->with('passage',$passage)
                        ->with('details',$details)
                        ->with('tag',$tag)
                        ->with('tests',$tests)
                        ->with('timer',true)
                        ->with('questions',$questions);
            }else
                abort('404','Question not found');
            
        }
        else
            abort(403);
    }


    public function solutions($tag_slug,$id=null,Request $request)
    {

         $tag = Tag::where('value',$tag_slug)->first();
         

        if($id==null){
        	$view ='questions';
            if($tag->questions){
                if(isset($tag->questions[0]))
                $id = $tag->questions[0]->id;
                else
                $id = null ;
            }else
                $id=null;
        }else
        	$view = 'q';
        


        if($id){
            $question = Question::where('id',$id)->first();


            if($question){
            
                $passage = Passage::where('id',$question->passage_id)->first();
                $questions = $tag->questions;

                $details = ['curr'=>null,'prev'=>null,'next'=>null,'qno'=>null,'display_type'=>'tag']; 

                $test = Test::where('question_id',$id)->where('user_id',\auth::user()->id)->first();
	            if($test){
	            	$details['response'] = $test->response;
	            	$details['accuracy'] = $test->accuracy;
	            }else{
	            	$details['response'] = null;
	            }


                
            
                $details['curr'] = route('onlinetest.solutions.q',[$tag->value,$question->id]);
                
                $tests = ['test1','test2','test3','test4','test5'];
                $questions = Test::where('test_id',$tag->value)->where('user_id',\auth::user()->id)->get();
                foreach($questions as $key=>$q){

                    if($q->question_id == $question->id){

                        if($key!=0)
                            $details['prev'] = route('onlinetest.solutions.q',[$tag->value,$questions[$key-1]->question_id]);

                        if(count($questions) != $key+1)
                            $details['next'] = route('onlinetest.solutions.q',[$tag->value,$questions[$key+1]->question_id]);

                        $details['qno'] = $key + 1 ;
                    }

                    $details['q'.$q->id] = null;

                   

                } 

                

                return view('appl.product.test.solutions')
                        ->with('mathjax',true)
                        ->with('question',$question)
                        ->with('passage',$passage)
                        ->with('details',$details)
                        ->with('tag',$tag)
                        ->with('tests',$tests)
                        ->with('questions',$questions);
            }else
                abort('404','Question not found');
            
        }
        else
            abort(403);
    }

    public function save($tag_slug,$id,Request $request)
    {

    	$tag = Tag::where('value',$tag_slug)->first();
    	$question = Question::where('id',$id)->first();

    	$test = Test::where('question_id',$id)->where('user_id',$request->get('user_id'))->first();
    	if(!$test)
    	$test = new Test();

    	$test->question_id = $request->get('question_id');
    	$test->test_id = $tag_slug;
    	$test->user_id = $request->get('user_id');
    	if($request->get('response'))
    	$test->response = strtoupper($request->get('response'));
    	$test->answer = strtoupper($question->answer);
    	if($request->get('time'))
    	$test->time = $test->time+$request->get('time');

    	if($test->response == $test->answer)
    		$test->accuracy =1;
    	else
    		$test->accuracy=0;

    	$test->save();

    }


    public function clear($tag_slug,$id,Request $request)
    {

    	$tag = Tag::where('value',$tag_slug)->first();
    	$question = Question::where('id',$id)->first();

    	$test = Test::where('question_id',$id)->where('user_id',$request->get('user_id'))->first();
    	if(!$test)
    	$test = new Test();

    	$test->question_id = $request->get('question_id');
    	$test->test_id = $tag_slug;
    	$test->user_id = $request->get('user_id');
    	$test->time = $test->time+$request->get('time');
    	$test->response = strtoupper($request->get('response'));
    	$test->answer = strtoupper($question->answer);
    	$test->accuracy=0;

    	$test->save();

    }

    public function submit($tag_slug,Request $request)
    {

    	$tag = Tag::where('value',$tag_slug)->first();
    	$questions = $tag->questions;

    	foreach($questions as $key=>$q){
           	$t = Test::where('question_id',$q->id)->where('user_id',\auth::user()->id)->first();
           	$t->status =1;
			$t->save();
        } 

        return redirect()->route('onlinetest.analysis',$tag_slug);

    }

    public function analysis($tag_slug,Request $request)
    {

    	$tag = Tag::where('value',$tag_slug)->first();

    	$questions = $tag->questions;

    	
    	$details = ['correct'=>0,'incorrect'=>'0','unattempted'=>0,'attempted'=>0,'avgpace'=>'0','testdate'=>null];
    	$details['course'] = 'quant';
    	$sum = 0;
    	$c=0;
    	$i=0;
    	$u=0;
    	foreach($questions as $key=>$q){
           	$t = Test::where('question_id',$q->id)->where('user_id',\auth::user()->id)->first();
           	if(isset($t)){
           		$sum = $sum + $t->time;
           		$details['testdate'] = $t->created_at->diffForHumans();
           	}
           	

           	$ques = Question::where('id',$q->id)->first();
           	
           	
           	if($t)
           	if($t->response){
           		$details['attempted'] = $details['attempted'] + 1;	
           		if($t->accuracy==1){
           			$details['c'][$c] = $q->categories->where('parent_id','<>','307')->first();
           			$c++;
           			$details['correct'] = $details['correct'] + 1;
           		}
	           	else{
	           		$details['i'][$i] = $q->categories->where('parent_id','<>','307')->first();
           			$i++;
	           		$details['incorrect'] = $details['incorrect'] + 1;	
	           	}
	           	
           	}else{
           		$details['u'][$u] = $q->categories->where('parent_id','<>','307')->first();
           			$u++;
           		$details['unattempted'] = $details['unattempted'] + 1;	
           	}



        } 
        $success_rate = $details['correct']/count($questions);
        if($success_rate > 0.9)
        	$details['performance'] = 'Excellent';
        elseif(0.7 < $success_rate && $success_rate < 0.9)
        	$details['performance'] = 'Good';
        elseif(0.4 < $success_rate && $success_rate < 0.7)
        	$details['performance'] = 'Average';
        else
        	$details['performance'] = 'Need to Improve';

        $details['avgpace'] = round($sum / count($questions),2);
        
        
        

    	return view('appl.product.test.analysis')
                        ->with('tag',$tag)
                        ->with('details',$details)
                        ->with('chart',true);

    }

    public function proficiency_test(Request $request)
    {

        $exam = Exam::where('slug','proficiency-test')->first();
        $order = null;
        if(\auth::user()){
            $product = Product::where('slug','proficiency-test')->first();
            $order = Order::where('user_id',\auth::user()->id)->where('product_id',$product->id)->first();
        }
        return view('appl.product.test.proficiency')->with('order',$order)->with('exam',$exam);

    }

    public function instructions($tag_slug,Request $request)
    {

    	$tag = Tag::where('value',$tag_slug)->first();
    	
    	return view('appl.product.test.instructions')
                        ->with('tag',$tag);

    }


    public function main(Request $request)
    {
    	$tests = ['test1'=>null,'test2'=>null,'test3'=>null,'test4'=>null,'test5'=>null];

    	if(\auth::user())
    		$user = \auth::user();
    	else
    		$user = User::where('username','krishnateja')->first();

    	foreach($tests as $test => $val){
    			$tag = Tag::where('value',$test)->first();
    			$questions = $tag->questions;
    				

    			if(count($questions)==0)
    				$tests[$test.'_count'] = 0;
    			else
    				$tests[$test.'_count'] = count($questions);

    			foreach($questions as $key=>$q){
    				if($q){
    					
			         	$t = Test::where('question_id',$q->id)->where('user_id',$user->id)->first();

			         	if($t && \auth::user())
				           	{
				           		$tests[$test] = true;
				           		break;
				           	}else{
				           		$tests[$test] = false;
				           		break;
				           	}
			           	
    				}
		           	
		        } 

    		}


    	if(!\auth::user()){
    		return view('appl.product.test.onlinetest')->with('tests',$tests);
    	}else{

    		return view('appl.product.test.onlinetest')->with('tests',$tests);
    	}

    }

}
