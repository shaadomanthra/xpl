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


    public static function uploadWar($question){
        $file      = request()->all()['zip_file'];
        $username = \auth::user()->username;
        $fname = $question->slug.'_'.$username.'.'.$file->getClientOriginalExtension();
        
        $filepath = 'zip_practice/'.$fname;

        Storage::disk('local')->put($filepath, file_get_contents($file),'public');
        $file_name_with_full_path = Storage::disk('local')->path($filepath);
        $target_url = 'http://64.227.185.90:8080/projects/uploadFile';
        $ip = "64.227.185.90:8080";

        // if (function_exists('curl_file_create')) { // php 5.5+
        //   $cFile = curl_file_create($file_name_with_full_path,mime_content_type($file_name_with_full_path), $fname);
        // } else { // 
        //   $cFile = '@' . realpath($file_name_with_full_path);
        // }
        // $post = array('file_contents'=> $cFile);
      
        // $ch = curl_init();
        // curl_setopt( $ch, CURLOPT_HTTPHEADER, array("REMOTE_ADDR: $ip", "HTTP_X_FORWARDED_FOR: $ip"));
        // curl_setopt($ch, CURLOPT_URL,$target_url);
        // curl_setopt($ch, CURLOPT_POST,1);
        // curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
        // $result=curl_exec ($ch);
        // curl_close ($ch);
        //The URL that accepts the file upload.
        

    



        //Initiate cURL
        $ch = curl_init();

        //Set the URL
        curl_setopt($ch, CURLOPT_URL, $target_url);

        //Set the HTTP request to POST
        curl_setopt($ch, CURLOPT_POST, true);

        //Tell cURL to return the output as a string.
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        //If the function curl_file_create exists
        if(function_exists('curl_file_create')){
            //Use the recommended way, creating a CURLFile object.
            $filePath = curl_file_create($file_name_with_full_path);
        } else{
            //Otherwise, do it the old way.
            //Get the canonicalized pathname of our file and prepend
            //the @ character.
            $filePath = '@' . realpath($file_name_with_full_path);
            //Turn off SAFE UPLOAD so that it accepts files
            //starting with an @
            curl_setopt($ch, CURLOPT_SAFE_UPLOAD, false);
        }

        //Setup our POST fields
        $postFields = array(
            $fname=> $file_name_with_full_path,
            'blahblah' => 'Another POST FIELD'
        );

        curl_setopt($ch, CURLOPT_POSTFIELDS, $postFields);

        //Execute the request
        $result = curl_exec($ch);

        //If an error occured, throw an exception
        //with the error message.
        if(curl_errno($ch)){
            throw new Exception(curl_error($ch));
        }

        //Print out the response from the page
       

        dd($result);
               
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
