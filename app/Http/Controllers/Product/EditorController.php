<?php
namespace PacketPrep\Http\Controllers\Product;

use Illuminate\Http\Request;
use PacketPrep\Http\Controllers\Controller;
use PacketPrep\Models\Product\Test;
use PacketPrep\Models\Exam\Tests_Overall;
use PacketPrep\Models\Exam\Tests_Section;
use PacketPrep\Models\Exam\Section;
use PacketPrep\Models\Exam\Exam;
use PacketPrep\Models\Dataentry\Question;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Cache;

class EditorController extends Controller
{
    public function tcscode(Request $request)
    {
    	$cpp =$data =null;
        return view('appl.product.editor.tcscode')
                ->with('editor',true)
                ->with('code',true)
                ->with('cpp',$cpp)
                ->with('data',$data);
    }

    public function tcstestcase(Request $request)
    {
    	$code = $request->get('code');
      $name = $request->get('name');
    	if($request->get('testcase')==1){
    		$input = 14;
    		$output = "17";
    	}
    	elseif($request->get('testcase')==2){
    		$input = 5;
    		$output = "2";
    	}else{
    		$input = 10;
    		$output = "11";

    	}
    	$data = $this->run_internal_p24($code,$input,'clang',1,$name);

    	$json = json_decode($data);
      $json->name = $name;
      if(isset($json->stderr)){
    		$json->input = $input;

        if($json->stdout == $output)
          $json->success = 1;
        else
          $json->success = 0;
        print json_encode($json);
      }
    	else if(isset($json->stdout)){
        $json->input = $input;
    		if($json->stdout == $output)
    			$json->success = 1;
    		else
    			$json->success = 0;

    		print json_encode($json);

    	}else{
        $json->success= 2;
        $json->input = $input;
        print json_encode($json);
      }

    }

    public function runcode(Request $request)
    {
      $code = $request->get('code');
      $name = $request->get('name');
      
      $input = $request->get('input');
      $lang = $request->get('lang');
      $c = $request->get('c');
      $data = $this->run_internal_p24($code,$input,$lang,$c,$name);
      //$data = $this->run_internal($code,$input);
      
      print $data;

    }

    public function stopcode(Request $request)
    {
      $name = $request->get('name');
      
      // Get cURL resource
      $curl = curl_init();
      // Set some options - we are passing in a useragent too here

      curl_setopt_array($curl, [
          CURLOPT_RETURNTRANSFER => 1,
          CURLOPT_URL => 'http://code.p24.in/stopdockerid.php',
          CURLOPT_POST => 1,
      ]);

      $form = array('name'=>$name);
    
    
      //$data ='{"files": [{"name": "main.c", "content": '.$code.'}]}';
      //echo $data;
      curl_setopt($curl, CURLOPT_POSTFIELDS, $form);

      // Send the request & save response to $resp
      $data = curl_exec($curl);
      
      // Close request to clear up some resources
      curl_close($curl);

      return $data;

    }


    public function autoruncode(Request $request)
    {

      
      return (new Exam)->runCode($request);
      //print $json;

    }


    public function tcscode_one(Request $request)
    {
      $cpp =$data =null;
        return view('appl.product.editor.tcscode_one')
                ->with('editor',true)
                ->with('code',true)
                ->with('cpp',$cpp)
                ->with('data',$data);
    }

    public function tcstestcase_one(Request $request)
    {
      $code = $request->get('code');
      if($request->get('testcase')==1){
        $input = 4;
        $output = 1;
      }
      elseif($request->get('testcase')==2){
        $input = 5;
        $output = 0;
      }else{
        $input = 10;
        $output = 1;

      }
      $name = $request->get('name');
      $data = $this->run_internal_p24($code,$input,'clang',1,$name);
      $json = json_decode($data);
      $json->name = $name;
      if(isset($json->stderr)){
        $json->input = $input;

        if($json->stdout == $output)
          $json->success = 1;
        else
          $json->success = 0;
        print json_encode($json);
      }
      else if(isset($json->stdout)){
        $json->input = $input;
        if($json->stdout == $output)
          $json->success = 1;
        else
          $json->success = 0;

        print json_encode($json);

      }else{
        $json->success= 2;
        $json->input = $input;
        print json_encode($json);
      }

    }

