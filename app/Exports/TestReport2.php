<?php
namespace PacketPrep\Exports;

use PacketPrep\User;
use PacketPrep\Models\Exam\Tests_Overall;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Support\Facades\DB;

class TestReport2 implements FromCollection
{

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $exam = request()->session()->get('exam');
    	$users = request()->session()->get('users');
    	//$usr = User::whereIn('id',$users)->get();
   		$result = request()->session()->get('result');
   		$sections = request()->session()->get('sections');
   		$exam_sections = request()->session()->get('exam_sections');
        $colleges = request()->session()->get('colleges');
        $branches= request()->session()->get('branches');
        $email_stack= request()->session()->get('email_stack');

    	foreach($result as $k=>$res){

            if(!$res->code)
              $result[$k]->code = '---';

    		$result[$k]->Sno = $k+1;
            $result[$k]->uid = $res->user->id;
    		$result[$k]->Name = $res->user->name;

            if($res->user->college_id==5 || $res->user->college_id==295)
                    $result[$k]->college =  $res->user->info;
                else if(!$res->user->college_id)
                    $result[$k]->college  = '-';
                else
                    $result[$k]->college  = $colleges[$res->user->college_id]->name;


                if($res->user->branch_id){
                    if(isset($branches[$res->user->branch_id]))
                        $result[$k]->branch =  $branches[$res->user->branch_id]->name;
                    else
                        $result[$k]->branch = '-';
                }
                else
                    $result[$k]->branch = '-';

            if(isset($res->user->year_of_passing))
                $result[$k]->YOP = $res->user->year_of_passing;
            else
                $result[$k]->YOP = '-';


    		$result[$k]->Email = $res->user->email;
    		$result[$k]->Phone= $res->user->phone;
            $result[$k]->cheat_d = $res->window_change;
            if($res->cheat_detect==2)
            $result[$k]->cheating = 'Cheating - Not Clear';
            elseif($res->cheat_detect==1)
            $result[$k]->cheating = 'Potential Cheating';
            elseif($res->cheat_detect==3)
                $result[$k]->cheating ='--';
            else
              $result[$k]->cheating = 'No Cheating';

            foreach($exam_sections as $m=>$sec){
                    $name = $exam_sections[$m]['name'];
                     $result[$k]->$name = '- ';
                }

            if(isset($sections[$res->user->id]))
            foreach($sections[$res->user->id] as $m=>$sec){
                    if(isset($exam_sections[$m]['name'])){
                        $name = $exam_sections[$m]['name'];
                        if(intval(trim($sec->score))!=0)
                        $result[$k]->$name = $sec->score;
                        else
                        $result[$k]->$name = '0';
                    }

                }

            if(isset($sections[$res->user->id])){

            }else{


            }

           

            if(intval(trim($res->score))!=0)
    		  $result[$k]->Score = $res->score;
            else
               $result[$k]->Score = '0';

           if(floatval($res->max)==0)
                $res->max =1;
           $result[$k]->Percentage = round(floatval($res->score)/floatval($res->max)*100);
            $result[$k]->timer = round($result[$k]->time/60,2);

            if($res->user->fluency)
                $result[$k]->f= $res->user->fluency;
            else if(intval($res->user->confidence)>1000)
                $result[$k]->f = $res->user->confidence;
            else
                $result[$k]->f = $res->user->roll_number;


            if(request()->get('all')){
                $result[$k]->tenth = $res->user->tenth;
                $result[$k]->twelveth = $res->user->twelveth;
                $result[$k]->graduation = $res->user->bachelors;
                $result[$k]->hometown = $res->user->hometown;
                $result[$k]->current_city = $res->user->current_city;
            }


    		unset($result[$k]->id);
    		unset($result[$k]->user_id);
    		unset($result[$k]->test_id);
    		unset($result[$k]->unattempted);
    		unset($result[$k]->correct);
    		unset($result[$k]->incorrect);
    		unset($result[$k]->score);
            unset($result[$k]->window_change);
            unset($result[$k]->face_detect);
            unset($result[$k]->cheat_detect);
            unset($result[$k]->mobile_detect);
            unset($result[$k]->params);
            unset($result[$k]->shortlist);
    		unset($result[$k]->time);
    		unset($result[$k]->max);
            unset($result[$k]->comment);
    		unset($result[$k]->status);
    		unset($result[$k]->updated_at);
            if(isset($result[$k]->rollnumber))
             unset($result[$k]->rollnumber);
    	}



    	$ux = new Tests_Overall();
        $ux->created = "Timestamp";
        $ux->code = "Access Code";
    	$ux->sno = "Sno";
        $ux->uid = "UID";
    	$ux->name = "Name";
        $ux->college = "College";

        $ux->branch = "Branch";
        $ux->yop = "Year of Passing";
    	$ux->email = "Email";
    	$ux->phone = "Phone";
        $ux->cheat_d = "Window Swap";
        $ux->window = "Cheating";
    	foreach($exam_sections as $m=>$sec){
    			$name = $exam_sections[$m]['name'];
    			$ux->$name = $name. '('.$exam_sections[$m]['total'].')';
    		}

    	$ux->Sc = "Score (".$exam->total.")";
        $ux->Percentage = "Percentage";
         $ux->Timer = "Time spent (Minutes)";
      $ux->adm = "Roll Number";

      if(request()->get('all')){
        $ux->tenth = 'Class 10th';
        $ux->twelveth = 'Class 12th';
        $ux->graduation = 'Graduation';
        $ux->hometown = 'Hometown';
        $ux->current_city = 'Current City';
      }
    	unset($ux->id);
    		unset($ux->user_id);
    		unset($ux->test_id);
    		unset($ux->unattempted);
    		unset($ux->correct);
    		unset($ux->incorrect);
    		unset($ux->score);
    		unset($ux->time);
    		unset($ux->max);
            unset($ux->window_change);
            unset($ux->face_detect);
            unset($ux->cheat_detect);
            unset($ux->params);
            unset($ux->shortlist);

    		unset($ux->status);
    		unset($ux->created_at);
    		unset($ux->updated_at);

    	$result->prepend($ux);

        if(count($email_stack['not_registered']))
        foreach($email_stack['not_registered'] as $e){
            $ux = new Tests_Overall();
        $ux->created = "-";
         $ux->code = "-";
        $ux->sno = "-";
        $ux->uid = "-";
        $ux->name = "-";
        $ux->college = "-";

        $ux->branch = "-";
        $ux->yop = "-";
        $ux->email = $e;
        $ux->phone = "-";
        $ux->cheat_d = "-";
        $ux->window = "-";
        foreach($exam_sections as $m=>$sec){
                $name = $exam_sections[$m]['name'];
                $ux->$name = "-";
            }
        $ux->Sc = "ABSENT";
        $ux->Timer = "-";
        $ux->adm = "";

        unset($ux->id);
            unset($ux->user_id);
            unset($ux->test_id);
            unset($ux->unattempted);
            unset($ux->correct);
            unset($ux->incorrect);
            unset($ux->score);
            unset($ux->time);
            unset($ux->max);
            unset($ux->window_change);
            unset($ux->face_detect);
            unset($ux->cheat_detect);
            unset($ux->shortlist);
            unset($ux->params);
            unset($ux->status);
            unset($ux->created_at);
            unset($ux->updated_at);

        $result->push($ux);
        }

        return $result;
    }

}
