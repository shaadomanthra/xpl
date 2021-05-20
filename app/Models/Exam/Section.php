<?php

namespace PacketPrep\Models\Exam;

use Illuminate\Database\Eloquent\Model;
use PacketPrep\Models\Dataentry\Question;
use Illuminate\Support\Facades\DB;

class Section extends Model
{
    protected $fillable = [
        'name',
        'negative',
        'mark',
        'time',
        'user_id',
        'exam_id',
        'instructions',
        // add all other fields
    ];

     public function questions()
    {
        return $this->belongsToMany('PacketPrep\Models\Dataentry\Question');
    }

    public function wordToHtml($source,$name){
        $phpWord = new \PhpOffice\PhpWord\PhpWord();
        $phpWord = \PhpOffice\PhpWord\IOFactory::load($source);
        $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'HTML');
        $objWriter->save($name);
    }

    public function readHtmlTables($html){
        //defaults
        $data = ["sections"=>[],"questions"=>[]];
        //initial data;
        $section = ["sno"=>"","name"=>"","time"=>"","mark"=>"","negative"=>"","qset"=>[]]; 
        $question = ["qno"=>"","reference"=>"","slug"=>strtotime("now"),"question"=>"","a"=>"","b"=>"","c"=>"","d"=>"","e"=>"","answer"=>"","explanation"=>"","dynamic"=>"","project_id"=>"78","passage_id"=>"","c"=>"","user_id"=>"","stage"=>"","status"=>"1","level"=>"","intest"=>"","topic"=>"","question_b"=>"","question_c"=>"","question_d"=>"","mark"=>"","created_at"=>"","updated_at"=>""]; 

        
        //dom parser
        $dom = new \DomDocument();
       /*** load the html into the object ***/ 
       $dom->loadHTML($html); 
       
       /*** discard white space ***/ 
       $dom->preserveWhiteSpace = false; 
       $dom->formatOutput       = true;
       
       /*** the table by its tag name ***/ 
       $tables = $dom->getElementsByTagName('table'); 
       
       foreach($tables as $table){
            /*** get all rows from the table ***/ 
           $rows = $table->getElementsByTagName('tr'); 
           
           $c1 = strtoupper(str_replace(" ","",trim(strip_tags($rows->item(0)->getElementsByTagName('td')->item(0)->nodeValue))));
           $num = strtoupper(str_replace(" ","",trim(strip_tags($rows->item(0)->getElementsByTagName('td')->item(1)->nodeValue))));
           
            foreach ($rows as $row) {
                /*** get each column by tag name ***/ 
                $cols = $row->getElementsByTagName('td'); 
                $key = strtolower(trim(strip_tags($cols->item(0)->nodeValue)));
                $value = trim($cols->item(1)->nodeValue); 
                

                if($c1=='SNO')
                {
                    $section[$key] = $value;
                }else if($c1=='QNO'){
                    $question[$key] = $value;
                }

                if($cols->item(1)->getElementsByTagName('img')){

                   // echo static::DOMinnerHTML($cols->item(1)); 
                   // echo "img here<br>";
               }
            }

            if($c1=='SNO'){
                $data['sections'][$num] = $section;
                //array_push($data['sections'],$section);
            }else if($c1=='QNO'){
                $data['questions'][$num] = $question;
                if(isset($data['sections'][$question['sno']])){
                    $data['sections'][$question['sno']]['qset'][$num] = $question;
                }
                //array_push($data['questions'],$question); 
            }
           
       }

       return $data;
       
    }


    public function saveSection($exam_id,$section){

        $sec = null;
        $sec = Section::where('name',$section['name'])->first();
        if(!$sec){
            $sec = new Section();
        }
        
        $sec->user_id = \Auth::user()->id;
        $sec->exam_id = $exam_id;
        $sec->name = $section['name'];
        $sec->mark = intval($section['mark']);
        $sec->time = intval($section['time']);
        $sec->mark = intval($section['negative']);
        $sec->instructions = null;
        $sec->save();

    }

    public function saveQuestion($exam_id,$question){

        $ques = null;
        $ques = Question:where('reference',$question['qno'])->first();
        if(!$ques){
            $ques = new Question();
        }
        $ques->reference = $question['qno'];
        $ques->user_id = \Auth::user()->id;
        $ques->question = $question['qno'];
        $sec->mark = intval($section['mark']);
        $sec->time = intval($section['time']);
        $sec->mark = intval($section['negative']);
        $sec->instructions = null;
        $sec->save();

    }

    

}
