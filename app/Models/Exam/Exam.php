<?php

namespace PacketPrep\Models\Exam;

use Illuminate\Database\Eloquent\Model;
use PacketPrep\Models\Product\Test;
use PacketPrep\Models\Exam\Tests_Overall;
use PacketPrep\Models\Exam\Tests_Section;
use PacketPrep\Models\Exam\Section;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

class Exam extends Model
{
  protected $fillable = [
        'name',
        'slug',
        'user_id',
        'description',
        'instructions',
        'status',
        'examtype_id',
        'code',
        'course_id',
        'solutions',
        'image',
        'emails',
        'active',
        'camera',
        'calculator',
        'auto_activation',
        'auto_deactivation',
        'window_swap',
        'auto_termination',
        'capture_frequency',
        'client',
        'shuffle',
        'message',
        'save',
        'extra',
        'settings'
        // add all other fields
    ];

    public function user(){
      return $this->belongsTo('PacketPrep\User');
    }
    
    public function sections()
    {
        return $this->hasMany('PacketPrep\Models\Exam\Section');
    }

    public function products()
    {
        return $this->belongsToMany('PacketPrep\Models\Product\Product');
    }

    public function viewers()
    {
        return $this->belongsToMany('PacketPrep\User')->withPivot('role');
    }

    public function evaluators()
    {
        return $this->belongsToMany('PacketPrep\User')->withPivot('role');
    }

    public function examtype()
    {
        return $this->belongsTo('PacketPrep\Models\Exam\Examtype');
    }

    public function course()
    {
        return $this->belongsTo('PacketPrep\Models\Course\Course');
    }

    public function users()
    {
        return $this->hasMany('PacketPrep\Models\Exam\Tests_Overall','test_id');
    }

    public function getColor(){
      if($this->status==0)
        return 'warning';
      else if($this->status==1)
        return 'success';
      else
        return 'primary';
    }


    public function image_rollback($images,$jsonname,$student,$qid=null,$k=null){

  // dd($images);
    if($qid){
      $r = $images[$qid][$k];
      $p = explode('urq/',$r);
      $id = str_replace('a','',$k);
      $name2 = $this->slug.'_'.$student->id.'_'.$qid.'_'.$id.'.jpg?abcd';
      $url = $p[0].'urq/'.$name2;
      $images[$qid][$k]   = $url;
      Storage::disk('s3')->put('urq/'.$jsonname.'.json',json_encode($images));

      $mode = request()->get('mode');
      return redirect()->route('assessment.responses',['slug'=>$this->slug,'refresh'=>1,'mode'=>$mode,'student'=>$student->username]);
      
    }else{
      foreach($images as $i =>$img){
        if(count($img)>0){
          foreach($img as $k=>$r){
            $p = explode('urq/',$r);
            $id = str_replace('a','',$k);
            $name2 = $this->slug.'_'.$student->id.'_'.$i.'_'.$id.'.jpg?abcd';
            $url = $p[0].'urq/'.$name2;
            $images[$i][$k]   = $url;
          }
            
        }
       
      }
    }
      
      Storage::disk('s3')->put('urq/'.$jsonname.'.json',json_encode($images));

    }

    public function updateCache(){
            //add owner
        $exam = $this;
        $exam->product_ids = $exam->products->pluck('id')->toArray();
        $exam->examtype = $exam->examtype;
        $exam->settings = json_decode($exam->settings);
        
        if(!$exam->viewers->contains($exam->user_id))
                $exam->viewers()->attach($exam->user_id,['role'=>'owner']);

        Cache::forget('test_'.$exam->slug);
        Cache::forever('test_'.$exam->slug,$exam);

        Cache::forget('exam_admin_'.$exam->slug);
        $id = $exam->slug;
        $exam= Cache::remember('exam_admin_'.$id,30, function() use ($id){
            return Exam::where('slug',$id)->with('user')->with('sections')->withCount('users')->first();
        });

        Cache::forget('tests_'.$exam->client);
        $exams = Exam::where('client',$exam->client)->with('examtype')->get();
        Cache::forever('tests_'.$exam->client,$exams);

        

    }

    public static function processForm($data){
        $d = [];
        $form = explode(',',$data);
        foreach($form as $k=>$f){
            $item = ["name"=>$f,"type"=>"input","values"=>""];
            if(preg_match_all('/<<+(.*?)>>/', $f, $regs))
            {
                foreach ($regs[1] as $reg){
                    $variable = trim($reg);
                    $item['name'] = str_replace($regs[0], '', $f);


                    if(is_numeric($variable)){
                        $item['type'] = 'textarea';
                        $item['values'] = $variable;

                    }else if($variable=='file'){
                        $item['type'] = 'file';
                        $item['values'] = $variable;
                    }else{
                        $options = explode('/',$variable);
                        $item['values'] = $options;
                        $item['type'] = 'checkbox';
                    }
                    
                }
            }

            if(preg_match_all('/{{+(.*?)}}/', $f, $regs))
            {

                foreach ($regs[1] as $reg){
                    $variable = trim($reg);
                    $item['name'] = str_replace($regs[0], '', $f);
                    $options = explode('/',$variable);
                    $item['values'] = $options;
                    $item['type'] = 'radio';
                    
                }
            }

            if($item['name'])
            $d[$k] = $item;

        }

        return $d;
    }

        public function removeDuplicatesStudent($student){
        $exam = $this;
        $sset = array_keys($exam->sections()->select('id')->get()->keyBy('id')->toArray());

        $qset=[];

        foreach($exam->sections as $s){
          $qset1 = $exam->getQuestionsSection($s->id,$student->id);
          
          foreach($s->questions as $q)
            array_push($qset,$q->id);
        }
        
        $qcount = $exam->questionCount();
        //$users = array_keys(Tests_Overall::select('user_id')->where('test_id',$exam->id)->get()->keyBy('user_id')->toArray());
        
        $to = Tests_Overall::where('test_id',$exam->id)->where('user_id',$student->id)->get();
        $t = Test::where('test_id',$exam->id)->where('user_id',$student->id)->get();
        $ts = Tests_Section::where('test_id',$exam->id)->where('user_id',$student->id)->get();

        //echo "users - ".count($users)."<br><br>";
        $u=$student->id;
        $count =0;
        
            $tests = $to->where('user_id',$u)->count();
            if($tests!=1){
              $items = $to->where('user_id',$u);
              $dontDeleteThisRow = $items->first();

              $ids =array_keys($to->where('user_id',$u)->where('id', '!=', $dontDeleteThisRow->id)->keyBy('id')->toArray());
              Tests_Overall::whereIn('id',$ids)->delete();
              
            }
            $count = $count + $tests;
        //   echo $u.' - '.$tests."<bR>";
        

        // echo "total -".$count."<br><br>";


        $count =0;
       
            $tests = $ts->where('user_id',$u)->count();
            if($tests>count($sset)){
              // Get the row you don't want to delete.
              foreach($sset as $s){
                  $dontDeleteThisRow = $ts->where('section_id', $s)->where('user_id',$u)->first();
                  //dd($dontDeleteThisRow->id);
                  
                  $ids = Tests_Section::where('test_id',$exam->id)->where('user_id',$u)->where('section_id', $s)->where('id', '!=', $dontDeleteThisRow->id)->delete();
                
              }
              

            }
             $count = $count + $tests;
           // echo $u.' - '.$tests."<bR>";
        
        
        $count =0;
            $tests =$t->where('user_id',$u)->groupBy('question_id');
            foreach($tests as $tx){
              if(count($tx)>1){
                $dontDeleteThisRow = $tx[1];//$t->where('question_id', $tx[1]->id)->where('user_id',$u)->first();

                  echo $dontDeleteThisRow->id;
                  $dontDeleteThisRow->delete();
             
                
              }

            }
            
            //$count = $count + $tests;
          // echo $u.' - '.$tests."<bR>";
        
       
    }


