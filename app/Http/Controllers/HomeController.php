<?php

namespace PacketPrep\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use PacketPrep\Jobs\SendEmail;
use PacketPrep\Jobs\FaceDetect;
use PacketPrep\Mail\EmailForQueuing;
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
