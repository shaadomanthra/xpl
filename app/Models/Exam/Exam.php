<?php

namespace PacketPrep\Models\Exam;

use Illuminate\Database\Eloquent\Model;
use PacketPrep\Models\Product\Test;
use PacketPrep\Models\Exam\Tests_Overall;
use PacketPrep\Models\Exam\Tests_Section;
use PacketPrep\Models\Exam\Section;
use Carbon\Carbon;

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
        return Tests_Overall::where('test_id',$this->id)->orderBy('id','desc')->limit(5)->get();
        

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
          CURLOPT_URL => 'http://krishnateja.in',
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
          CURLOPT_URL => 'http://krishnateja.in/stopdocker.php',
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
          CURLOPT_URL => 'http://krishnateja.in/removedocker.php',
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
