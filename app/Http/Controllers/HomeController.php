<?php

namespace PacketPrep\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use PacketPrep\Jobs\SendEmail;
use PacketPrep\Jobs\FaceDetect;
use PacketPrep\Mail\EmailForQueuing;
use PacketPrep\Models\Exam\Exam;
use PacketPrep\Models\College\College;
use PacketPrep\Models\Exam\Section;
use PacketPrep\Models\Exam\Tests_Overall;
use PacketPrep\User;
use Google\Cloud\Core\ServiceBuilder;  

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


    public function aws(){

        $url = '';//\App::call('PacketPrep\Http\Controllers\AwsController@getAwsUrl',[$name]);
        
        
        
        return view('appl.pages.about')->with('awstest',1)->with('url',$url);

    }


    public function contact(){

        if(subdomain()=='xplore')
        return view('appl.pages.xp.general.contact');
        else
            return redirect('/contactpage');
    }

    public function phpword(){

      
        //curl -v -X GET "https://westcentralus.api.cognitive.microsoft.com/vision/v3.2/read/analyzeResults/{operationId}" -H "Ocp-Apim-Subscription-Key: {subscription key}" --data-ascii "{body}" 

        if(!request()->get('url')){
            // set post fields
            //[img]https://i.imgur.com/kQLl0Or.jpg[/img]
            //[img]https://i.imgur.com/s1dxMw6.jpg[/img]
            //[img]https://i.imgur.com/PmPS7Iq.jpg[/img]
            $post = [
                'url' => 'https://i.imgur.com/p5O3PAE.jpg'
            ];
            $payload = json_encode( $post );

            $ch = curl_init('https://centralindia.api.cognitive.microsoft.com/vision/v3.2/read/analyze');

            curl_setopt( $ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json','Ocp-Apim-Subscription-Key:b0d522e12fb74962a8d829e0f3368fdb'));
            curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
            curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
            curl_setopt($ch, CURLOPT_HEADERFUNCTION,
                function ($curl, $header) use (&$headers) {
                    $len = strlen($header);
                    $header = explode(':', $header, 2);
                    if (count($header) < 2) // ignore invalid headers
                        return $len;

                    $headers[strtolower(trim($header[0]))][] = trim($header[1]);

                    return $len;
                }
            );
            $response = curl_exec($ch);
            curl_close($ch);
            $url = $headers['operation-location'][0];
            dd($url);
        }else{
            $url = request()->get('url');



            $ch = curl_init($url);

            curl_setopt( $ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json','Ocp-Apim-Subscription-Key:b0d522e12fb74962a8d829e0f3368fdb'));
            curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
           
            $response = json_decode(curl_exec($ch),true);

            $text ='';
            $lines = $response['analyzeResult']['readResults'][0]['lines'];
            foreach($lines as $l)
            {
                $text = $text.'<br>'.$l['text'];
            }
            echo ($text);
            curl_close($ch);
        }
        

       

        dd('none');
        $sec = new Section();
        $source = "Exam.docx";
        $name = 'docs/doc_'.\Auth::user()->id.'.html';
        $sec->wordToHtml($source,$name);

        $data = $sec->readHtmlTables(file_get_contents($name));

        dd($data);

    }


    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()

    {
        $this->middleware('auth');
        $users = User::where('year_of_passing',2022)->get()->groupBy('college_id');

        if(request()->get('location'))
            $college = College::where('location',request()->get('location'))->get();
        else
            $college = College::get();

        $data =[];
        $counter =0;
        foreach($college as $k=>$c){
            if(isset($users[$c->id]))
            $c->count = count($users[$c->id]);
            else
                $c->count =0;
            $data[$k] = $c;
            $counter = $counter +$c->count;
        }
       

        return view('home')->with('college',$data)->with('users',$users)->with('counter',$counter);
    }


    public function root(){
      if(\auth::user())
      {
        return redirect('/dashboard');
      }else{
          if( $_SERVER['HTTP_HOST'] == 'corporate.onlinelibrary.test' || $_SERVER['HTTP_HOST'] == 'onlinelibrary.test' || $_SERVER['HTTP_HOST'] == 'piofx.com' || $_SERVER['HTTP_HOST'] == 'p24.in')
          return view('piofx.front')->with('welcome',1);
         elseif($_SERVER['HTTP_HOST'] == 'xp.test' || $_SERVER['HTTP_HOST'] == 'xplore.co.in')
            return view('appl.pages.xp.index')->with('welcome3',1);
        elseif(subdomain()=='packetprep')
            return view('appl.pages.pp.index')->with('welcome3',1);
        elseif($_SERVER['HTTP_HOST'] == 'xplore.in.net'){
            echo "hello!";
            exit();
        }  
         else
             return view('client_welcome')->with('welcome3',1);
      }
    }

    public function testemail()
    {
        //s3_upload();
        $yop = request()->get('yop');


        if(!$yop)
          dd('yop not given');

        $start = request()->get('start');
        if(!$start)
          dd('start id not given');

        $end = request()->get('end');
        if(!$end)
          dd('end id not given');

        

        $users = \Auth::user()->select(['name','email'])
                ->where('year_of_passing',$yop)
                ->where('id','>',$start)
                ->where('id','<',$end)
                ->get();

        $count = request()->get('count');
        if($count)
          dd(count($users));

        $emails = [];
        foreach($users as $u){
          $email1 = ['name'=>$u->name, 'email'=>$u->email];
          array_push($emails, $email1);
        }

        //dd($emails);

        
        // $email6 = ['name'=>'KT', 'email'=>'shaadomanthra@gmail.com'];
        // $emails = [$email6];

        // $email3 = ['name'=>'Akhil', 'email'=>'akhil@xplore.co.in'];
        // $email4= ['name'=>'Akhil', 'email'=>'modheakhil@gmail.com'];
        // $email5= ['name'=>'Abhinav', 'email'=>'abhinavgoud.thippani@gmail.com'];
        // $email2 =['name'=>'Sunil', 'email'=>'sunil@acelinetech.com '];

        
        foreach($emails as $i=>$e){
            $details['email'] = $e['email'];
            $details['name'] = $e['name'];

            $subject = 'Requirement for angular & react developers - Pay after placement ';
            $content = '

<p>Our training partner ‘PacketPrep’ is doing job guaranteed training program with pay after placement model to full-fill the  requirements in angular & react technology at its partnered compaines.</p>

<p>Their recent placement drives include Machint solutions, Netenrich, Volksoft, ZenQ, Qualitlabs, Purpletalk, Magnaquest, Invesco, Innominds, Vitech and more..</p>

<p><b>The majority of the training fee can be paid after securing a job.</b></p>

<p>Watch the video promo for program: <br>
<a href="http://bit.ly/promofsd" >http://bit.ly/promofsd</a> </p>

<p>Interested candidates can apply here: <br>
<a href="http://bit.ly/fsdpp" >http://bit.ly/fsdpp</a> </p>

<p>For more details you can visit the website <a href="https://tech.packetprep.com" > https://tech.packetprep.com</a></p>
';

//             $subject = 'Immediate Requirement for Global Logic & Netenrich';
//             $content = '

// <p>Our clients Global Logic & Netenrich has an immediate requirement for 2018,2019 & 2020 graduates.</p>

// <p><b>Global Logic Requirement:</b></p>
// <p>Qualification:  Any Graduate<br>
// Year of Graduation: 2018-2020<br>
// Percentage Criteria: NA<br>
// Primary skills: Good Communication Skills<br>
// Role: Associate Analyst<br>
// Any Bond (Yes / No): No<br>
// Compensation: 1.85 LPA + Benefits (Two way cab + Food)<br>
// Work location: Hyderabad (Work From Home – Till the pandemic ends)<br>
// Shifts: Two Shifts (6 AM - 3 PM/3 PM - 12 AM)</p>


// <p>Interested candidates can apply here: <br>
// <a href="https://xplore.co.in/jobs/29457" >https://xplore.co.in/jobs/29457</a> </p>

// <p><b>Netenrich Requirement:</b></p>
// <p>Qualification : B.Tech – CSE/ECE/EEE/IT<br>
// Year of Graduation : 2020<br>
// Percentage Criterion : 70% Above<br>
// Primary skills : Python Knowledge or Trained candidates and should be interested to work on Automation Testing role.<br>
// Role : QA Automation<br>
// Any Bond (Yes / No ): NA<bR>
// Compensation : 2.5 LPA - 3.5 LPA<br>
// Work location : Hyderabad<br>
// Interview Location : Online – Teams meetings<br>

// Interview Process : 3 Levels of Discussion<br></p>


// <p>Interested candidates can apply here: <br>
// <a href="https://xplore.co.in/jobs/20307" >https://xplore.co.in/jobs/20307</a> </p>

// ';

            //Mail::to($details['email'])->send(new EmailForQueuing($details,$subject,$content));
            SendEmail::dispatch($details,$subject,$content)->delay(now()->addSeconds($i*1));
        }
        
        dd('Email Queued - year '.$yop.' - '. count($users) . ' mails Queued') ;
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
        
        $name = 'krishnateja_2763_001';
         $p = explode('_', $name);

        $user = User::where('username',$p[0])->first();
        //$exam = Exam::where('id',$p[1])->first();

        //$t = Tests_Overall::where('user_id',$user->id)->where('test_id',$exam->id)->first();


        $filename = $name.'.jpg';
        $filename_2 = $name.'_n.jpg';
        $image = Storage::disk('s3')->get('webcam/2763/'.$filename);

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

        
        Storage::disk('s3')->put('webcam/2763/check/'.$filename_2,$data,'public');
        
        return 1;

    }


    public function face_detect_image(Request $request){
        $count = $request->count;
        $username = $request->username;
        $test = $request->test;
        $key = $request->key;
        $m = (($key/$count) -1)*$count +1;
        $n=[$key];
        for($i=$m;$i<=$key;$i++){
          if(strlen($i)==1)
            $i='00'.$i;
          else if(strlen($i)==2)
            $i='0'.$i;
          $name = $username.'_'.$test.'_'.$i;
          //Tests_Overall::process_image($name);
          FaceDetect::dispatch($name)->delay(now()->addSeconds(1));
          break;
        }
        
        return json_encode($name);
    }

    public function webcam_upload(Request $request){
        $image = $request->image;
        $name = $request->name;  // your base64 encoded
        $username = $request->get('username');
        $message = $request->get('message');
        $time = $request->get('time');
        

        if($name)
            $filename = $name.'.jpg';
        else
            $filename = 'imagecam.jpg';

          $pieces = explode('_',$name);

        

        //save chat messages in cloud
        if($message){

          // save activity
          if(Storage::disk('s3')->exists('testlogs/chats/'.$pieces[1].'/'.$username.'.json')){
              $json = json_decode(Storage::disk('s3')->get('testlogs/chats/'.$pieces[1].'/'.$username.'.json'),true);
          }else{
              $json = null;
          }

          $json[strtotime("now")] = array("person"=>$pieces[0],"message"=>$message,"time"=>$time);
          Storage::disk('s3')->put('testlogs/chats/'.$pieces[1].'/'.$username.'.json',json_encode($json),'public');

          // save activity
          if(Storage::disk('s3')->exists('testlogs/chats/'.$pieces[1].'/proctor.json')){
              $json2 = json_decode(Storage::disk('s3')->get('testlogs/chats/'.$pieces[1].'/proctor.json'),true);
          }else{
              $json2 = null;
          }

          $json2[strtotime("now")] = array("person"=>$pieces[0],"message"=>$message,"time"=>$time);
          Storage::disk('s3')->put('testlogs/chats/'.$pieces[1].'/proctor.json',json_encode($json2),'public');

        }
        
        if($pieces[2]!='idcard' && $pieces[2]!='selfie')
          FaceDetect::dispatch($name)->delay(now()->addSeconds(2));
        else{
          if($pieces[2]=='selfie'){
            $jsonfile = 'approvals/'.$pieces[1].'.json';
            if(Storage::disk('s3')->exists('testlogs/'.$jsonfile)){
              $candidate  = json_decode(Storage::disk('s3')->get('testlogs/'.$jsonfile),true);
            }else{
                $candidate = [];
            }
            $candidate[$pieces[0]]['selfie'] = $filename;
            if(!isset($candidate[$pieces[0]]['idcard']))
              $candidate[$pieces[0]]['idcard'] = '';

            if(!isset($candidate[$pieces[0]]['approved']))
            $candidate[$pieces[0]]['approved'] = 0;

            $candidate[$pieces[0]]['timestamp'] = strtotime("now");

            Storage::disk('s3')->put('testlogs/'.$jsonfile, json_encode($candidate));
          }

          if($pieces[2]=='idcard'){

            if($request->image){
                $jsonfile = 'approvals/'.$pieces[1].'.json';
                if(Storage::disk('s3')->exists('testlogs/'.$jsonfile)){
                  $candidate  = json_decode(Storage::disk('s3')->get('testlogs/'.$jsonfile),true);
                
                }else{
                    $candidate = [];
                }
                $candidate[$pieces[0]]['idcard'] = $filename;
                if(!isset($candidate[$pieces[0]]['selfie']))
                  $candidate[$pieces[0]]['selfie'] = '';
                if(!isset($candidate[$pieces[0]]['approved']))
                $candidate[$pieces[0]]['approved'] = 0;

                $candidate[$pieces[0]]['timestamp'] = strtotime("now");

                Storage::disk('s3')->put('testlogs/'.$jsonfile, json_encode($candidate));

                $message['status'] = 0;
                $message['message'] = '';
                Storage::disk('s3')->put('testlogs/pre-message/'.$pieces[0].'.json', json_encode($message),'public');

            }else{
              $jsonfile = 'approvals/'.$pieces[1].'.json';
                if(Storage::disk('s3')->exists('testlogs/'.$jsonfile)){
                  $candidate  = json_decode(Storage::disk('s3')->get('testlogs/'.$jsonfile),true);
                
                }else{
                    $candidate = [];
                }
                $username = $request->get('username');
                $candidate[$username]['name'] =  $request->get('fullname');
                $candidate[$username]['rollnumber'] =  $request->get('roll');
                $candidate[$username]['college'] =  $request->get('college');
                $candidate[$username]['branch'] =  $request->get('branch');
                Storage::disk('s3')->put('testlogs/'.$jsonfile, json_encode($candidate));
                
            }


          }
        
        }
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