    public function removeDuplicates(){
        $exam = $this;
        $sset = array_keys($exam->sections()->select('id')->get()->keyBy('id')->toArray());

        $qset=[];
        foreach($exam->sections as $s){
          foreach($s->questions as $q)
            array_push($qset,$q->id);
        }
        
        $qcount = $exam->questionCount();
        if(request()->get('page')){

            $users = array_keys(Tests_Overall::select('user_id')->where('test_id',$exam->id)->paginate(30)->keyBy('user_id')->toArray());
            $to = Tests_Overall::where('test_id',$exam->id)->whereIn('user_id',$users)->get();
            $t = Test::where('test_id',$exam->id)->whereIn('user_id',$users)->get();
            $ts = Tests_Section::where('test_id',$exam->id)->whereIn('user_id',$users)->get();

        }else{
            $users = array_keys(Tests_Overall::select('user_id')->where('test_id',$exam->id)->get()->keyBy('user_id')->toArray());
             $to = Tests_Overall::where('test_id',$exam->id)->get();
            $t = Test::where('test_id',$exam->id)->get();
            $ts = Tests_Section::where('test_id',$exam->id)->get();
        }
        
       

        //echo "users - ".count($users)."<br><br>";
        $count =0;
        foreach($users as $u){
            
            $tests = $to->where('user_id',$u)->count();
            if($tests!=1){
              $items = $to->where('user_id',$u);
              $dontDeleteThisRow = $items->first();

              $ids =array_keys($to->where('user_id',$u)->where('id', '!=', $dontDeleteThisRow->id)->keyBy('id')->toArray());
              Tests_Overall::whereIn('id',$ids)->delete();
              
            }
            $count = $count + $tests;
          //echo $u.' - '.$tests."<bR>";
        }

        //echo "total -".$count."<br><br>";

        $count =0;
        foreach($users as $u){
            $tests = $ts->where('user_id',$u)->count();
            if($tests>count($sset)){
              // Get the row you don't want to delete.
              foreach($sset as $s){
                  $dontDeleteThisRow = $ts->where('section_id', $s)->where('user_id',$u)->first();
                  //dd($dontDeleteThisRow->id);
                  
                  $ids = Tests_Section::where('test_id',$exam->id)->where('user_id',$u)->where('section_id', $s)->where('id', '!=', $dontDeleteThisRow->id)->delete();
                
              }
              

            }
             $count = $count + $tests;
           // echo $u.' - '.$tests."<bR>";
        }
        

        $count =0;
        foreach($users as $u){
           
            $tests =$t->where('user_id',$u)->count();
            if($tests > count($qset) || $tests>60 ){

                foreach($qset as $s){
                  $dontDeleteThisRow = $t->where('question_id', $s)->where('user_id',$u)->first();

                  try{
                        if($dontDeleteThisRow)
                        Test::where('test_id',$exam->id)->where('question_id', $s)->where('user_id',$u)->where('id', '!=', $dontDeleteThisRow->id)->delete();
                  }catch(Exception $e) {
                      echo 'Message: ' .$e->getMessage();
                    }
                  
                  //dd($ids);
                  //$ts::where('question_id', $s)->where('id', '!=', $dontDeleteThisRow->id)->delete();

              }
            }
            $count = $count + $tests;
            //echo $u.' - '.$tests."<bR>";
        }
        //echo "total -".$count."<br><br>";
        
    }


     public function getScore($id){
        $curl = curl_init();
      // Set some options - we are passing in a useragent too here

      curl_setopt_array($curl, [
          CURLOPT_RETURNTRANSFER => 1,
          CURLOPT_URL => env('API_URL').$this->slug.'/analysis?id='.$id.'&source='.env('APP_NAME').'&json=1',
      ]);

    
    
      //$data ='{"files": [{"name": "main.c", "content": '.$code.'}]}';
      //echo $data;

      // Send the request & save response to $resp
      $data = json_decode(curl_exec($curl));
      
      // Close request to clear up some resources
      curl_close($curl);

      return $data->score;
    }

    public function precheck_auto_activation(){
      $auto_activation  = \carbon\carbon::parse($this->auto_activation);
      $auto_deactivation  = \carbon\carbon::parse($this->auto_deactivation);
   
      if(!$this->auto_activation && !$this->auto_deactivation)
        return 1;
      if($auto_activation->lt(\carbon\carbon::now()) && $auto_deactivation->gt(\carbon\carbon::now())){
          if($this->active){
            $this->active = 0;
            $this->save();
            $this->cache();
          }
      }else{
          
          if(!$this->active){
            $this->active = 1;
            $this->save();
            $this->cache();
          }
      }
    }

    public function cache(){
      $exam = $this;
      $cache_path =  '../storage/app/cache/exams/';
      $filename = $exam->slug.'.json';
      $filepath = $cache_path.$filename;
      $exam->sections = $exam->sections;
      $exam->products = $exam->products;
      $exam->product_ids = $exam->products->pluck('id')->toArray();
      foreach($exam->sections as $m=>$section){
        $exam->sections->questions = $section->questions;
      }
      //file_put_contents($filepath, json_encode($exam,JSON_PRETTY_PRINT));
      $this->updateCache();
    }