    public function tcscode_two(Request $request)
    {
      $cpp =$data =null;
        return view('appl.product.editor.tcscode_two')
                ->with('editor',true)
                ->with('code',true)
                ->with('cpp',$cpp)
                ->with('data',$data);
    }

    public function tcstestcase_two(Request $request)
    {
      $code = $request->get('code');
      if($request->get('testcase')==1){
        $input = 14;
        $output = 17;
      }
      elseif($request->get('testcase')==2){
        $input = 5;
        $output = 2;
      }else{
        $input = 10;
        $output = 11;

      }
      $name = $request->get('name');
      $data = $this->run_internal_p24($code,$input,'clang',1,$name);
      $json = json_decode($data);
      $json->name = $name;
      if(isset($json->stderr)){
        $json->input = $input;

        if($json->stdout == $output)
          $json->success = 1;
        else
          $json->success = 0;
        print json_encode($json);
      }
      else if(isset($json->stdout)){
        $json->input = $input;
        if($json->stdout == $output)
          $json->success = 1;
        else
          $json->success = 0;

        print json_encode($json);

      }else{
        $json->success= 2;
        $json->input = $input;
        print json_encode($json);
      }


    }

    public function run_internal($code,$input){


      // Get cURL resource
      $curl = curl_init();
      // Set some options - we are passing in a useragent too here

      $code = json_encode($code);

      $headers = [
          'Authorization: Token bba456d8-b9c9-4c80-bb84-39d44c5b0acb',
          'Content-type: application/json'
      ];

      curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
      curl_setopt_array($curl, [
          CURLOPT_RETURNTRANSFER => 1,
          CURLOPT_URL => 'https://run.glot.io/languages/c/latest',
          CURLOPT_POST => 1,
      ]);

     // $data ='{"command": "clang main.c && ./a.out '.$input.'","files": [{"name": "main.c", "content": '.$code.'}]}';

      $data ='{"command": "clang main.c && ./a.out '.$input.'","files": [{"name": "main.c", "content": '.$code.'}]}';
      //$data ='{"files": [{"name": "main.c", "content": '.$code.'}]}';
      //echo $data;
      curl_setopt($curl, CURLOPT_POSTFIELDS, $data);

      // Send the request & save response to $resp
      $data = curl_exec($curl);
      
      // Close request to clear up some resources
      curl_close($curl);

      return $data;

    }

