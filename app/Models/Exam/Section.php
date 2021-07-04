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

    public function dataToHtml($exam){
        $phpWord = new \PhpOffice\PhpWord\PhpWord();
        $phpWord = \PhpOffice\PhpWord\IOFactory::load($source);
        $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'HTML');
        $objWriter->save($name);
    }

    public function dataToWord($data){
        $phpWord = new \PhpOffice\PhpWord\PhpWord();
        $section = $phpWord->addSection();
            //libxml_use_internal_errors(true); 

        // $doc = new \DOMDocument();
        // $doc->loadHTML($data);
        // $doc->saveHTML();
     

        // \PhpOffice\PhpWord\Shared\Html::addHtml($section, $doc->saveHtml(),true);
        // //\PhpOffice\PhpWord\Shared\Html::addHtml($section, trim($data));
        $header = array('size' => 16, 'bold' => true);
        $rows = 10;
        $cols = 5;

        $section->addTextBreak(1);
$section->addText(htmlspecialchars('Fancy table'), $header);

$styleTable = array('borderSize' => 6, 'borderColor' => '006699', 'cellMargin' => 80);
$styleFirstRow = array('borderBottomSize' => 18, 'borderBottomColor' => '0000FF', 'bgColor' => '66BBFF');
$styleCell = array('valign' => 'center');
$styleCellBTLR = array('valign' => 'center', 'textDirection' => \PhpOffice\PhpWord\Style\Cell::TEXT_DIR_BTLR);
$fontStyle = array('bold' => true, 'align' => 'center');
$phpWord->addTableStyle('Fancy Table', $styleTable, $styleFirstRow);
$table = $section->addTable('Fancy Table');
$table->addRow(900);
$table->addCell(2000, $styleCell)->addText(htmlspecialchars('Row 1'), $fontStyle);
$table->addCell(2000, $styleCell)->addText(htmlspecialchars('Row 2'), $fontStyle);
$table->addCell(2000, $styleCell)->addText(htmlspecialchars('Row 3'), $fontStyle);
$table->addCell(2000, $styleCell)->addText(htmlspecialchars('Row 4'), $fontStyle);
$table->addCell(500, $styleCellBTLR)->addText(htmlspecialchars('Row 5'), $fontStyle);
for ($i = 1; $i <= 8; $i++) {
    $table->addRow();
    $cell="";
    if($i==2)
     {
        $cell = $data;
     }
    $table->addCell(2000)->addText(htmlspecialchars("Cell {$i}"));
    $table->addCell(2000)->addText(htmlspecialchars("Cell {$i}".$cell));
    $table->addCell(2000)->addText(htmlspecialchars("Cell {$i}"));
    $table->addCell(2000)->addText(htmlspecialchars("Cell {$i}"));
    $text = (0== $i % 2) ? 'X' : '';
    $table->addCell(500)->addText(htmlspecialchars($text));
}
        $phpWord->save('test.docx', 'Word2007', true);

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


       //dd($html);

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

                
                if($cols->item(1)->hasChildNodes()){
                    $images = $cols->item(1)->getElementsByTagName('img'); 


                    if($key=="a"){
                       echo $key. ' - '.$value.'<br>';
                    echo ($cols->item(1)->nodeValue);
                    echo "<br><br>";  
                    }
                    

                    foreach($images as $k=>$img){
                        

                        if($img->getAttribute('src')){

                            $src = $img->getAttribute('src');
                            if(strpos($src, 'http') !== false){

                            }else{
                               $url = word_imageupload(\auth::user(),$k,$img->getAttribute('src'));
                                $img->removeAttribute('src');
                                $img->setAttribute('src', $url);
                                $img->setAttribute('class', 'image');   
                            }
                                                  
                        }
                    }
                    foreach($images as $k=>$img)
                    if($img->getAttribute('src')){
                        $value = static::DOMinnerHTML($cols->item(1));
                        
                    }
                }

                if($c1=='SNO')
                {
                    $section[$key] = $value;
                }else if($c1=='QNO'){
                    $question[$key] = $value;
                }

               //  if($cols->item(1)->getElementsByTagName('img')){
               //     echo static::DOMinnerHTML($cols->item(1)); 
               //      echo "img here<br>";
               // }

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
       //dd($data);


       return $data;
       
    }

    public static function DOMinnerHTML(\DOMElement $element) 
    { 
        $innerHTML = ""; 
        $children  = $element->childNodes;

        foreach ($children as $child) 
        { 
            $innerHTML .= $element->ownerDocument->saveHTML($child);
        }

        return $innerHTML; 
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

        // $ques = null;
        // $ques = Question:where('reference',$question['qno'])->first();
        // if(!$ques){
        //     $ques = new Question();
        // }
        // $ques->reference = $question['qno'];
        // $ques->user_id = \Auth::user()->id;
        // $ques->question = $question['qno'];
        // $sec->mark = intval($section['mark']);
        // $sec->time = intval($section['time']);
        // $sec->mark = intval($section['negative']);
        // $sec->instructions = null;
        // $sec->save();

    }

    

}
