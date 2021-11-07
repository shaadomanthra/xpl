<?php

namespace PacketPrep\Models\Exam;

use Illuminate\Database\Eloquent\Model;
use PacketPrep\Models\Exam\Exam;
use PacketPrep\User;
use Illuminate\Support\Facades\Storage;

class Tests_Overall extends Model
{
    //
     protected $table = 'tests_overall';
      protected $fillable = [
        'user_id',
        'test_id',
        'unattempted',
        'correct',
        'incorrect',
        'score',
        'time',
        'code',
        'status',
        'window_change',
        'face_detect',
        'mobile_detect',
        'cheat_detect',
        'shortlist',
        'params',
    ];

    public function user(){
        return $this->belongsTo('PacketPrep\User');
    }

    public function exam(){
         $exam = Exam::where('id',$this->test_id)->first();
         return $exam;
    }

    public static function process_image($name){

        $p = explode('_', $name);

        $user = User::where('username',$p[0])->first();
        $exam = Exam::where('id',$p[1])->first();
        $t = Tests_Overall::where('user_id',$user->id)->where('test_id',$exam->id)->first();

        $filename = $name.'.jpg';
        $image = Storage::disk('s3')->get('webcam/'.$exam->id.'/'.$filename);

        $b64_image =base64_encode($image);

        // Get cURL resource
        $curl = curl_init();
        // Set some options - we are passing in a useragent too here

        $headers = [
          'Authorization: Token bba456d8-b9c9-4c80-bb84-39d44c5b0acb',
          'Content-type: application/json'
        ];

        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

        curl_setopt_array($curl, [
          CURLOPT_RETURNTRANSFER => 1,
          CURLOPT_URL => 'https://fd.p24.in/python',
          CURLOPT_POST => 1,
          CURLOPT_TIMEOUT => 30,
        ]);

        $form = array('name'=>$name,'image'=>$b64_image);

        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($form));

          // Send the request & save response to $resp
        $j = curl_exec($curl);
        //$json_file2=$p[0].'_'.$p[1].'_check.json';
        //Storage::disk('s3')->put('webcam/json/'.$json_file2,$j,'public');

          // Close request to clear up some resources
        curl_close($curl);

        $jsondata = json_decode($j,true);
        
        $f_name = $p[2];

        $json_file=$p[0].'_'.$p[1].'.json';
        if(Storage::disk('s3')->exists('webcam/'.$exam->id.'/json/'.$json_file)){
         $json = json_decode(Storage::disk('s3')->get('webcam/'.$exam->id.'/json/'.$json_file));
        }else{
         $app = app();
         $json = $app->make('stdClass');
        }

        $count = intval($jsondata['count']);
        $cell_phone =intval($jsondata['cell_phone']);

        if(isset($t->face_detect))
        if($t->face_detect<$count){
            $t->face_detect = $count;
            $t->mobile_detect = $cell_phone;

            if($count>1)
              $t->cheat_detect  = 1;

            if($cell_phone)
               $t->cheat_detect  = 1;

            $t->save();
        }
        
        if($jsondata['count'])
            $json->$f_name = $count;
        else
             $json->$f_name = 0;
           
        if($cell_phone)
            $json->mobile = $cell_phone;

        Storage::disk('s3')->put('webcam/'.$exam->id.'/json/'.$json_file,json_encode($json),'public');

      
        $data = $jsondata['image'];
        $data = base64_decode($data);
        Storage::disk('s3')->put('webcam/'.$exam->id.'/processed/'.$filename,$data,'public');
        
        return 1;
    }

    public static function export($data,$exams){
         
            //default columns names
            $columnNames =['sno','name','email','phone','group'];
            $jsonNames = [];
            //load new form fileds as columns
            foreach($exams as $e){
                array_push($columnNames,str_replace(' ','_',$e['name'].'('.$e['max'].')'));
        
            }
            if(!request()->get('status')){
                array_push($columnNames,'CGPA(10)');
            }

            $rows=[];
            $i=1;
            //dd($data);
            foreach($data as $k=>$r){

                //load the data
                $row=[($i++),$r['user']->name,$r['user']->email,$r['user']->phone,$r['user']->info];
                
                //dd($data);
                foreach($r['test'] as $ef=>$f){
                    if(!request()->get('status')){
                        if($f)
                        array_push($row,$f);
                        else if($f==0 || $f=='0' )
                           array_push($row,'0');   
                        else
                          array_push($row,'-');  
                  }else{
                    if($f)
                        array_push($row,'Attempted');
                    elseif($f=="0"){
                        array_push($row,'Attempted');
                    }
                         
                    else
                         array_push($row,'-'); 
                 
                  }
                }

                if(!request()->get('status')){
                    array_push($row,$r['cgpa']);
                }
                array_push($rows,$row);
            }

            //name the excel sheet based on tag/category/status/datefilter/user name
            $name_suffix = '';
            if(request()->get('exam'))
                $name_suffix = str_replace(',','-',request()->get('exam'));
            if(request()->get('info'))
                $name_suffix = $name_suffix.'_'.request()->get('info');
            if(request()->get('status')){
                $status =['0'=>'Attempts','1'=>'Attendance','on'=>'Attendance'];
                $name_suffix = $name_suffix.'_'.$status[request()->get('status')];
            }
            if(request()->get('user_id')){
                $username = User::where('id',request()->get('user_id'))->first()->name;
                $name_suffix = $name_suffix.'_'.$username;
            }


            return self::getCsv($columnNames, $rows,'data_'.strtotime("now").'_'.$name_suffix.'.csv');
    }


     public static function getCsv($columnNames, $rows, $fileName = 'file.csv') {
        $headers = [
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename=" . $fileName,
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        ];
        $callback = function() use ($columnNames, $rows ) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columnNames);
            foreach ($rows as $row) {
                fputcsv($file, $row);
            }
            fclose($file);
        };
        return response()->stream($callback, 200, $headers);
    }

}