    public function changeImageUrls(){
      $exam = $this;
      $exam = Exam::where('id',$exam->id)->first();
      foreach($exam->sections as $s){
      
        foreach($s->questions as $q){
          $q->question = str_replace('https://xplore.co.in/storage', 'https://s3-xplore.s3.ap-south-1.amazonaws.com', $q->question);
          $q->a = str_replace('https://xplore.co.in/storage', 'https://s3-xplore.s3.ap-south-1.amazonaws.com', $q->a);
          $q->b = str_replace('https://xplore.co.in/storage', 'https://s3-xplore.s3.ap-south-1.amazonaws.com', $q->b);
          $q->c = str_replace('https://xplore.co.in/storage', 'https://s3-xplore.s3.ap-south-1.amazonaws.com', $q->c);
          $q->d= str_replace('https://xplore.co.in/storage', 'https://s3-xplore.s3.ap-south-1.amazonaws.com', $q->d);
          $q->e = str_replace('https://xplore.co.in/storage', 'https://s3-xplore.s3.ap-south-1.amazonaws.com', $q->e);
          $q->explanation = str_replace('https://xplore.co.in/storage', 'https://s3-xplore.s3.ap-south-1.amazonaws.com', $q->explanation);

          $q->question = str_replace('http://xplore.co.in/storage', 'https://s3-xplore.s3.ap-south-1.amazonaws.com', $q->question);
          $q->a = str_replace('http://xplore.co.in/storage', 'https://s3-xplore.s3.ap-south-1.amazonaws.com', $q->a);
          $q->b = str_replace('http://xplore.co.in/storage', 'https://s3-xplore.s3.ap-south-1.amazonaws.com', $q->b);
          $q->c = str_replace('http://xplore.co.in/storage', 'https://s3-xplore.s3.ap-south-1.amazonaws.com', $q->c);
          $q->d= str_replace('http://xplore.co.in/storage', 'https://s3-xplore.s3.ap-south-1.amazonaws.com', $q->d);
          $q->e = str_replace('http://xplore.co.in/storage', 'https://s3-xplore.s3.ap-south-1.amazonaws.com', $q->e);
          $q->explanation = str_replace('http://xplore.co.in/storage', 'https://s3-xplore.s3.ap-south-1.amazonaws.com', $q->explanation);

          $q->save();

        }
      }

    }


   
    public function getQuestionsSection($id, $uid){

       $i = $uid %10;
       $name = 'set_'.$this->slug.'_'.$i;
       $set = Cache::get($name);

       
       $sec = $this->sections->find($id);
       if($set){
          $qids = $set[$id];
          $questions = Cache::remember('exam_ques_'.$i.'_'.$sec->id,360,function() use ($sec,$qids){
            return $sec->questions()->whereIn('question_id',$qids)->get();
          });
          return $questions;
       }else{
        $questions = Cache::remember('exam_ques_'.$sec->id,360,function() use ($sec){
            return $sec->questions;
        });
          return $questions;
       }
    }

    // public function shuffle($qset,$responses){

    //   return $qset;
    // }


     public function questions($data){
        $d = [];
        $form = explode(',',$data);
        foreach($form as $k=>$f){
            $item = ["name"=>$f,"type"=>"input","values"=>""];
            if(preg_match_all('/<<+(.*?)>>/', $f, $regs))
            {
                $item['name'] = str_replace($regs[0], '', $f);   
            }

            if(preg_match_all('/{{+(.*?)}}/', $f, $regs))
            {
                $item['name'] = str_replace($regs[0], '', $f);
            }

            if($item['name'])
                $d[$k] = $item['name'];

        }

        return $d;
    }

    public function pool_qset($qset,$formula){


        if(!$formula)
          return $qset->pluck('id')->toArray();

        $l1_ques= $qset->where('level','1');
        $l2_ques = $qset->where('level','2');
        $l3_ques = $qset->where('level','3');



        $ques = [];
        if(isset($formula->level1)){
        $level1 = $formula->level1;



        foreach($level1 as $topic=>$qcount){

          $ques_temp = $l1_ques->where('topic',$topic)->pluck('id')->shuffle()->take($qcount);

         

          foreach($ques_temp as $a=>$qid){
            array_push($ques, $qid);
          }
        }
        }


        // if(!isset($formula->level1) && !isset($formula->level2) && !isset($formula->level3)){
        //   $ques = $qset->pluck('id')->toArray();
        // }


        if(isset($formula->level2)){
        $level2 = $formula->level2;
        foreach($level2 as $topic=>$qcount){
          $ques_temp = $l2_ques->where('topic',$topic)->pluck('id')->shuffle()->take($qcount);
          foreach($ques_temp as $a=>$qid){
            array_push($ques, $qid);
          }
        }
        }

        if(isset($formula->level3)){
          $level3 = $formula->level3;
          foreach($level3 as $topic=>$qcount){
            $ques_temp = $l3_ques->where('topic',$topic)->pluck('id')->shuffle()->take($qcount);
            foreach($ques_temp as $a=>$qid){
              array_push($ques, $qid);
            }
          }
        }

        return $ques;


    }

    public function question_count()
    {
        return null;
        $exam = $this;$count =0;
        $sections = Cache::get('sections_'.$exam->slug);
        if(!$sections){
            $sections = $exam->sections;
            Cache::forever('sections_'.$exam->slug,$sections);
        }
        if(count($sections)!=0){
            foreach($sections as $section){
                $count = $count + count($section->questions);   
            }
            return $count;
        }else
            return null;

    }

    public function questionCount()
    {
        $count = 0;
        foreach($this->sections as $s){
          $count = $count + count($s->questions);

        }
        return $count;

    }
    public function getAttemptCount($code=null,$month=null)
    {
        if($code)
        return Tests_Overall::where('code',$code)->where('test_id',$this->id)->count();
        else{
          
          if($month=='thismonth')
            return Tests_Overall::where('test_id',$this->id)->whereMonth('created_at', Carbon::now()->month)->count();
          elseif($month=='lastmonth')
            return Tests_Overall::where('test_id',$this->id)->whereMonth('created_at', '=', Carbon::now()->subMonth()->month)->count();
          elseif($month=='lastbeforemonth')
            return Tests_Overall::where('test_id',$this->id)->whereMonth('created_at', '=', Carbon::now()->subMonth(2)->month)->count();
          else
            return Tests_Overall::where('test_id',$this->id)->count();
        }
    }

    public function getAttempts($exams,$month=null)
    {
        if(!$month)
        return Tests_Overall::whereIn('test_id',$exams)->orderBy('id','desc')->paginate(30);
        else{
          
          if($month=='thismonth')
            return Tests_Overall::whereIn('test_id',$exams)->whereMonth('created_at', Carbon::now()->month)->orderBy('id','desc')->paginate(30);
          elseif($month=='lastmonth')
            return Tests_Overall::whereIn('test_id',$exams)->whereMonth('created_at', '=', Carbon::now()->subMonth()->month)->orderBy('id','desc')->paginate(30);
          elseif($month=='lastbeforemonth')
            return Tests_Overall::whereIn('test_id',$exams)->whereMonth('created_at', '=', Carbon::now()->subMonth(2)->month)->orderBy('id','desc')->paginate(30);
          else
            return Tests_Overall::whereIn('test_id',$exams)->orderBy('id','desc')->paginate(30);
        }
    }

