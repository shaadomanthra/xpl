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
        'cheat_detect'
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
          CURLOPT_URL => 'https://api.p24.in/python',
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
        Storage::disk('s3')->put('webcam/'.$exam->id.'/'.$filename,$data,'public');
        
        return 1;
    }

}
