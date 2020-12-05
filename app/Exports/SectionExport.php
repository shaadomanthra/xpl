<?php

namespace PacketPrep\Exports;

use PacketPrep\Tests;
use Maatwebsite\Excel\Concerns\FromCollection;

class SectionExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $users = request()->session()->get('users');
   		$result = request()->session()->get('sections');
        $ques = request()->session()->get('questions');
        

    	foreach($result as $k=>$res){

           

    		$result[$k]->Sno = $k+1;
            $result[$k]->uid = $res->user->id;
    		$result[$k]->Name = $res->user->name;
    		$result[$k]->Email = $res->user->email;
            $result[$k]->question = $ques[$res->question_id]->question;
            $result[$k]->responsed = strip_tags($res->response);

    		unset($result[$k]->id);
    		unset($result[$k]->user_id);
    		unset($result[$k]->test_id);
            unset($result[$k]->section_id);
            unset($result[$k]->question_id);
    		unset($result[$k]->answer);
    		unset($result[$k]->accuracy);
            unset($result[$k]->response);
    		unset($result[$k]->time);
    		unset($result[$k]->created_at);
            unset($result[$k]->dynamic);
            unset($result[$k]->code);
            unset($result[$k]->mark);
            unset($result[$k]->comment);
    		unset($result[$k]->images);

    		unset($result[$k]->status);
    		unset($result[$k]->updated_at);
    	}



    	// $ux = new Tests_Overall();
     //    $ux->created = "Timestamp";
     //    $ux->code = "Access Code";
    	// $ux->sno = "Sno";
     //    $ux->uid = "UID";
    	// $ux->name = "Name";
     //    $ux->college = "College";

     //    $ux->branch = "Branch";
     //    $ux->yop = "Year of Passing";
    	// $ux->email = "Email";
    	// $ux->phone = "Phone";
     //    $ux->cheat_d = "Window Swap";
     //    $ux->window = "Cheating";
    	// foreach($exam_sections as $m=>$sec){
    	// 		$name = $exam_sections[$m]['name'];
    	// 		$ux->$name = $name;
    	// 	}
    	// $ux->Sc = "Score";
     //  $ux->adm = "Admission Number";


    	// unset($ux->id);
    	// 	unset($ux->user_id);
    	// 	unset($ux->test_id);
    	// 	unset($ux->unattempted);
    	// 	unset($ux->correct);
    	// 	unset($ux->incorrect);
    	// 	unset($ux->score);
    	// 	unset($ux->time);
    	// 	unset($ux->max);
     //        unset($ux->window_change);
     //        unset($ux->face_detect);
     //        unset($ux->cheat_detect);

    	// 	unset($ux->status);
    	// 	unset($ux->created_at);
    	// 	unset($ux->updated_at);

    	// $result->prepend($ux);

     //    if(count($email_stack['not_registered']))
     //    foreach($email_stack['not_registered'] as $e){
     //        $ux = new Tests_Overall();
     //    $ux->created = "-";
     //     $ux->code = "-";
     //    $ux->sno = "-";
     //    $ux->uid = "-";
     //    $ux->name = "-";
     //    $ux->college = "-";

     //    $ux->branch = "-";
     //    $ux->yop = "-";
     //    $ux->email = $e;
     //    $ux->phone = "-";
     //    $ux->cheat_d = "-";
     //    $ux->window = "-";
     //    foreach($exam_sections as $m=>$sec){
     //            $name = $exam_sections[$m]['name'];
     //            $ux->$name = "-";
     //        }
     //    $ux->Sc = "ABSENT";
     //    $ux->adm = "";

     //    unset($ux->id);
     //        unset($ux->user_id);
     //        unset($ux->test_id);
     //        unset($ux->unattempted);
     //        unset($ux->correct);
     //        unset($ux->incorrect);
     //        unset($ux->score);
     //        unset($ux->time);
     //        unset($ux->max);
     //        unset($ux->window_change);
     //        unset($ux->face_detect);
     //        unset($ux->cheat_detect);
     //        unset($ux->status);
     //        unset($ux->created_at);
     //        unset($ux->updated_at);

     //    $result->push($ux);
     //    }

        return $result;
    }
}
