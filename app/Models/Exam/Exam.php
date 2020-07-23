<?php

namespace PacketPrep\Models\Exam;

use Illuminate\Database\Eloquent\Model;
use PacketPrep\Models\Product\Test;
use PacketPrep\Models\Exam\Tests_Overall;
use PacketPrep\Models\Exam\Tests_Section;
use PacketPrep\Models\Exam\Section;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;

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

    public function examtype()
    {
        return $this->belongsTo('PacketPrep\Models\Exam\Examtype');
    }

    public function course()
    {
        return $this->belongsTo('PacketPrep\Models\Course\Course');
    }

    public function getColor(){
      if($this->status==0)
        return 'warning';
      else if($this->status==1)
        return 'success';
      else
        return 'primary';
    }

    public function updateCache(){
        $exam = $this;

        Cache::forget('test_'.$exam->slug);
        Cache::forever('test_'.$exam->slug,$exam);


        Cache::forget('tests_'.$exam->client);
        $exams = Exam::where('client',$exam->client)->get();
        Cache::forever('tests_'.$exam->client,$exams);
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

    public function question_count()
    {
        $exam = $this;$count =0;
        if(count($exam->sections)!=0){
            foreach($exam->sections as $section){
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
        return Tests_Overall::where('test_id',$this->id)->orderBy('id','desc')->with('user')->limit(5)->get();
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

    public function updateScore($tests,$entry){
      
      
      $e_section = Tests_Section::where('user_id',$entry->user_id)->where('test_id',$entry->test_id)->where('section_id',$entry->section_id)->first();
      $e_overall = Tests_Overall::where('user_id',$entry->user_id)->where('test_id',$entry->test_id)->first();
      $section = Section::where('id',$entry->section_id)->first();

      $q = $entry->question;

      $s['mark'] = 0;
      $mark = 0;
      $sattempted=0; $oattempted=0;
      $flag = false;
      foreach($tests as $t){
        if($t->section_id==$entry->section_id){
          $s['mark'] = $s['mark'] + $t->mark;
          if($t->status!=2){
            $sattempted++;
          }
        }

        if($t->status!=2){
            $oattempted++;
            $mark = $mark +  $t->mark;
        }

        if($t->status==2)
          $flag = true;
      }

      if($entry->mark){
          $entry->accuracy=1;
          $e_section->score = $s['mark'];
          $e_overall->score = $mark;

          if(!$flag)
            $e_overall->status = 0;

          $entry->status =1;

          

        $entry->save();
        $e_section->save();
        $e_overall->save();
      }

      $user_id = $entry->user_id;
      $test_id = $entry->test_id;

      Cache::forget('attempt_'.$user_id.'_'.$test_id);
      Cache::forget('responses_'.$user_id.'_'.$test_id); 

        return 1;
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