    public function getUserIds($code=null,$month=null)
    {
        if($code)
        return Tests_Overall::where('code',$code)->where('test_id',$this->id)->pluck('user_id');
        else{
          
          if($month=='thismonth')
            return Tests_Overall::where('test_id',$this->id)->whereMonth('created_at', Carbon::now()->month)->pluck('user_id');
          elseif($month=='lastmonth')
            return Tests_Overall::where('test_id',$this->id)->whereMonth('created_at', '=', Carbon::now()->subMonth()->month)->pluck('user_id');
          elseif($month=='lastbeforemonth')
            return Tests_Overall::where('test_id',$this->id)->whereMonth('created_at', '=', Carbon::now()->subMonth(2)->month)->pluck('user_id');
          else
            return Tests_Overall::where('test_id',$this->id)->pluck('user_id');
        }
    }

    public function latestUsers()
    {
        return Tests_Overall::where('test_id',$this->id)->orderBy('id','desc')->with('user')->take(5)->get();
    }

    public function psychometric_test($student){
      $exam = $this;
      $sections = array();
      $i=0;
        foreach($exam->sections as $section){
            foreach($section->questions as $q){
                $questions[$i] = $q;
                    $i++;
            }
        }
      $tests = Test::where('test_id',$exam->id)
                        ->where('user_id',$student->id)->get();


      if(count($tests))
      if($exam->slug=='psychometric-test')
        {
            $d['extroversion'] = 20;
            $d['agreeableness'] = 14;
            $d['conscientiousness'] = 14;
            $d['neuroicism'] = 38;
            $d['openness'] = 8;

            $mc['extroversion'] = "Extroversion (E) is the personality trait of seeking fulfillment from sources outside the self or
                in community. High scorers tend to be very social while low scorers prefer to work on their
                projects alone.";
            $mc['agreeableness'] = "Agreeableness (A) reflects much individuals adjust their behavior to suit others. High scorers
                are typically polite and like people. Low scorers tend to 'tell it like it is'.";
            $mc['conscientiousness'] = "Conscientiousness (C) is the personality trait of being honest and hardworking. High scorers
                tend to follow rules and prefer clean homes. Low scorers may be messy and cheat others.";
            $mc['neuroicism'] = "Neuroticism (N) is the personality trait of being emotional.";
            $mc['openness'] = "Openness to Experience (O) is the personality trait of seeking new experience and intellectual
                pursuits. High scores may day dream a lot. Low scorers may be very down to earth.";

            $cc['extroversion']['high'] = "High Extroverts are characterized by excitability, sociability, talkativeness, assertiveness, and expressiveness. They are outgoing and work well in social situations. Working in a team helps them feel energized and excited.";
            $cc['extroversion']['mid'] = "This range of extroversion indicates more detailed assessment of the candidate in this area.";
            $cc['extroversion']['low'] = "Low Extroverts or introverts are reserved and prefer not to socialise, unless absolutely necessary. Social events can be draining often requiring a period of quiet in order to 'recharge.'";

            $cc['conscientiousness']['high'] = "Conscientious people are thoughtful, prepared, and self-motivated. They are also concerned about the well-being of those around them. They are good at meeting deadlines.";
            $cc['conscientiousness']['mid'] = "This range of conscientiousness indicates more detailed assessment of the candidate in this area.";
            $cc['conscientiousness']['low'] = "Low conscientious people have difficulty in following schedules and are prone  to procrastinate. They might also be disorganised and avoid responsibility.";

            $cc['agreeableness']['high'] = "Agreeable people are prosocial, kind, and altruistic. They might not always flourish in highly competitive environments. They are empathetic and enjoy helping people.";
            $cc['agreeableness']['mid'] = "This range of agreeableness indicates more detailed assessment of the candidate in this area.";
            $cc['agreeableness']['low'] = "People with low agreeability are focused on their tasks and completing them despite the social cost. They could be competitive, manipulative, and condescending of others.";

            $cc['neuroicism']['high'] = "Emotionally Stable people are often good at dealing with stress, and can work well in a variety of areas. They are emotionally resilient and bounce back  fast from failures.
                ";
            $cc['neuroicism']['mid'] = "This range of emotional stability indicates more detailed assessment of the candidate in this area.";
            $cc['neuroicism']['low'] = "Those scoring low on emotional stability find it hard to deal with failure and rejection. They experience anxiety and dramatic shifts in mood.";

             $cc['openness']['high'] = "Highly open people are usually creative and can tackle change and new environments with ease. Tackling abstract concepts and new challenges is their forte.";
            $cc['openness']['mid'] = "This range of openness indicates more detailed assessment of the candidate in this area.";
            $cc['openness']['low'] = "Low open people prefer the comfort or established routines, and traditional values. They are good at following rules but may lack imagination and the ability to handle sudden change.";

            $calc['extroversion'] = [1=>'1',6=>'-6',11=>'11',16=>'-16',21=>'21',26=>'-26',31=>'31',36=>'-36',41=>'41',46=>'-46'];
            $calc['agreeableness'] = [2=>'-2',7=>'7',12=>'-12',17=>'17',22=>'-22',27=>'27',32=>'-32',37=>'37',42=>'-42',47=>'47'];
            $calc['conscientiousness'] = [3=>'3',8=>'-8',13=>'13',18=>'-18',23=>'23',28=>'-28',33=>'33',38=>'-38',43=>'43',48=>'48'];
            $calc['neuroicism'] = [4=>'-4',9=>'9',14=>'-14',19=>'19',24=>'-24',29=>'29',34=>'-34',39=>'-39',44=>'-44',49=>'-49'];
            $calc['openness'] = [5=>'5',10=>'-10',15=>'15',20=>'-20',25=>'25',30=>'-30',35=>'35',40=>'40',45=>'45',50=>'50'];

            $resp =array(); $ques=array();
            foreach($tests as $t){
                $resp[$t->question_id]= $t->response;
            }

            foreach($questions as $m=>$q){
                $num = ["A"=>1,"B"=>2,"C"=>3,"D"=>4,"E"=>5];
                if($resp[$q->id])
                $questions[$m]->response = $num[$resp[$q->id]];
                else
                $questions[$m]->response = 0;
                 
                $questions[$m]->qno = substr($q->reference,1,3);
                if($resp[$q->id])
                $ques[$questions[$m]->qno] = $num[$resp[$q->id]];
                else
                $ques[$questions[$m]->qno] = 0;  
            }
            foreach($calc as $a=>$b){
                foreach($b as $i=>$k)
                if($k<0)
                    $d[$a] = $d[$a]-$ques[$i];
                else
                    $d[$a] = $d[$a]+$ques[$i];

                if($a=='neuroicism')
                    $d[$a] = 40 - $d[$a];
            }

            $data['m'] = $mc;
            $data['c'] = $cc;
            $data['d'] = $d;

            return $data;
        }else{
          return null;
        }
        else
          return null;
    }

