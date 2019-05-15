<?php

namespace PacketPrep\Models\Dataentry;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use PacketPrep\Models\Dataentry\Category;
use PacketPrep\Models\Dataentry\Tag;
use PacketPrep\Models\Dataentry\Project;
use PacketPrep\Models\Coures\Practice;
use PacketPrep\Models\Exam\Section;

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

    public static function practice($id=null)
    {
        if($id==null)
            $id = $this->id;
        return DB::table('practices')->where('user_id', \auth::user()->id)->where('qid',$id)->first();
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
        $question = $this;
        $file = "../storage/dynamic_code/".$question->id.".php";

        if(isset($_REQUEST['number']))
            $number = $_REQUEST['number'];

        if($number == null )
            $number = 1;
        if(file_exists($file) && $question->dynamic){
            
        
            include $file; 
            // question
            $str = $question->question;
            eval("\$str = \"$str\";");
            $question->question = $str;

            $str = $question->a;
            eval("\$str = \"$str\";");
            $question->a = $str;
     
            $str = $question->b;
            eval("\$str = \"$str\";");
            $question->b = $str;

            $str = $question->c;
            eval("\$str = \"$str\";");
            $question->c = $str;

            $str = $question->d;
            eval("\$str = \"$str\";");
            $question->d = $str;

            $str = $question->e;
            eval("\$str = \"$str\";");
            $question->e = $str;

            $str = $question->explanation;
            eval("\$str = \"$str\";");
            $question->explanation = $str;
        }

        return $question;
    }


    public static function getTotalQuestionCount($project){
            return Question::where('project_id',$project->id)->count();
    }
}
