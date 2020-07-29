<?php

namespace PacketPrep\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use PacketPrep\Jobs\SendEmail;

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
        $details = ['email' => 'packetcode@gmail.com',
                    'bcc'=>['shaadomanthra@gmail.com']];
        SendEmail::dispatch($details);
        dd('Email Queued');
        return view('home');
    }

    public function process_image(Request $request){
        $start_time = microtime(true); 
        $name = $request->get('name');
        if($name){

        $image = Storage::disk('s3')->get('webcam/'.$name.'.jpg');

        Storage::disk('public')->putFileAs('webcam/'.$name.'.jpg');

        \File::move($filename, '../storage/app/public/tests/'.$filename);

        $pat = Storage::disk('local')->getDriver()->getAdapter()->getPathPrefix();

        $path = $pat.'public/tests/'.$filename;

        
        
        $cmd = 'python3 camera/faceapp/fc1.py '.$path.' h.xml';
        $count = shell_exec($cmd);
        $end_time = microtime(true); 
          
        // Calculate script execution time 
        $execution_time = ($end_time - $start_time); 
        
        $p = explode('_', $name);
        $json_file = $pat.'public/tests/json/'.$p[0].'_'.$p[1].'.json';
        $f_name = $p[2];

        if(file_exists($json_file)){
         $json = json_decode(file_get_contents($json_file));
        }else{
         $app = app();
         $json = $app->make('stdClass');
        }
        
        $json->$f_name = $count;
        file_put_contents($json_file, json_encode($json));

        }

        return 1;

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