    public function getProductSlug(){

        $p = $this->products->first();
        if($p)
            return $p->slug;
        else
            return 0;
    }

    public function time()
    {
        $exam = $this;$count =0;
        return null;
        if(count($exam->sections)!=0){
            foreach($exam->sections as $section){
                $count = $count + $section->time;   
            }
            return $count;
        }else
            return null;

    }

    public function attempted()
    {
        if(!\auth::user())
            return false;

        $test = Test::where('test_id',$this->id)->where('user_id',\auth::user()->id)->first();

        if($test){
            return true;
        }else
            return false;

    }

    public function audio($user,$qid=null,$final=null){
      ini_set('max_execution_time', '600');
        $exam  = $this;
        $user_id = $user->id;
        
        $settings = $exam->settings;

        if($settings){
            if(is_object($settings)){
              $section_marking = ($settings->section_marking=='yes')? 1 : 0;
            }
            elseif(json_decode($settings))
            {
              $settings = json_decode($settings);
              $section_marking = ($settings->section_marking=='yes')? 1 : 0;

            }else
            $section_marking = ($settings->section_marking=='yes')? 1 : 0;
        }
        else
            $section_marking = 0;

        $tests = Test::where('user_id',$user_id)->where('test_id',$exam->id)->get()->keyBy('question_id');
        $tsection = Tests_Section::where('user_id',$user_id)->where('test_id',$exam->id)->get()->keyBy('section_id');
        $toverall = Tests_Overall::where('user_id',$user_id)->where('test_id',$exam->id)->first();

        $questions = [];
        $questions2= [];
        foreach($exam->sections as $section){
            //$qset = $section->questions;
            $qset = $exam->getQuestionsSection($section->id,$user->id);
            foreach($qset as $q)
            {
              if($qid){
                if($qid==$q->id && $q->type=='aq')
                  $questions[$q->id] = $q;
              }else{
                if($q->type=='aq')
                  $questions[$q->id] = $q;
              }
              
             
            }
        }

        $folder = 'webcam/'.$exam->id.'/';
        $name_prefix = $folder.$user->username.'_'.$exam->id.'_';

        foreach($tests as $s=>$t){
          if(array_key_exists($t->question_id, $questions))
          {
             $filename = $name_prefix.'audio_'.$t->question_id.'.wav';
            


            $url = Storage::disk('s3')->url($filename);
             $text = urlencode(strip_tags(trim(str_replace('Read aloud the below passage and record it, note that you can record only once.','',$questions[$t->question_id]->question))));
            // create curl resource
             $curl = 'https://speech.p24.in/?file='.$url.'&text='.$text;
             //dd($curl);
             $exists = false;
             $output = json_decode($t->comment,true);

              if(!Storage::disk('s3')->exists($filename)){
              
              $output = "0";
              }

             if(!isset($output['fluency']) && $output!="0")
              $output = json_decode($this->curlPost($curl),true);

             
              $t->accuracy =0;
              $t->mark = 0;
              $scale=0.6;
              if(isset($output['fluency'])){

                  if($output['fluency']>90 && $output['accuracy']>90 && $output['completeness']>90)
                    $scale=0.9;
                  elseif(($output['fluency']>80 && $output['fluency']<90 ) || ($output['accuracy']>80  && $output['accuracy']<90) || ( $output['completeness']>80 && $output['completeness']<90))
                    $scale=0.7;
                   elseif(($output['fluency']>70 && $output['fluency']<80 ) || ($output['accuracy']>70  && $output['accuracy']<80) || ( $output['completeness']>70 && $output['completeness']<80))
                    $scale=0.5;

                $score = (0.35*$output['fluency'] + 0.45 *$output['accuracy'] + 0.2*$output['completeness'])*$scale;
              }
              else
                $score = 0;

              if($output=="0"  || $output=='-1')
              {

                $output = ['accuracy'=>0,'completeness'=>0,'fluency'=>0];

              }else{
                  $t->accuracy =1;
                  $t->mark= round($questions[$t->question_id]->mark/100 * $score,2);
              }

              $t->status =1;
              if(isset($output))
              $t->comment = json_encode($output);

              $t->save();

              $tests[$s] = $t;
          }

        }

        $qcount =0;
        $ototal = 0;
        $otm=0;
        foreach($exam->sections as $section){
            //$qset = $section->questions;
            $qset = $exam->getQuestionsSection($section->id,$user->id);

            $sitem = $tsection[$section->id];

            $stotal = 0;
            $stm =0;

            foreach($qset as $q){
                $flag = 0; 
                $id = $q->id;
                $e = $tests[$id];

                if($section_marking){
                  $mark = $section->mark;
                  $neg = $section->negative;
                  $stm = $stm + $mark;

                  if($e->accuracy==1 && !array_key_exists($q->id, $questions)){
                    if($e->mark!=$mark){
                      $e->mark = $mark;
                      $flag=1;
                    }
                    $stotal = $stotal + $e->mark;
                  }else{
                    if($e->response && $neg){
                      $e->mark = 0 - $neg;
                      $flag =1;
                    }

                    $stotal = $stotal + $e->mark;
                  }

                }else{
                  $mark = $q->mark;
                  $stm = $stm + $mark;
                  // if($e->accuracy==1 && !array_key_exists($q->id, $questions)){
                  //   if($e->mark!=$mark){
                  //     $e->mark = $mark;
                  //     $flag=1;
                  //   }
                  // }

                  $stotal = $stotal + $e->mark;

                }

                if($flag){
                  $e->save();
                }
            }

            $sitem->score = $stotal;
            $sitem->max = $stm;
            $sitem->save();

            $ototal = $ototal + $stotal;
            $otm = $otm + $stm;

        }

        $toverall->score = $ototal;
        $toverall->max = $otm;
        if($final)
          $toverall->status = 0;
        $toverall->save();
    }


    
    public function grammarly($user,$final=null){
        $exam  = $this;
        $user_id = $user->id;
        
        $settings = $exam->settings;
        if($settings){
             if(is_object($settings)){
              $section_marking = ($settings->section_marking=='yes')? 1 : 0;
            }
            elseif(json_decode($settings))
            {
              $settings = json_decode($settings);
              $section_marking = ($settings->section_marking=='yes')? 1 : 0;

            }else
            $section_marking = ($settings->section_marking=='yes')? 1 : 0;
        }
        else
            $section_marking = 0;

        $tests = Test::where('user_id',$user_id)->where('test_id',$exam->id)->get()->keyBy('question_id');
        $tsection = Tests_Section::where('user_id',$user_id)->where('test_id',$exam->id)->get()->keyBy('section_id');
        $toverall = Tests_Overall::where('user_id',$user_id)->where('test_id',$exam->id)->first();

        $questions = [];
        foreach($exam->sections as $section){
            //$qset = $section->questions;
            $qset = $exam->getQuestionsSection($section->id,$user->id);
            foreach($qset as $q)
            {
              if($q->type=='sq')
                $questions[$q->id] = $q;
             
            }
            
        }



        foreach($tests as $s=>$t){
          if(array_key_exists($t->question_id, $questions))
          {
            $response = $t->response;
            // create curl resource


             $output = json_decode($this->curlPost('https://grammar.p24.in/api/v1/check?text='.urlEncode($response)),true);

             
              
              if(isset($output['score']['generalScore']))
                $score = intval($output['score']['generalScore']);
              else
                $score = 10;

              if(str_word_count($response)>50){
                if($score==-1){
                  $t->accuracy =1;
                  $t->mark= round($questions[$t->question_id]->mark/100 * 40,2);
                }else{
                  $t->accuracy =1;
                $t->mark= round($questions[$t->question_id]->mark/100 * $score,2);
                }
                
              }
              else{
                $t->accuracy =0;
                $t->mark = 0;
              }
              

              $t->status =1;
              if(isset($output['score']['outcomeScores']))
              $t->comment = json_encode($output['score']['outcomeScores']);
              $t->save();

              $tests[$s] = $t;


          }
        }


        $qcount =0;
        $ototal = 0;
        $otm=0;
        foreach($exam->sections as $section){
            //$qset = $section->questions;
            $qset = $exam->getQuestionsSection($section->id,$user->id);

            $sitem = $tsection[$section->id];

            $stotal = 0;
            $stm =0;

            foreach($qset as $q){
                $flag = 0; 
                $id = $q->id;
                $e = $tests[$id];

                if($section_marking){
                  $mark = $section->mark;
                  $neg = $section->negative;
                  $stm = $stm + $mark;

                  if($e->accuracy==1 && !array_key_exists($q->id, $questions)){
                    if($e->mark!=$mark){
                      $e->mark = $mark;
                      $flag=1;
                    }
                    $stotal = $stotal + $e->mark;
                  }else{
                    if($e->response && $neg){
                      $e->mark = 0 - $neg;
                      $flag =1;
                    }

                    $stotal = $stotal + $e->mark;
                  }

                }else{
                  $mark = $q->mark;
                  $stm = $stm + $mark;
                  // if(array_key_exists($q->id, $questions)){

                  // }
                  // if($e->accuracy==1 && !array_key_exists($q->id, $questions)){
                  //   if($e->mark!=$mark){
                  //     $e->mark = $mark;
                  //     $flag=1;
                  //   }
                  // }

                  $stotal = $stotal + $e->mark;

                }

                // if($flag){
                //   $e->save();
                // }
            }

            $sitem->score = $stotal;
            $sitem->max = $stm;
            $sitem->save();

            $ototal = $ototal + $stotal;
            $otm = $otm + $stm;

        }

        $toverall->score = $ototal;
        $toverall->max = $otm;
        if($final)
          $toverall->status = 0;
        $toverall->save();


    }

