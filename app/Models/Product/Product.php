<?php

namespace PacketPrep\Models\Product;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class Product extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'description',
        'price',
        'status',
        'discount'

        // add all other fields
    ];

    public function users(){
        return $this->belongsToMany('PacketPrep\User');
    }

    public function exams(){
        return $this->belongsToMany('PacketPrep\Models\Exam\Exam');
    }

    public function courses(){
        return $this->belongsToMany('PacketPrep\Models\Course\Course');
    }

     public function service()
    {
        return $this->hasOne('PacketPrep\Models\College\Service');
    }

    public static function  update_pivot($product_id,$user_id,$validity,$status,$valid_till){

        
        return DB::table('product_user')
                ->where('user_id', $user_id)
                ->where('product_id', $product_id)
                ->update(['validity' => $validity,'status' => $status,'valid_till' => $valid_till]);

    }

    public function validityExpired(){

        $product_id = $this->id;
        $user_id = \auth::user()->id;

        $entry = DB::table('product_user')
                ->where('product_id', $product_id)
                ->where('user_id', $user_id)
                ->first();

        

        if(strtotime($entry->valid_till) > strtotime(date('Y-m-d')) && $entry->status==1)
            return false;
        else
            return true;

    }


    public static function process_image($name){

        $filename = $name.'.jpg';
        $image = Storage::disk('s3')->get('webcam/'.$filename);

        $b64_image =base64_encode($image);



          // Get cURL resource
          $curl = curl_init();
          // Set some options - we are passing in a useragent too here

          curl_setopt_array($curl, [
              CURLOPT_RETURNTRANSFER => 1,
              CURLOPT_URL => 'http://yolo.packetprep.com',
              CURLOPT_POST => 1,
              CURLOPT_TIMEOUT => 30,
          ]);

          $form = array('name'=>$name,'image'=>$b64_image);

          curl_setopt($curl, CURLOPT_POSTFIELDS, $form);

          // Send the request & save response to $resp
          $j = curl_exec($curl);
          
          // Close request to clear up some resources
          curl_close($curl);

          $jsondata = json_decode($j,true);
        
        $p = explode('_', $name);
        $f_name = $p[2];

        $json_file=$p[0].'_'.$p[1].'.json';
        if(Storage::disk('s3')->exists('webcam/json/'.$json_file)){
         $json = json_decode(Storage::disk('s3')->get('webcam/json/'.$json_file));
        }else{
         $app = app();
         $json = $app->make('stdClass');
        }
        
        if($jsondata['count'])
        $json->$f_name = intval($jsondata['count']);
        else
             $json->$f_name = 0;
        Storage::disk('s3')->put('webcam/json/'.$json_file,json_encode($json),'public');

      
        $data = $jsondata['image'];
        $data = base64_decode($data);
        Storage::disk('s3')->put('webcam/'.$filename,$data,'public');
        
        return 1;
    }
}