    public function run_internal_p24($code,$input,$lang,$c,$name){

      $name = request()->get('name');
      $testcase = request()->get('testcase');
      $test = request()->get('test');
      $qslug = request()->get('qslug');


      $exam = Cache::get('test_'.$test);

      if(!$exam){
        $exam = Exam::where('slug',$test)->with('sections')->first();
        if(!$exam){
          $q = Question::where('slug',$qslug)->first();
          $testcases = json_decode($q->a,true);
        }
      }

      if(!$name){
        $name = substr(md5(time()), 0,7);
      }

      $name = $name.'_'.substr(md5(time()), 0,7);

      $questions = [];
      if($exam)
      foreach($exam->sections as $section){
            foreach($section->questions as $q){

              if($qslug == $q->slug){
                //dd($q);
                $testcases = json_decode($q->a,true);
                break;
              }
            }

      }

      if($testcase =="1")
      {
        $input = $testcases['in_1'];
        $data['pass_1'] = 0;
        
        //$code =trim(preg_replace('/\s\s+/', ' ', $code));
        //$code=str_replace("\r\n","\\\r\n",$code);
        
        //$code = addslashes(addslashes($code)); 
        //dd($code);
        
        $data['response_1'] = json_decode($this->curl_req($c,$lang,$code,$name,$input),true);

        
        
        if(isset($data['response_1']['stdout'])){
          $resp = trim(str_replace(array("\n", "\r"), '', $data['response_1']['stdout']));
          $output = trim(str_replace(array("\n", "\r"), '', $testcases['out_1']));
          if($resp == $output){
            $data['pass_1'] = 1;
          }
        }
        
      }else{
        $input = $testcases['in_1'];
        $data['pass_1'] = 0;
        $data['response_1'] = json_decode($this->curl_req($c,$lang,$code,$name.'_1',$input),true);

        if(isset($data['response_1']['stdout'])){
          $resp = trim(str_replace(array("\n", "\r"), '', $data['response_1']['stdout']));
          $output = trim(str_replace(array("\n", "\r"), '', $testcases['out_1']));
          if($resp == $output){
            $data['pass_1'] = 1;
          }
        }
        
        if(!isset($testcases['in_2'])){
          $data['pass_2'] = $data['pass_1'];
          $data['response_2'] = $data['response_1'];
        }else{
          

          if(!(trim($testcases['in_2']))){
            $data['pass_2'] = $data['pass_1'];
            $data['response_2'] = $data['response_1'];
          }else{
            
            $input = $testcases['in_2'];
            $data['pass_2'] = 0;

            $data['response_2'] = json_decode($this->curl_req($c,$lang,$code,$name.'_2',$input),true);
            if(isset($data['response_2']['stdout'])){
              $resp = trim(str_replace(array("\n", "\r"), '', $data['response_2']['stdout']));
              $output = trim(str_replace(array("\n", "\r"), '', $testcases['out_2']));
              if($resp == $output){
                $data['pass_2'] = 1;
              }
            }
          }
        }
        
        if(!isset($testcases['in_3'])){
          $data['pass_3'] = $data['pass_1'];
          $data['response_3'] = $data['response_1'];
        }else{

          

          if(!(trim($testcases['in_3']))){
            $data['pass_3'] = $data['pass_1'];
            $data['response_3'] = $data['response_1'];
          }else{
            
            $input = $testcases['in_3'];
            $data['pass_3'] = 0;

            $data['response_3'] = json_decode($this->curl_req($c,$lang,$code,$name.'_3',$input),true);
            if(isset($data['response_3']['stdout'])){
              $resp = trim(str_replace(array("\n", "\r"), '', $data['response_3']['stdout']));
              $output = trim(str_replace(array("\n", "\r"), '', $testcases['out_3']));
              if($resp == $output){
                $data['pass_3'] = 1;
              }
            }
          }


        }

        if(!isset($testcases['in_4'])){
          $data['pass_4'] = $data['pass_1'];
          $data['response_4'] = $data['response_1'];
        }else{

          if(!(trim($testcases['in_4']))){
            $data['pass_4'] = $data['pass_1'];
            $data['response_4'] = $data['response_1'];
          }else{
            
            $input = $testcases['in_4'];
            $data['pass_4'] = 0;

            $data['response_4'] = json_decode($this->curl_req($c,$lang,$code,$name.'_4',$input),true);
            if(isset($data['response_4']['stdout'])){
              $resp = trim(str_replace(array("\n", "\r"), '', $data['response_4']['stdout']));
              $output = trim(str_replace(array("\n", "\r"), '', $testcases['out_4']));
              if($resp == $output){
                $data['pass_4'] = 1;
              }
            }
          }

            

        }

        if(!isset($testcases['in_5'])){
          $data['pass_5'] = $data['pass_1'];
          $data['response_5'] = $data['response_1'];
        }else{

          if(!(trim($testcases['in_5']))){
            $data['pass_5'] = $data['pass_1'];
            $data['response_5'] = $data['response_1'];
          }else{
            $input = $testcases['in_5'];
            $data['pass_5'] = 0;

            $data['response_5'] = json_decode($this->curl_req($c,$lang,$code,$name.'_5',$input),true);
            if(isset($data['response_5']['stdout'])){
              $resp = trim(str_replace(array("\n", "\r"), '', $data['response_5']['stdout']));
              $output = trim(str_replace(array("\n", "\r"), '', $testcases['out_5']));
              if($resp == $output){
                $data['pass_5'] = 1;
              }
            }
          }
          
        }
        

        

      }

      $data = json_encode($data,JSON_PRETTY_PRINT);
     

      return $data;


    }

   


