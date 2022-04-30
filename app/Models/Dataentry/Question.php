<?php

namespace PacketPrep\Models\Dataentry;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use PacketPrep\Models\Dataentry\Category;
use PacketPrep\Models\Dataentry\Tag;
use PacketPrep\Models\Dataentry\Project;
use PacketPrep\Models\Coures\Practice;
use PacketPrep\Models\Exam\Section;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

class Question extends Model
{
    protected $fillable = [
        'reference',
        'slug',
        'type',
        'question',
        'a',
        'b',
        'c',
        'd',
        'e',
        'answer',
        'explanation',
        'dynamic',
        'passage_id',
        'user_id',
        'project_id',
        'stage',
        'status',
        'level',
        'intest',
        'topic',
        'question_b',
        'question_c',
        'question_d',
        'passage',
        'mark'
        // add all other fields
    ];

    public function sections()
    {
        return $this->belongsToMany('PacketPrep\Models\Exam\Section');
    }

    public function categories()
    {
        return $this->belongsToMany('PacketPrep\Models\Dataentry\Category')->withPivot('intest');;
    }

    public function tags()
    {
        return $this->belongsToMany('PacketPrep\Models\Dataentry\Tag');
    }

    public function passage()
    {
        return $this->belongsTo('PacketPrep\Models\Dataentry\Passage');
    }

    public function project()
    {
        return $this->belongsTo('PacketPrep\Models\Dataentry\Project');
    }


    public static function uploadWar($fname){
   
        //$fname = $question->slug.'_'.$username.'.'.$file->getClientOriginalExtension();
    
        $path = 'https://project.packetprep.in/projects/uploadFile/'.$fname;
        $dpath = 'https://project.packetprep.in/projects/delete/'.$fname;
        
        //Initiate cURL
        $ch = curl_init();

        //Set the URL
        curl_setopt($ch, CURLOPT_URL, $path);


        //Tell cURL to return the output as a string.
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);


        //Execute the request
        $result = curl_exec($ch);

        //If an error occured, throw an exception
        //with the error message.
        if(curl_errno($ch)){
            throw new Exception(curl_error($ch));
        }

        //Print out the response from the page
        return $result;
               
    }

    public static function practice($id=null)
    {
        if($id==null)
            $id = $this->id;
         $st = request()->get('student');
        if(request()->get('refresh'))
        {
            Cache::forget('student_'.$st);
        }
       
        if(request()->get('student')){
            $user = Cache::remember('student_'.$st, 120, function() use ($st) { 
                return \Auth::user()->where('username',$st)->first();
            });
        }
        else
            $user = \Auth::user();

        if(request()->get('refresh'))
        {
            Cache::forget('practices_'.$user->id);
        }

        $practices = Cache::remember('practices_'.$user->id, 120, function() use ($user) { 
                return  DB::table('practices')->where('user_id', $user->id)->get();
            });
        

        return $practices->where('qid',$id)->first();
    }

    public function color($response,$option){

        if(!$response)
            return 'border';
        if($response->response == $option && $response->accuracy == 1)
            return 'qgreen-border';
        elseif($response->response == $option && $response->accuracy == 0)
            return 'qred-border';
        elseif($response->answer == $option && $response->accuracy == 0)
            return 'qgreen-border';
        else
            return 'border';

    }

    public function dynamic_code_save(){
        $question = $this;
        $file = "../storage/dynamic_code/".$question->id.".php";
        $file = fopen($file,"w");
        fwrite($file,"<?php \n".$question->dynamic."\n");
        fclose($file);                          
    }

    public function dynamic_variable_replacement($number=null){
        $ques = $this;
        $file = "../storage/dynamic_code/".$ques->id.".php";

        if(isset($_REQUEST['number']))
            $number = $_REQUEST['number'];

        if($number == null )
            $number = 1;

        if($number==2 && strip_tags(trim($ques->question_b))){
            $ques->question = $ques->question_b;
        }

        if($number==3 && strip_tags(trim($ques->question_c))){
            $ques->question = $ques->question_c;
        }

        if($number==4 && strip_tags(trim($ques->question_d))){
            $ques->question = $ques->question_d;
        }

        if(file_exists($file) && $ques->dynamic){
            
        
            include $file; 
            // question
            $str = preg_replace('/<span[^>]+\>/i', '', $ques->question);
            eval("\$str = \"$str\";");
            $ques->question = $str;



            $str = preg_replace('/<span[^>]+\>/i', '', $ques->a);
            eval("\$str = \"$str\";");
            $ques->a = $str;
     
            $str = preg_replace('/<span[^>]+\>/i', '', $ques->b);
            eval("\$str = \"$str\";");
            $ques->b = $str;

            $str = preg_replace('/<span[^>]+\>/i', '', $ques->c);
            eval("\$str = \"$str\";");
            $ques->c = $str;

            $str = preg_replace('/<span[^>]+\>/i', '', $ques->d);
            eval("\$str = \"$str\";");
            $ques->d = $str;

            $str = preg_replace('/<span[^>]+\>/i', '', $ques->e);
            eval("\$str = \"$str\";");
            $ques->e = $str;

            $str = preg_replace('/<span[^>]+\>/i', '', $ques->explanation); 
            eval("\$str = \"$str\";");
            $ques->explanation = $str;
        }

        return $ques;
    }


    public static function getTotalQuestionCount($project){
            return Question::where('project_id',$project->id)->count();
    }
}