    public function curlPost($url, $data=NULL, $headers = NULL) {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        if(!empty($data)){
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        }

        if (!empty($headers)) {
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        }

        $response = curl_exec($ch);


        if (curl_error($ch)) {
            trigger_error('Curl Error:' . curl_error($ch));
        }


        curl_close($ch);
        return $response;
    }

    public function reEvaluate($user){
        $exam  = $this;

        $user_id = $user->id;
        
        $settings = $exam->settings;
        if($settings)
            $section_marking = ($settings->section_marking=='yes')? 1 : 0;
        else
            $section_marking = 0;

        $tests = Test::where('user_id',$user_id)->where('test_id',$exam->id)->get()->keyBy('question_id');
        $tsection = Tests_Section::where('user_id',$user_id)->where('test_id',$exam->id)->get()->keyBy('section_id');
        $toverall = Tests_Overall::where('user_id',$user_id)->where('test_id',$exam->id)->first();

        $qcount =0;
        $ototal = 0;
        $otm=0;

        foreach($exam->sections as $section){
            //$qset = $section->questions;
            $qset = $exam->getQuestionsSection($section->id,$user->id);

            $sitem = $tsection[$section->id];

            $stotal = 0;
            $stm =0;

            foreach($qset as $q){
                $flag = 0; 
                $id = $q->id;
                if(isset($tests[$id])){
                    $e = $tests[$id];

                    if($q->type=='mbfq' || $q->type=='mbdq'){
                        $q->answer = strtoupper($q->answer);
                    }else{
                       $q->answer = $this->new_answer(strtoupper($q->answer),$e->dynamic);
                    }

                    if($section_marking){
                      $mark = $section->mark;
                      $neg = $section->negative;
                      $stm = $stm + $mark;

                      if($e->accuracy==1){
                        if($e->mark!=$mark){
                          $e->mark = $mark;
                          $flag=1;
                        }
                        $stotal = $stotal + $e->mark;
                      }else{
                        if($e->response && $neg){
                          $e->mark = 0 - $neg;
                          $flag =1;
                        }

                        $stotal = $stotal + $e->mark;
                      }

                    }else{
                      $mark = $q->mark;
                      $stm = $stm + $mark;
                      // if($e->accuracy==1){
                      //   if($e->mark!=$mark){
                      //     $e->mark = $mark;
                      //     $flag=1;
                      //   }
                      // }

                      if($q->type=='mcq'){
                        if($e->response==$q->answer){
                          $e->answer = $q->answer;
                          $e->mark = $mark;
                          $e->accuracy =1;
                        }else{
                          $e->answer = $q->answer;
                          $e->mark = 0;
                          $e->accuracy = 0;
                        }

                        $flag=1;
                      }else if($q->type=='mbdq' || $q->type=='mbfq'){
                        $partialmark = 0.2;

                        $e->response = str_replace("<br>",",",$e->response);
                        $ans = explode(',',$e->response);
                        $actual_ans = explode(',',strip_tags($q->answer));
                       
                        //dd($actual_ans);
                        $e->answer = $q->answer;
                        if($q->mark)
                            $partialmark = round($q->mark/count($actual_ans),2);
                           
                        $partial_awarded  = 0;
                        
                            foreach($ans as $g=>$an){
                                if($an)
                                if($an==$actual_ans[$g]){
                                    $partial_awarded = $partial_awarded  + $partialmark;
                                }
                            }

                            $e->mark = $partial_awarded;

                            if(!$partial_awarded)
                                $e->accuracy =0;
                            else
                                $e->accuracy =1;
                            $flag=1;

                        
                      }

                      $stotal = $stotal + $e->mark;

                    }

                    
                    if($flag){
                      $e->save();
                    }

                }
                
            }

            $sitem->score = $stotal;
            $sitem->max = $stm;
            $sitem->save();

            $ototal = $ototal + $stotal;
            $otm = $otm + $stm;

        }

        $toverall->score = $ototal;
        $toverall->max = $otm;
        $toverall->save();


    }