    public function curl_req($c,$lang,$code,$name,$input){

      // Get cURL resource
      $curl = curl_init();
      // Set some options - we are passing in a useragent too here

      curl_setopt_array($curl, [
          CURLOPT_RETURNTRANSFER => 1,
          CURLOPT_URL => 'https://api.p24.in',
          CURLOPT_POST => 1,
      ]);

      

      $form = array('hash'=>'krishnateja','c'=>$c,'docker'=>'1','lang'=>$lang,'form'=>'1','code'=>$code,'input'=>$input,'name'=>$name);
    
      
      if($_SERVER['HTTP_HOST'] == 'xplore.in.net'){
          dd(json_encode($form));
        }
      //$data ='{"files": [{"name": "main.c", "content": '.$code.'}]}';
      
      curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($form));
      curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));


      // Send the request & save response to $resp
      $data = curl_exec($curl);

     
      // Close request to clear up some resources
      curl_close($curl);
      return $data;

    }

    public function stop(){
      $name = request()->get('name');

      $curl = curl_init();
      // Set some options - we are passing in a useragent too here

      curl_setopt_array($curl, [
          CURLOPT_RETURNTRANSFER => 1,
          CURLOPT_URL => 'http://krishnateja.in/stopdocker.php',
          CURLOPT_POST => 1,
      ]);

      $form = array('name'=>$name);
    
    
      //$data ='{"files": [{"name": "main.c", "content": '.$code.'}]}';
      //echo $data;
      curl_setopt($curl, CURLOPT_POSTFIELDS, $form);

      // Send the request & save response to $resp
      $data = curl_exec($curl);
      
      // Close request to clear up some resources
      curl_close($curl);
    }

    public function remove(){
      $curl = curl_init();
      // Set some options - we are passing in a useragent too here

      curl_setopt_array($curl, [
          CURLOPT_RETURNTRANSFER => 1,
          CURLOPT_URL => 'http://krishnateja.in/removedocker.php',
          CURLOPT_POST => 1,
      ]);

      $form = array('name'=>'');
    
    
      //$data ='{"files": [{"name": "main.c", "content": '.$code.'}]}';
      //echo $data;
      curl_setopt($curl, CURLOPT_POSTFIELDS, $form);

      // Send the request & save response to $resp
      $data = curl_exec($curl);
      
      // Close request to clear up some resources
      curl_close($curl);
    }

    public function run(Request $request){

      $code = $request->get('code');
      $input = $request->get('input');

      // Get cURL resource
      $curl = curl_init();
      // Set some options - we are passing in a useragent too here

      $code = json_encode($code);

      $headers = [
          'Authorization: Token bba456d8-b9c9-4c80-bb84-39d44c5b0acb',
          'Content-type: application/json'
      ];

      curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
      curl_setopt_array($curl, [
          CURLOPT_RETURNTRANSFER => 1,
          CURLOPT_URL => 'https://run.glot.io/languages/c/latest',
          CURLOPT_POST => 1,
      ]);

      $data ='{"command": "clang main.c && ./a.out '.$input.'","files": [{"name": "main.c", "content": '.$code.'}]}';
      //$data ='{"files": [{"name": "main.c", "content": '.$code.'}]}';
      //echo $data;
      curl_setopt($curl, CURLOPT_POSTFIELDS, $data);

      // Send the request & save response to $resp
      print(curl_exec($curl));
      
      // Close request to clear up some resources
      curl_close($curl);

    }


    
  
}
