<?php

namespace PacketPrep\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use PacketPrep\Jobs\SendEmail;
use PacketPrep\Jobs\FaceDetect;
use PacketPrep\Mail\EmailForQueuing;
use PacketPrep\Models\Exam\Exam;
use PacketPrep\Models\Exam\Tests_Overall;
use PacketPrep\User;

use Mail;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // this is a sample comment
        
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()

    {
        $this->middleware('auth');
        return view('home');
    }

    public function testemail()

    {
        //s3_upload();
        $email1 = ['name'=>'Krishna Teja', 'email'=>'packetcode@gmail.com'];
        $email6 = ['name'=>'KT', 'email'=>'shaadomanthra@gmail.com'];
        $email3 = ['name'=>'Akhil', 'email'=>'akhil@xplore.co.in'];
        $email4= ['name'=>'Akhil', 'email'=>'modheakhil@gmail.com'];
        $email5= ['name'=>'Abhinav', 'email'=>'abhinavgoud.thippani@gmail.com'];
        $email2 =['name'=>'Sunil', 'email'=>'sunil@acelinetech.com '];

        $emails = [$email1,$email2,$email3,$email4,$email5,$email6];
        foreach($emails as $i=>$e){
            $details['email'] = $e['email'];
            $details['name'] = $e['name'];

            //Mail::to($details['email'])->send(new EmailForQueuing($details));
            SendEmail::dispatch($details)->delay(now()->addSeconds($i*3));
        }
        
        dd('Email Queued');
        return view('home');
    }

    

    public function imageupload(Request $request){

        //dd($request->all());
        if(count($request->all())){
            echo 'one';dd();
            $image = $request->image;  // your base64 encoded
        $image = str_replace('data:image/jpeg;base64,', '', $image);
        $image = str_replace(' ', '+', $image);

        $file      = $request->all()['image'];
        $filename = 'image.'.$file->getClientOriginalExtension();
        $path = Storage::disk('public')->putFileAs('articles', base64_decode($image),$filename);
        echo $path;
            /*
        $file      = $request->all()['image'];
        $filename = 'image.'.$file->getClientOriginalExtension();
        $path = Storage::disk('public')->putFileAs('articles', $request->file('image'),$filename);
        echo $path;*/
        }else
        {
            return view('appl.video.camera')->with('camera',1);
        }

    }

     public function process_image(Request $request){
        
        $name = 'pranithadasari123_356_3';
         $p = explode('_', $name);

        $user = User::where('username',$p[0])->first();
        //$exam = Exam::where('id',$p[1])->first();

        //$t = Tests_Overall::where('user_id',$user->id)->where('test_id',$exam->id)->first();

        $filename = $name.'.jpg';
        $image = Storage::disk('s3')->get('webcam/'.$filename);

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
          
          // Close request to clear up some resources
          curl_close($curl);

          $jsondata = json_decode($j,true);
        
        
        // $f_name = $p[2];

        // $json_file=$p[0].'_'.$p[1].'.json';
        // if(Storage::disk('s3')->exists('webcam/json/'.$json_file)){
        //  $json = json_decode(Storage::disk('s3')->get('webcam/json/'.$json_file));
        // }else{
        //  $app = app();
        //  $json = $app->make('stdClass');
        // }

        // $count = intval($jsondata['count']);

        // if(isset($t->face_detect))
        // if($t->face_detect<$count){
        //     $t->face_detect = $count;
        //     $t->save();
        // }
        
        // if($jsondata['count'])
        //     $json->$f_name = $count;
        // else
        //      $json->$f_name = 0;
        // Storage::disk('s3')->put('webcam/json/'.$json_file,json_encode($json),'public');

      
        $data = $jsondata['image'];
        $data = base64_decode($data);
        Storage::disk('s3')->put('webcam/'.$filename,$data,'public');
        
        return 1;

    }

    public function webcam_upload(Request $request){
        $image = $request->image;
        $name = $request->name;  // your base64 encoded
        $image = str_replace('data:image/jpeg;base64,', '', $image);
        $image = str_replace(' ', '+', $image);

        $image = base64_decode($image);

        if($name)
            $filename = $name.'.jpg';
        else
            $filename = 'imagecam.jpg';
        
        //Storage::disk('s3')->putFileAs('webcam',(string)$image,$filename);
        Storage::disk('s3')->put('webcam/'.$filename, (string)$image,'public');
        echo 'uploaded - '.$filename;
        FaceDetect::dispatch($name)->delay(now()->addSeconds(5));
        exit();
    }

     public function iupload(Request $request){
        echo 'apple';
        dd();
        //dd($request->all());
        if(count($request->all())){
            echo 'one';dd();
            $image = $request->image;  // your base64 encoded
        $image = str_replace('data:image/jpeg;base64,', '', $image);
        $image = str_replace(' ', '+', $image);

        $file      = $request->all()['image'];
        $filename = 'image.'.$file->getClientOriginalExtension();
        $path = Storage::disk('public')->putFileAs('articles', base64_decode($image),$filename);
        echo $path;
            /*
        $file      = $request->all()['image'];
        $filename = 'image.'.$file->getClientOriginalExtension();
        $path = Storage::disk('public')->putFileAs('articles', $request->file('image'),$filename);
        echo $path;*/
        }else
        {
            return view('appl.video.camera')->with('camera',1);
        }

    }
}
