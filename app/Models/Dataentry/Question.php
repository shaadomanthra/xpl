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

    public static function practice($id=null)
    {
        if($id==null)
            $id = $this->id;

        if(request()->get('student'))
            $user = \Auth::user()->where('username',request()->get('student'))->first();
        else
        $user = \Auth::user();

        return DB::table('practices')->where('user_id', $user->id)->where('qid',$id)->first();
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