    public function reEvaluation(){
        $exam  = $this;
        $toverall = Tests_Overall::where('test_id',$exam->id)->get();
        foreach($toverall as $tx){
            $user = $tx->user;
            $this->reEvaluate($user);
        }

    }

    public function new_answer($answer,$dynamic)
    {

        if(!$dynamic)
            return $answer;



        if(strpos($answer,',')!== false){
            $ans =explode(',', $answer);
            foreach($ans as $k=>$a){
                $ans[$k]=$this->new_ans_str($a,$dynamic);
            }
            $new_ans = implode(',', $ans);
        }else if(strlen($answer)==1){
            $new_ans = $this->new_ans_str($answer,$dynamic);
        }

        if(!isset($new_ans))
            return $answer;

        return $new_ans;
    }

    public function new_ans_str($answer,$dynamic){
        $new_ans = $answer;
        if($answer == 'A'){
            if($dynamic == 1) $new_ans = 'A';
            if($dynamic == 2) $new_ans = 'D';
            if($dynamic == 3) $new_ans = 'C';
            if($dynamic == 4) $new_ans = 'B';
        }

        if($answer == 'B'){
            if($dynamic == 1) $new_ans = 'B';
            if($dynamic == 2) $new_ans = 'A';
            if($dynamic == 3) $new_ans = 'D';
            if($dynamic == 4) $new_ans = 'C';
        }

        if($answer == 'C'){
            if($dynamic == 1) $new_ans = 'C';
            if($dynamic == 2) $new_ans = 'B';
            if($dynamic == 3) $new_ans = 'A';
            if($dynamic == 4) $new_ans = 'D';
        }

        if($answer == 'D'){
            if($dynamic == 1) $new_ans = 'D';
            if($dynamic == 2) $new_ans = 'C';
            if($dynamic == 3) $new_ans = 'B';
            if($dynamic == 4) $new_ans = 'A';
        }

        if($answer == 'E'){
            return $answer;
        }

        return $new_ans;
    }

    public function validateAnswer($key,$answer){


    }
    public function updateScore($tests,$entry){
      
      $e = Test::where('user_id',$entry->user_id)->where('test_id',$entry->test_id)->where('question_id',$entry->question_id)->first();
      $e_section = Tests_Section::where('user_id',$entry->user_id)->where('test_id',$entry->test_id)->where('section_id',$entry->section_id)->first();
      $e_overall = Tests_Overall::where('user_id',$entry->user_id)->where('test_id',$entry->test_id)->first();
      //$section = Section::where('id',$entry->section_id)->first();

      $e->mark = $entry->mark;
      $e->comment = $e->comment;
      $e->status = 1;
      $e->save();

      $q = $e->question;

      $s['mark'] = 0;
      $mark = 0;
      $sattempted=0; $oattempted=0;
      $flag = true;
      foreach($tests as $t){

        if($t->accuracy && !$t->mark)
          $t->mark = 1;
        
        if($t->id==$entry->id)
          $t->mark = $entry->mark;

        if($t->section_id==$entry->section_id){
          $s['mark'] = $s['mark'] + floatval($t->mark);
        }

        if($t->status!=2){
            $mark = $mark +  floatval($t->mark);
        }

        if($t->status==2)
          $flag= false;

      }
      $e_section->score = $s['mark'];
      $e_overall->score = $mark;


      if($flag){
            $e_overall->status = 0;
      }
      
      $e_section->save();
      $e_overall->save();



      if($flag || $e_overall->status ==0){

            $e_overall = $this->score_best($tests);

      }
      

      $user_id = $entry->user_id;
      $test_id = $entry->test_id;

      Cache::forget('attempt_'.$user_id.'_'.$test_id);
      Cache::forget('resp_'.$user_id.'_'.$test_id); 


      if(request()->get('ajax')){
                echo json_encode($e_overall);
            exit();
      }

      return Test::where('user_id',$entry->user_id)->where('test_id',$entry->test_id)->get();
    }

    public function score_best($tests){
        $exam = $this;

        $sections = $exam->sections;
        $best = array();
        foreach($sections as $sec){
          $settings = json_decode($sec->instructions);
          if(isset($settings->score_best)){
              $best[$sec->id]= $settings->score_best;
          }else{
              $best[$sec->id] = count($sec->questions);
          }
        }

        $overall = 0;
        foreach($best as $secid=>$counter){
           
              $items = $tests->where('section_id',$secid);
              $newscore = 0;
              $bestscore = [];

              foreach($items as $t){
                array_push($bestscore, $t->mark);
              }

              rsort($bestscore);
              for($i=0;$i<$counter; $i++)
                if(isset($bestscore[$i]))
                 $newscore = $newscore + $bestscore[$i];


              $user_id = $t->user_id;
              $test_id = $t->test_id;
              
              $e_section = Tests_Section::where('user_id',$user_id)->where('test_id',$test_id)->where('section_id',$secid)->first();
              $e_section->score = $newscore;
              $e_section->save();
              $best[$secid] = $newscore;
              $overall = $overall + $newscore;
        }


        //dd($overall);

        $e_overall = Tests_Overall::where('user_id',$user_id)->where('test_id',$test_id)->first();
        $e_overall->score = $overall;
        $e_overall->save();

        return $e_overall;

    }


     public function getDimensions2($url,$w=null,$percent=null){
      $s3 = 'https://'.env('AWS_BUCKET').'.s3.ap-south-1.amazonaws.com/';
      $url = preg_replace('/\?.*/', '', $url);
      $name = str_replace($s3, '', $url);
      $name = str_replace("%", '?', $name);
      //return $name;

      if(!$percent)
        $percent = 1;
      $height= Cache::get($url.'-height');
      $width= Cache::get($url.'-width');

  


      if($w==1){
        if($width)
          return $width*$percent;
      }elseif($w==2){
        if($height)
          return $height*$percent;
      }else{
        return $width*$percent.'-'.$height*$percent;
      }

      if(!Storage::disk('s3')->exists($name)){
          return '0-0';
      }
      if (!ini_get('allow_url_fopen') && function_exists('curl_version')) {

          $curl = curl_init();
          curl_setopt($curl, CURLOPT_URL, $url);
          curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
          $content = curl_exec($curl);
          curl_close($curl);

      } else if (ini_get('allow_url_fopen')) {
          $context = stream_context_create(
              array(
                  "http" => array(
                      "header" => "User-Agent: Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/50.0.2661.102 Safari/537.36"
                  )
              )
          );

          $content = file_get_contents($url,false, $context);
      } else {
          echo 'No dice.';
      }
      $height = \Image::make($content)->height();
      $width = \Image::make($content)->width();

      Cache::put($url.'-height', $height, 10);
      Cache::put($url.'-width', $width, 10);

      if($w==1){
        if($width)
          return $width*$percent;
      }elseif($w==2){
        if($height)
          return $height*$percent;
      }else{
        return $width*$percent.'-'.$height*$percent;
      }
    }

    public function getDimensions($url,$w=null){
      $s3 = 'https://'.env('AWS_BUCKET').'.s3.ap-south-1.amazonaws.com/';
      $url = preg_replace('/\?.*/', '', $url);
      $name = str_replace($s3, '', $url);


      $height= Cache::get($url.'-height');
      $width= Cache::get($url.'-width');

      if($w==1){
        if($width)
          return $width;
      }elseif($w==2){
        if($height)
          return $height;
      }else{
        return $width.'-'.$height;
      }

      if(!Storage::disk('s3')->exists($name)){
          return '0-0';
      }
      if (!ini_get('allow_url_fopen') && function_exists('curl_version')) {

          $curl = curl_init();
          curl_setopt($curl, CURLOPT_URL, $url);
          curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
          $content = curl_exec($curl);
          curl_close($curl);

      } else if (ini_get('allow_url_fopen')) {
          $context = stream_context_create(
              array(
                  "http" => array(
                      "header" => "User-Agent: Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/50.0.2661.102 Safari/537.36"
                  )
              )
          );

          $content = file_get_contents($url,false, $context);
      } else {
          echo 'No dice.';
      }
      $height = \Image::make($content)->height();
      $width = \Image::make($content)->width();

      Cache::put('height', $height, 10);
      Cache::put('width', $width, 10);

      if($w==1){
        if($width)
          return $width;
      }elseif($w==2){
        if($height)
          return $height;
      }else{
        return $width.'-'.$height;
      }
      return $width.'-'.$height;
    }


    public function runCode($r=null){
     

      $entry = Test::where('status',2)->orderBy('id','desc')->first();

      if(!$entry){

        if($r && !$entry)
        if($r->get('qno')){
          
          $entry = Test::whereNotNull('code')->orderBy('id','desc')->first();
        }else{
          return null;
        }
      }
      else if($entry->status!=2){

        return null;
      }
      
       
      $e_section = Tests_Section::where('user_id',$entry->user_id)->where('test_id',$entry->test_id)->where('section_id',$entry->section_id)->first();
      $e_overall = Tests_Overall::where('user_id',$entry->user_id)->where('test_id',$entry->test_id)->first();
      $section = Section::where('id',$entry->section_id)->first();

      $q = $entry->question;

      $code = $entry->code;
      $name = str_random();
      $input = $q->a;
      if($q->b=='cpp')
        $lang = 'clang';
      else
        $lang = $q->b;
      if($q->b=='c')
        $c = 1;
      else
        $c =0;

      $data = $this->run_internal_p24($code,$input,$lang,$c,$name);
      //$data = $this->run_internal($code,$input);
      $json = json_decode($data);

      if(isset($json->stdout)){


        $entry->response = strip_tags(trim($json->stdout));
        if(strtolower($entry->response) == strtolower($entry->answer)){

          $entry->accuracy=1;
          $e_section->correct++;
          $e_section->unattempted--;
          $e_section->score = $e_section->score + $section->mark;

          $e_overall->correct++;
          $e_overall->unattempted--;
          $e_overall->score = $e_overall->score + $section->mark;
        }
        else{
          $e_section->incorrect++;
          $e_section->unattempted--;
          if($section->negative)
          $e_section->score = $e_section->score - $section->negative;

          $e_overall->incorrect++;
          $e_overall->unattempted--;
          if($section->negative)
          $e_overall->score = $e_overall->score - $section->negative;

          $entry->accuracy=0;
        }

        if($e_overall->unattempted<1)
            $e_overall->status = 0;

          
        if(!$entry->response && $entry->response!==0){
         
          $entry->response = $json->stderr;
        }

      }
      
      
        $entry->status =1;

        $entry->save();
        $e_section->save();
        $e_overall->save();

        

        return 1;
    }

    public function run_internal_p24($code,$input,$lang,$c,$name){


      // Get cURL resource
      $curl = curl_init();
      // Set some options - we are passing in a useragent too here

      curl_setopt_array($curl, [
          CURLOPT_RETURNTRANSFER => 1,
          CURLOPT_URL => 'http://code.p24.in',
          CURLOPT_POST => 1,
          CURLOPT_TIMEOUT => 30,
      ]);

      $form = array('hash'=>'krishnateja','c'=>$c,'docker'=>'1','lang'=>$lang,'form'=>'1','code'=>$code,'input'=>$input,'name'=>$name);

    
      //$data ='{"files": [{"name": "main.c", "content": '.$code.'}]}';
      //echo $data;
      curl_setopt($curl, CURLOPT_POSTFIELDS, $form);

      // Send the request & save response to $resp
      $data = curl_exec($curl);
      
      // Close request to clear up some resources
      curl_close($curl);


      return $data;

    }

    public function dockerStop(){
      $name = request()->get('name');

      $curl = curl_init();
      // Set some options - we are passing in a useragent too here

      curl_setopt_array($curl, [
          CURLOPT_RETURNTRANSFER => 1,
          CURLOPT_URL => 'http://code.p24.in/stopdocker.php',
          CURLOPT_POST => 1,
      ]);

      $form = array('name'=>$name);
    
    
      //$data ='{"files": [{"name": "main.c", "content": '.$code.'}]}';
      //echo $data;
      curl_setopt($curl, CURLOPT_POSTFIELDS, $form);

      // Send the request & save response to $resp
      $data = curl_exec($curl);
      
      // Close request to clear up some resources
      curl_close($curl);
    }

    public function dockerRemove(){
      $curl = curl_init();
      // Set some options - we are passing in a useragent too here

      curl_setopt_array($curl, [
          CURLOPT_RETURNTRANSFER => 1,
          CURLOPT_URL => 'http://code.p24.in/removedocker.php',
          CURLOPT_POST => 1,
      ]);

      $form = array('name'=>'');
    
    
      //$data ='{"files": [{"name": "main.c", "content": '.$code.'}]}';
      //echo $data;
      curl_setopt($curl, CURLOPT_POSTFIELDS, $form);

      // Send the request & save response to $resp
      $data = curl_exec($curl);
      
      // Close request to clear up some resources
      curl_close($curl);
    }


}
